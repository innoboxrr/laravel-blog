if (process.env.NODE_ENV !== 'production') {
    require('dotenv').config();
}

const AWS = require('aws-sdk');

AWS.config.update({
    accessKeyId: process.env.EAWS_ACCESS_KEY_ID,
    secretAccessKey: process.env.EAWS_SECRET_ACCESS_KEY,
    region: process.env.EAWS_REGION,
});

const s3 = new AWS.S3();

/**
 * Generar URLs prefirmadas para subida resumible de videos
 * @param {Object} data - Información para generar las URLs
 * @param {string} data.uniqueId - Identificador único para la operación
 * @param {string} data.filename - Nombre del archivo
 * @param {number} data.totalParts - Número total de partes del archivo
 */
const generateUploadLinks = async (uniqueId, filename, totalParts) => {
    const Bucket = process.env.S3_BUCKET_NAME;
    const Key = `${process.env.S3_UPLOADS_PATH}/${uniqueId}/${filename}`;

    // Crear un multipart upload
    const createMultipartUpload = await s3
        .createMultipartUpload({ Bucket, Key })
        .promise();

    const uploadId = createMultipartUpload.UploadId;

    // Generar URLs prefirmadas para cada parte
    const presignedUrls = await Promise.all(
        Array.from({ length: totalParts }, (_, i) =>
            s3.getSignedUrlPromise('uploadPart', {
                Bucket,
                Key,
                PartNumber: i + 1,
                UploadId: uploadId,
                Expires: 3600, // Expiración de cada URL (1 hora)
            })
        )
    );

    return { uploadId, presignedUrls };
};

/**
 * Completar una subida resumible de videos
 * @param {Object} data - Información para completar la subida
 * @param {string} data.uniqueId - Identificador único para la operación
 * @param {string} data.filename - Nombre del archivo
 * @param {string} data.uploadId - ID del multipart upload en S3
 */
const completeUpload = async (uniqueId, filename, uploadId) => {
    const Bucket = process.env.S3_BUCKET_NAME;
    const Key = `${process.env.S3_UPLOADS_PATH}/${uniqueId}/${filename}`;

    // Listar las partes subidas
    const listParts = await s3
        .listParts({ Bucket, Key, UploadId: uploadId })
        .promise();

    const parts = listParts.Parts.map((part) => ({
        PartNumber: part.PartNumber,
        ETag: part.ETag,
    }));

    // Completar la subida
    await s3
        .completeMultipartUpload({
            Bucket,
            Key,
            UploadId: uploadId,
            MultipartUpload: { Parts: parts },
        })
        .promise();

    return { message: 'Upload completed successfully', filename };
};

module.exports = async (data) => {
    const { action, uniqueId, filename, totalParts, uploadId } = data;

    if (!uniqueId) {
        return {
            statusCode: 400,
            body: JSON.stringify({ error: 'Unique ID is required' }),
        };
    }

    if (action === 'init') {
        return {
            statusCode: 200,
            body: JSON.stringify(await generateUploadLinks(uniqueId, filename, totalParts)),
        };
    }

    if (action === 'complete') {
        return {
            statusCode: 200,
            body: JSON.stringify(await completeUpload(uniqueId, filename, uploadId)),
        };
    }

    return {
        statusCode: 400,
        body: JSON.stringify({ error: 'Invalid action for videoUpload' }),
    };
};
