<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-xs-12">
                <div class="widget clearfix">
                    <div class="widget-title">
                        <h3>Acerca de nosotros</h3>
                    </div>
                    <p>Integer rutrum ligula eu dignissim laoreet. Pellentesque venenatis nibh sed tellus faucibus bibendum. Sed fermentum est vitae rhoncus molestie. Cum sociis natoque penatibus et magnis dis montes.</p>   
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

            <div class="col-lg-4 col-md-4 col-xs-12">
                <div class="widget clearfix">
                    <div class="widget-title">
                        <h3>Contacto</h3>
                    </div>

                    <ul class="footer-links">
                        <li><a href="mailto:#">Correo</a></li>
                        <li><a href="#">Facebook</a></li>
                        <li>Dirección</li>
                        <li>Teléfono</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>

<a href="#" id="scroll-to-top" class="dmtop global-radius"><i class="fa fa-angle-up"></i></a>

<!-- ALL JS FILES -->
<script src="js/all.js"></script>
<!-- ALL PLUGINS -->
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
    // Mostrar botones de edición al hacer clic en el contenido editable
    document.querySelectorAll('.editable-content').forEach(function (element) {
        element.addEventListener('click', function () {
            var parent = element.closest('.editable-container');
            parent.querySelector('.edit-actions').style.display = 'block';
        });
    });

    // Cancelar edición
    document.querySelectorAll('.cancel-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            var parent = button.closest('.editable-container');
            parent.querySelector('.edit-actions').style.display = 'none';
        });
    });

    // Guardar cambios
    document.querySelectorAll('.save-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            var parent = button.closest('.editable-container');
            var content = parent.querySelector('.editable-content').textContent;
            var key = parent.querySelector('.editable-content').getAttribute('data-key');

            // Llamada AJAX para enviar los cambios al servidor
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'uploads/admin_home.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    console.log('Respuesta del servidor:', xhr.responseText);
                    // Ocultar los botones de acción después de guardar
                    parent.querySelector('.edit-actions').style.display = 'none';
                }
            };
            xhr.send('section=' + encodeURIComponent(key) + '&content=' + encodeURIComponent(content));
        });
    });
});
</script>
</body>
</html>
