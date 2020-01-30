$('.menu_rol').on('change', function () {
    var data = {
        menu_id: $(this).data('menuid'),
        rol_id: $(this).val(),
        _token: $('input[name=_token]').val()
    };
    if ($(this).is(':checked')) {
        data.estado = 1
    } else {
        data.estado = 0
    }
    ajaxRequest(window.location.origin+'/erradicaciones/public/admin/menu-role', data); //Dirección ip absoluta para servidores remotos
    //ajaxRequest('/admin/menu-role', data); //Servidor laravel que resuelve rutas
});

function ajaxRequest (url, data) {
    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        success: function (respuesta) {
            Biblioteca.notificaciones(respuesta.respuesta, 'Erradicacion MEXW34', 'success');
        },
        error: function() {
            Biblioteca.notificaciones('Lo sentimos el proceso no pudo ser completado.', 'Erradicacion MEXW34', 'error');
        }
    });
}
