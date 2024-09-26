<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code</title>
</head>

<body>
    <h1>WhatsApp QR Code</h1>
    <img id="qrcode" src="" alt="QR Code will appear here">

    <script src="https://cdn.socket.io/4.0.0/socket.io.min.js"></script>
    <script>
        var socket = io('http://localhost:3000');

        socket.on('qr', function(qrCodeUrl) {
            document.getElementById('qrcode').src = qrCodeUrl;
        });
    </script>
</body>

</html>
