const AWS = require('aws-sdk');
const ffmpeg = require('fluent-ffmpeg');
const axios = require('axios');
const { PassThrough } = require('stream');
const { generateAIContent } = require('../services/openAI');
const FormData = require('form-data');

if (process.env.NODE_ENV !== 'production') {
    require('dotenv').config();
    const basePath = 'C:/laragon/www/innoboxrr/packages/laravel-blog/.lambda/laravel-blog-post-ai/bin/ffmpeg';
    ffmpeg.setFfmpegPath(`${basePath}/ffmpeg.exe`);
    ffmpeg.setFfprobePath(`${basePath}/ffprobe.exe`);
} else {
    ffmpeg.setFfmpegPath('/opt/bin/ffmpeg/ffmpeg');
    ffmpeg.setFfprobePath('/opt/bin/ffprobe');
}

// Configuración de AWS S3
AWS.config.update({
    accessKeyId: process.env.EAWS_ACCESS_KEY_ID,
    secretAccessKey: process.env.EAWS_SECRET_ACCESS_KEY,
    region: process.env.EAWS_REGION,
});

const s3 = new AWS.S3();

// Función para descargar un archivo desde una URL en S3
const downloadFromS3Url = async (s3Url) => {
    console.log(`Descargando archivo desde URL S3: ${s3Url}`);
    const { Bucket, Key } = getBucketAndKeyFromUrl(s3Url);
    return s3.getObject({ Bucket, Key }).createReadStream();
};

// Extraer bucket y key desde una URL de S3
const getBucketAndKeyFromUrl = (url) => {
    const subdomainStyle = /^https:\/\/([^.]+)\.s3\.[^.]+\.amazonaws\.com\/(.+)$/;

    const match = url.match(subdomainStyle);

    if (match) {
        const [, Bucket, Key] = match;
        return { Bucket, Key };
    } else {
        throw new Error('URL de S3 inválida o no compatible.');
    }
};

// Función para extraer audio de un video
const extractAudio = async (videoStream) => {
    console.log('Extrayendo audio con ffmpeg...');
    return new Promise((resolve, reject) => {
        const audioChunks = [];
        const outputStream = new PassThrough();

        outputStream.on('data', (chunk) => audioChunks.push(chunk));
        outputStream.on('end', () => resolve(Buffer.concat(audioChunks)));
        outputStream.on('error', reject);

        ffmpeg()
            .input(videoStream)
            .outputFormat('mp3')
            .on('error', reject)
            .pipe(outputStream);
    });
};

// Función para transcribir audio con OpenAI Whisper
const transcribeAudio = async (audioStream) => {
    console.log('Transcribiendo audio con OpenAI Whisper...');
    const formData = new FormData();
    formData.append('file', audioStream, {
        filename: 'audio.mp3',
        contentType: 'audio/mp3',
    });
    formData.append('model', 'whisper-1');
    formData.append('response_format', 'vtt');

    const response = await axios.post('https://api.openai.com/v1/audio/transcriptions', formData, {
        headers: {
            ...formData.getHeaders(),
            Authorization: `Bearer ${process.env.OPENAI_API_KEY}`,
        },
    });

    console.log('Transcripción exitosa.');
    return response.data;
};

// Función principal
const processVideo = async ({ s3Url, rewrite = false, useHTML = false }) => {
    try {
        console.log(`Procesando video desde URL S3: ${s3Url}`);
        const videoStream = await downloadFromS3Url(s3Url);

        // Extraer audio
        const audioBuffer = await extractAudio(videoStream);

        // Transcribir audio
        const subtitles = await transcribeAudio(audioBuffer);

        // Opcional: Generar contenido
        let blogContent = null;
        if (rewrite) {
            console.log('Generando contenido con OpenAI...');
            const { content } = await generateAIContent({
                prompt: `Crea un artículo basado en los siguientes subtítulos: ${subtitles}`,
                model: 'gpt-4',
                temperature: 0.7,
                maxTokens: 1000,
                context: { useHTML },
            });
            blogContent = useHTML ? `<article>${content}</article>` : content;
        }

        console.log('Proceso completado exitosamente.');
        return {
            statusCode: 200,
            body: JSON.stringify({
                message: 'Video procesado exitosamente.',
                subtitles,
                blogContent,
            }),
        };
    } catch (error) {
        console.error('Error procesando el video:', error.message);
        return {
            statusCode: 500,
            body: JSON.stringify({
                error: 'Error procesando archivo',
                details: error.message,
            }),
        };
    }
};

module.exports = processVideo;
