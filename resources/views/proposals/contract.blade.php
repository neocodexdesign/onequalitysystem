<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documento</title>
</head>
<body>
    <div id="pdfViewer" style="width: 100%; height: 100vh;"></div>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', (event) => {
            var url = '{{ $url }}'; // Certifique-se de que isto está corretamente substituído pela URL do PDF.
            var win = window.open(url, '_blank');
            if (win) {
                win.focus();
            } else {
                var viewer = document.getElementById('pdfViewer');
                if (viewer) {
                    viewer.innerHTML = '<iframe src="' + url + '" frameborder="0" style="width: 100%; height: 100%;"></iframe>';
                } else {
                    console.error('Elemento pdfViewer não encontrado.');
                }
            }
        });
    </script>
</body>
</html>

