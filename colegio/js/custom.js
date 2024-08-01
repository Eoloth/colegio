(function($) {
    "use strict";

    $(window).on('scroll', function () {
        if ($(window).scrollTop() > 50) {
            // $('.top-navbar').addClass('fixed-menu');
        } else {
            // $('.top-navbar').removeClass('fixed-menu');
        }
    });

    jQuery(window).scroll(function() {
        if (jQuery(this).scrollTop() > 1) {
            jQuery('.dmtop').css({ bottom: "10px" });
        } else {
            jQuery('.dmtop').css({ bottom: "-100px" });
        }
    });

    $(window).on('load', function() {
        $("#preloader").fadeOut(500);
        $(".preloader").fadeOut("slow", 600);
        $('.loader-container').addClass('done');
        $('.progress-br').addClass('done');     
    });
    
    if ($('#scroll-to-top').length) {
        var scrollTrigger = 100, // px
            backToTop = function () {
                var scrollTop = $(window).scrollTop();
                if (scrollTop > scrollTrigger) {
                    $('#scroll-to-top').addClass('show');
                } else {
                    $('#scroll-to-top').removeClass('show');
                }
            };
        backToTop();
        $(window).on('scroll', function () {
            backToTop();
        });
        $('#scroll-to-top').on('click', function (e) {
            e.preventDefault();
            $('html,body').animate({ scrollTop: 0 }, 700);
        });
    }

    function count($this) {
        var current = parseInt($this.html(), 10);
        current = current + 50; /* Where 50 is increment */
        $this.html(++current);
        if (current > $this.data('count')) {
            $this.html($this.data('count'));
        } else {
            setTimeout(function() { count($this) }, 30);
        }
    }

    $(".stat_count, .stat_count_download").each(function() {
        $(this).data('count', parseInt($(this).html(), 10));
        $(this).html('0');
        count($(this));
    });

    if (typeof $.fn.bsTouchSlider === 'function') {
        $('#carouselExampleControls').bsTouchSlider();
    }

    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover();

    jQuery(document).ready(function() {
        $('#contactform').submit(function() {
            var action = $(this).attr('action');
            $("#message").slideUp(750, function() {
                $('#message').hide();
                $('#submit')
                    .after('<img src="images/ajax-loader.gif" class="loader" />')
                    .attr('disabled', 'disabled');
                $.post(action, {
                    first_name: $('#first_name').val(),
                    last_name: $('#last_name').val(),
                    email: $('#email').val(),
                    phone: $('#phone').val(),
                    select_service: $('#select_service').val(),
                    select_price: $('#select_price').val(),
                    comments: $('#comments').val(),
                    verify: $('#verify').val()
                },
                function(data) {
                    document.getElementById('message').innerHTML = data;
                    $('#message').slideDown('slow');
                    $('#contactform img.loader').fadeOut('slow', function() {
                        $(this).remove();
                    });
                    $('#submit').removeAttr('disabled');
                    if (data.match('success') != null) $('#contactform').slideUp('slow');
                });
            });
            return false;
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        // Manejo de edición de contenido
        document.querySelectorAll('.editable-content').forEach(function(element) {
            element.addEventListener('focus', function() {
                element.classList.add('editing');
            });
    
            element.addEventListener('blur', function() {
                element.classList.remove('editing');
                saveContent(element);
            });
        });
    
        // Manejo de clic en botón de editar imagen
        document.querySelectorAll('.edit-image-icon').forEach(function(element) {
            element.addEventListener('click', function() {
                var section = element.getAttribute('data-section');
                var modal = document.getElementById('uploadImageModal');
                var modalSectionInput = modal.querySelector('#modalSection');
                modalSectionInput.value = section;
                $(modal).modal('show');
            });
        });
    });
    
    // Guardar contenido editado
    function saveContent(element) {
        var key = element.getAttribute('data-key');
        var content = element.innerText.trim();
    
        console.log("Datos antes de enviar:");
        console.log("key:", key);
        console.log("content:", content);
    
        fetch('uploads/save_text_about.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                key: key,
                content: content
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                console.log("Guardado exitosamente");
            } else {
                console.error("Error al guardar:", data.message);
                alert("Error al guardar: " + data.message);
            }
        })
        .catch(error => {
            console.error("Error al realizar la solicitud:", error);
        });
    }
    
    // Función para manejar la carga de imágenes
    function handleImageUpload() {
        var form = document.getElementById('uploadImageForm');
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            var formData = new FormData(form);
            var section = document.getElementById('modalSection').value;
    
            fetch('uploads/upload_image_about.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    console.log("Imagen cargada exitosamente");
                    // Actualizar la imagen en la página
                    var imgElement = document.querySelector(`img[data-section='${section}']`);
                    if (imgElement) {
                        imgElement.src = `uploads/${data.fileName}`;
                    }
                    $('#uploadImageModal').modal('hide');
                } else {
                    console.error("Error al cargar la imagen:", data.message);
                    alert("Error al cargar la imagen: " + data.message);
                }
            })
            .catch(error => {
                console.error("Error al realizar la solicitud:", error);
            });
        });
    }
    
    // Inicializar funciones
    handleImageUpload();
    
})(jQuery);
