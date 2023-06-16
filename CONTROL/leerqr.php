<!DOCTYPE html>
<html>
<head>
    <title>Escaneo de QR</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
</head>
<body>
    <h1>Escaneo de QR</h1>
    <video id="video" width="320" height="240" autoplay></video>
    <button id="btn-escanear">Escanear QR</button>

    <script>
        // Obtener acceso a la cámara y escanear el código QR
        function escanearQR() {
            const video = document.getElementById('video');
            const btnEscanear = document.getElementById('btn-escanear');

            // Verificar el soporte de la API de MediaDevices
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                navigator.mediaDevices.getUserMedia({ video: true })
                    .then(function(stream) {
                        video.srcObject = stream;
                        video.play();
                    })
                    .catch(function(error) {
                        console.error('Error al acceder a la cámara: ', error);
                    });
            }

            // Inicializar el escáner Instascan
            const scanner = new Instascan.Scanner({ video: video });
            scanner.addListener('scan', function(content) {
                // Enviar el código QR al servidor para guardar los datos
                $.ajax({
                    url: 'guardar_qr.php',
                    type: 'POST',
                    data: { qr_code: content },
                    success: function(response) {
                        console.log('Datos guardados en MySQL:', response);
                        // Mostrar los datos en el cliente si es necesario
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al guardar los datos:', error);
                    }
                });
            });

            // Escanear el código QR cuando se hace clic en el botón
            btnEscanear.addEventListener('click', function() {
                Instascan.Camera.getCameras()
                    .then(function(cameras) {
                        if (cameras.length > 0) {
                            scanner.start(cameras[0]);
                        } else {
                            console.error('No se encontró ninguna cámara en el dispositivo.');
                        }
                    })
                    .catch(function(error) {
                        console.error('Error al obtener las cámaras: ', error);
                    });
            });
        }

        // Llamar a la función para escanear el QR
        escanearQR();
    </script>
</body>
</html>
