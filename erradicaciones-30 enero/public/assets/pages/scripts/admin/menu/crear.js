$(document).ready(function () {
    Biblioteca.validacionGeneral('form-general');
    $('#icono').on('blur', function () {
        $('#mostrar-icono').removeClass().addClass('fa fa-fw ' + $(this).val() + ' fa-fx3');
    });

    $( "#icono" ).keyup(function() {
        $('#mostrar-icono').removeClass().addClass('fa fa-fw ' + $(this).val() + ' fa-fx3');
    });
});
