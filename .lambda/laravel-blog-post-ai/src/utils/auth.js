const jwt = require('jsonwebtoken');

// Cargar dotenv solo en entornos locales
if (process.env.NODE_ENV !== 'production') {
    require('dotenv').config();
}

const generateToken = (user) => {
    if (!process.env.JWT_SECRET) {
        throw new Error('JWT_SECRET is not defined');
    }

    const payload = {
        userId: user.id,
        role: user.role,
    };

    const token = jwt.sign(payload, process.env.JWT_SECRET, {
        // Puedes habilitar esto si necesitas expiración
        // expiresIn: process.env.JWT_EXPIRATION || '1h',
    });

    return token;
};

const validateToken = (authorizationHeader) => {
    if (!process.env.JWT_SECRET) {
        throw new Error('JWT_SECRET is not defined');
    }

    if (!authorizationHeader) {
        throw new Error('Authorization header is missing');
    }

    try {
        const decoded = jwt.verify(authorizationHeader, process.env.JWT_SECRET);
        return decoded;
    } catch (err) {
        throw new Error('Invalid or expired token');
    }
};

module.exports = {
    generateToken,
    validateToken,
};
