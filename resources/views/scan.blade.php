<!DOCTYPE html>
<html>
<head>
    <title>Escanear Código</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- <script src="{{ asset('js/quagga.min.js') }}"></script> --}}
    <script src="https://cdn.rawgit.com/serratus/quaggaJS/0420d5e0/dist/quagga.min.js"></script>
</head>
<body>
    <h1>Escanear Código de Barras</h1>
    <div id="scanner-container">
        <video id="scanner" autoplay></video>
    </div>
    <p>Código detectado: <span id="resultado"></span></p>

    <script type="module">
        Quagga.init({
            inputStream: {
                name: "Live",
                type: "LiveStream",
                target: document.querySelector('#scanner-container')
            },
            decoder: {
                readers: ["ean_reader", "code_128_reader"] // Tipos de códigos a detectar
            }
        }, function(err) {
            if (err) { console.log(err); return; }
            Quagga.start();
        });

        Quagga.onDetected(function(data) {
            var codigo = data.codeResult.code;
            document.getElementById('resultado').innerText = codigo;
            // Enviar el código a Laravel vía AJAX
            fetch('/save-code/', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ codigo: codigo })
            }).then(response => response.json())
              .then(data => console.log(data));
        });
    </script>
</body>
</html>