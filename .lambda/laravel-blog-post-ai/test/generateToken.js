const { generateToken, validateToken } = require('../src/utils/auth');

const user = { id: 1, role: 'admin' };

const token = generateToken(user);
console.log('Generated Token:', token);

try {
    const decoded = validateToken(token);
    console.log('Decoded Token:', decoded);
} catch (err) {
    console.error('Error:', err.message);
}