const { Client, LocalAuth } = require('whatsapp-web.js');
const qrcode = require('qrcode');
const express = require('express');
const socketIO = require('socket.io');
const http = require('http');
const cors = require('cors');

const app = express();
const server = http.createServer(app);
const io = socketIO(server, {
    cors: {
        origin: 'http://127.0.0.1:8000',
        methods: ['GET', 'POST'],
        allowedHeaders: ['Content-Type'],
        credentials: true
    }
});

// Middleware for parsing JSON requests
app.use(express.json());

const client = new Client({
    authStrategy: new LocalAuth(),
    puppeteer: { headless: true }
});

app.use(cors({
    origin: 'http://127.0.0.1:8000',
    methods: ['GET', 'POST'],
    allowedHeaders: ['Content-Type']
}));

client.on('qr', (qr) => {
    console.log('QR RECEIVED', qr);
    qrcode.toDataURL(qr, (err, url) => {
        io.emit('qr', url);
    });
});

client.on('ready', () => {
    console.log('Client is ready!');
});

// Route for sending a message
app.post('/send-message', (req, res) => {
    const { phone, message } = req.body;

    client.sendMessage(`${phone}@c.us`, message)
        .then(response => {
            res.status(200).json({ status: 'Message sent successfully' });
        })
        .catch(err => {
            res.status(500).json({ status: 'Error', error: err });
        });
});

client.initialize();

// Start the server
server.listen(3000, () => {
    console.log('Server started on http://localhost:3000');
});
