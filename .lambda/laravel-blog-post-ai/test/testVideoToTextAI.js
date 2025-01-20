/**
 * JSON
 */
/*
    {
        "type": "videoToTextAI",
        "data": {
            "s3Url": "https://seguros-crm.s3.us-east-1.amazonaws.com/temp/lambda/laravel-blog-post-ai/il5oazbbwyi/videos/example-video.mp4",
            "rewrite": true,
            "useHTML": true
        }
    }
*/
const { handler } = require('../index');
const { generateToken } = require('../src/utils/auth');

// Usuario y token de prueba
const user = { id: 1, role: 'admin' };
const token = generateToken(user);

// URL del archivo S3
const s3Url = 'https://seguros-crm.s3.us-east-1.amazonaws.com/temp/lambda/laravel-blog-post-ai/il5oazbbwyi/videos/example-video.mp4';

// Evento simulado
const event = {
    headers: {
        Authorization: token,
    },
    body: JSON.stringify({
        type: 'videoToTextAI',
        data: {
            s3Url, // URL del archivo en S3
            rewrite: true,
            useHTML: true,
        },
    }),
};

// Invocar la función Lambda
handler(event)
    .then((response) => {
        console.log('Response:', JSON.parse(response.body));
    })
    .catch((error) => {
        console.error('Error:', error);
    });
