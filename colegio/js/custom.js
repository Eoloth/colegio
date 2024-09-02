(function($) {
    "use strict";

    // Scroll y Preloader
    $(window).on('scroll', function () {
        if ($(window).scrollTop() > 50) {
            // Código para manejar el menú fijo (comentado)
        } else {
            // Código para manejar el menú fijo (comentado)
        }
    });

    $(window).scroll(function() {
        if ($(this).scrollTop() > 1) {
            $('.dmtop').css({ bottom: "10px" });
        } else {
            $('.dmtop').css({ bottom: "-100px" });
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

    // Conteo de estadísticas
    function count($this) {
        var current = parseInt($this.html(), 10);
        current = current + 50; /* Incremento */
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

    // Manejo de formularios
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

    // Función para manejar la edición de contenido general (home.php y about.php)
    function handleContentEditing(selector, saveFunction) {
        document.querySelectorAll(selector).forEach(function(element) {
            element.addEventListener('focus', function() {
                element.classList.add('editing');
                const editActions = element.closest('.editable-container').querySelector('.edit-actions');
                if (editActions) {
                    editActions.style.display = 'flex';
                }
            });

            element.addEventListener('blur', function() {
                element.classList.remove('editing');
                const editActions = element.closest('.editable-container').querySelector('.edit-actions');
                if (editActions) {
                    setTimeout(function() {
                        editActions.style.display = 'none';
                    }, 200);
                }
                saveFunction(element);
            });
        });
    }

    // Función para manejar la edición de contenido en la línea de tiempo
    function handleTimelineEditing() {
        document.querySelectorAll('.timeline .editable-content').forEach(function(element) {
            element.addEventListener('focus', function() {
                element.classList.add('editing');
                const editActions = element.closest('.editable-container').querySelector('.timeline-edit-actions');
                if (editActions) {
                    editActions.style.display = 'flex';
                }
            });

            element.addEventListener('blur', function() {
                element.classList.remove('editing');
                const editActions = element.closest('.editable-container').querySelector('.timeline-edit-actions');
                if (editActions) {
                    setTimeout(function() {
                        editActions.style.display = 'none';
                    }, 200);
                }
                saveTimelineContent(element);
            });
        });
    }

    // Función para guardar el contenido de home.php o about.php
    function saveContent(element) {
        var key = element.getAttribute('data-key');
        var content = element.innerText.trim();
        if (!key || !content) {
            console.error("Datos incompletos: Key o Content están vacíos.");
            return;
        }
        var url = window.location.pathname.includes('home.php') ? 'uploads/update_content.php' : 'uploads/update_content_about.php';

        console.log("Datos antes de enviar:");
        console.log("key:", key);
        console.log("content:", content);

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
            },
            body: new URLSearchParams({
                key: key,
                content: content
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log("Guardado exitosamente");
            } else {
                console.error("Error al guardar:", data.message);
                alert("Error al guardar: " + data.message);
            }
        })
        .catch(error => {
            console.error("Error al realizar la solicitud:", error);
            alert("Error al realizar la solicitud: " + error.message);
        });
    }

    // Función para guardar el contenido de la línea de tiempo
    function saveTimelineContent(element) {
        var key = element.getAttribute('data-key');
        var content = element.innerText.trim();
        if (!key || !content) {
            console.error("Datos incompletos: Key o Content están vacíos.");
            return;
        }
        var url = 'uploads/update_timeline_content.php'; // Asumiendo que tienes un archivo separado para la línea de tiempo

        console.log("Datos antes de enviar:");
        console.log("key:", key);
        console.log("content:", content);

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
            },
            body: new URLSearchParams({
                key: key,
                content: content
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log("Guardado exitosamente");
            } else {
                console.error("Error al guardar:", data.message);
                alert("Error al guardar: " + data.message);
            }
        })
        .catch(error => {
            console.error("Error al realizar la solicitud:", error);
            alert("Error al realizar la solicitud: " + error.message);
        });
    }

    // Inicializar manejo de edición según la página
    document.addEventListener("DOMContentLoaded", function() {
        if (window.location.pathname.includes('home.php') || window.location.pathname.includes('about.php')) {
            handleContentEditing('.editable-content', saveContent);
        } else if (window.location.pathname.includes('timeline.php')) {
            handleTimelineEditing();
        }
    });

})(jQuery);
