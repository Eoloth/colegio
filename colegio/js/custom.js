/******************************************
    Version: 1.0
/****************************************** */

(function($) {
    "use strict";

    /* ==============================================
    Fixed menu
    =============================================== */
    $(window).on('scroll', function () {
        if ($(window).scrollTop() > 50) {
            //$('.top-navbar').addClass('fixed-menu');
        } else {
            //$('.top-navbar').removeClass('fixed-menu');
        }
    });

    /* ==============================================
    Back top
    =============================================== */
    jQuery(window).scroll(function() {
        if (jQuery(this).scrollTop() > 1) {
            jQuery('.dmtop').css({
                bottom: "10px"
            });
        } else {
            jQuery('.dmtop').css({
                bottom: "-100px"
            });
        }
    });

    /* ==============================================
    Loader -->
    =============================================== */
    $(window).on('load', function() {
        $("#preloader").fadeOut(500);
        $(".preloader").fadeOut("slow", 600);
        $('.loader-container').addClass('done');
        $('.progress-br').addClass('done');	 
    });
    
    /* ==============================================
        Scroll to top  
    =============================================== */
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
            $('html,body').animate({
                scrollTop: 0
            }, 700);
        });
    }

    /* ==============================================
     Fun Facts -->
     =============================================== */
    function count($this) {
        var current = parseInt($this.html(), 10);
        current = current + 50; /* Where 50 is increment */
        $this.html(++current);
        if (current > $this.data('count')) {
            $this.html($this.data('count'));
        } else {
            setTimeout(function() {
                count($this)
            }, 30);
        }
    }
    $(".stat_count, .stat_count_download").each(function() {
        $(this).data('count', parseInt($(this).html(), 10));
        $(this).html('0');
        count($(this));
    });

    /* ==============================================
     Bootstrap Touch Slider -->
     =============================================== */
    if (typeof $.fn.bsTouchSlider === 'function') {
        $('#carouselExampleControls').bsTouchSlider();
    }

    /* ==============================================
     Tooltip -->
     =============================================== */
    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover();

    /* ==============================================
     Contact -->
     =============================================== */
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
                            $(this).remove()
                        });
                        $('#submit').removeAttr('disabled');
                        if (data.match('success') != null) $('#contactform').slideUp('slow');
                    }
                );
            });
            return false;
        });
    });

    /* ==============================================
     Editable Content Management
     =============================================== */
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
                        console.log('Contenido guardado correctamente.');
                        parent.querySelector('.edit-actions').style.display = 'none';
                    }
                };
                console.log('Datos antes de enviar:');
                console.log('key:', key);
                console.log('content:', content);
                console.log('Iniciando conexión a la base de datos...');
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

})(jQuery);
