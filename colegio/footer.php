<!-- Modal para subir imágenes -->
<div id="uploadImageModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="uploadImageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadImageModalLabel">Subir Imagen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="uploadImageForm" action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="section" id="modalSection" value="">
                    <div class="form-group">
                        <label for="imageFile">Seleccionar imagen</label>
                        <input type="file" class="form-control-file" id="imageFile" name="imageFile" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Subir</button>
                </form>
            </div>
        </div>
    </div>
</div>


<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-xs-12">
                <div class="widget clearfix">
                    <div class="widget-title">
                        <h3>Facebook</h3>
                    </div>
                    <div class="footer-right">
                        <ul class="footer-links-soi">
                            <li><a href="https://www.facebook.com/p/Escuela-de-lenguaje-Ni%C3%B1o-Jesus-100063466527084/?locale=es_LA" target="_blank"><i class="fa fa-facebook"></i></a></li>
                        </ul>
                    </div>                      
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-xs-12">
                <div class="widget clearfix">
                    <div class="widget-title">
                        <h3>Enlaces de Información</h3>
                    </div>
                    <ul class="footer-links">
                        <li><a href="home.php">Inicio</a></li>
                        <li><a href="about.html">Acerca de nosotros</a></li>
                        <li><a href="eventos.php">Eventos</a></li>
                        <li><a href="galeria.php">Galería de Imágenes</a></li>
                        <li><a href="contact.html">Contacto</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>

<a href="#" id="scroll-to-top" class="dmtop global-radius"><i class="fa fa-angle-up"></i></a>

<!-- ALL JS FILES -->
<script src="js/all.js"></script>
<!-- CUSTOM JS FILES -->
<script src="js/custom.js"></script>
<script src="js/timeline.min.js"></script>
<script>
    timeline(document.querySelectorAll('.timeline'), {
        forceVerticalMode: 700,
        mode: 'horizontal',
        verticalStartPosition: 'left',
        visibleItems: 4
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.editable-content').forEach(function (element) {
        element.addEventListener('click', function () {
            var parent = element.closest('.editable-container');
            parent.querySelector('.edit-actions').style.display = 'block';
        });
    });

    document.querySelectorAll('.cancel-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            var parent = button.closest('.editable-container');
            parent.querySelector('.edit-actions').style.display = 'none';
        });
    });

    document.querySelectorAll('.save-btn').forEach(function (button) {
    button.addEventListener('click', function () {
        var parent = button.closest('.editable-container');
        var content = parent.querySelector('.editable-content').textContent;
        var key = parent.querySelector('.editable-content').getAttribute('data-key');

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'uploads/save_content.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                console.log('Respuesta del servidor:', xhr.responseText);
                parent.querySelector('.edit-actions').style.display = 'none';
            }
        };
        console.log('Datos antes de enviar:');
        console.log('key:', key);
        console.log('content:', content);
        xhr.send('seccion=' + encodeURIComponent(key) + '&content=' + encodeURIComponent(content));
    });
});


    document.querySelectorAll('.edit-icon').forEach(function (icon) {
        icon.addEventListener('click', function (e) {
            e.preventDefault();
            window.location.href = icon.getAttribute('href');
        });
    });
});
</script>
</body>
</html>
