$(document).ready(function () {

    $("#tabla-data").on('submit', '.form-eliminar', function () {
        event.preventDefault();
        const form = $(this);
        swal({
            title: '¿ Está seguro que desea eliminar el registro ?',
            text: "Esta acción no se puede deshacer!",
            icon: 'warning',
            buttons: {
                cancel: "Cancelar",
                confirm: "Aceptar"
            },
        }).then((value) => {
            if (value) {
                ajaxRequest(form);
            }
        });
    });

    function ajaxRequest(form) {
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: function (respuesta) {
                if (respuesta.mensaje == "ok") {
                    form.parents('tr').remove();
                    Biblioteca.notificaciones('El registro fue eliminado correctamente', 'Erradicacion MEXW34', 'success');
                } else {
                    Biblioteca.notificaciones('El registro no pudo ser eliminado, hay recursos usandolo', 'Erradicacion MEXW34', 'error');
                }
            },
            error: function () {
                Biblioteca.notificaciones('Error en conexión, verifique que la url proporcionada sea correcta y el método de envío', 'Erradicacion MEXW34', 'error');
            }
        });
    }

    $('select').selectpicker();
});

//PETICIONES AJAX DE MUNICIPIOS PARA PODER SER VÁLIDA LA CONSULTA SE AGREGA EL TOKEN A CADA CONSULTA QUE SE REALICE
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


$('.id_evento').click(function(e){
    //we will send data and recive data fom our AjaxController
    var id_evento = $(this).data('idevento');
    console.log(id_evento);

    var url_municipio = window.location.origin+'/erradicaciones/public/admin/municipiosajax/'+id_estado; //Dirección ip absoluta para servidores remotos
    console.log('url_municipio: '+url_municipio);

    $.ajax({
        //url:'/admin/municipiosajax/'+id_estado, //Servidor local laravel
        url: url_municipio,
        //data:{'id_estado':id_estado},
        type:'POST',
        success: function (respuesta) {
            var municipios_select = $('#municipio_id');
            municipios_select.empty();
            municipios_select.append('<option value="">Selecciona un Municipio</option>');
            municipios_select.selectpicker('refresh');
            console.log(respuesta);
            var waitCount = 0;
            $.each(respuesta, function(key, val){
                waitCount++;
            });

            $.each(respuesta, function(key, val){

                municipios_select.append('<option value="' + key + '">' + val+ '</option>');

                if (--waitCount == 0) {
                    $('.selectpicker').selectpicker('refresh');
                    var options = $('#municipio_id option');
                    var arr = options.map(function(_, o) {
                        return {
                            t: $(o).text(),
                            v: o.value
                        };
                    }).get();
                    arr.sort(function(o1, o2) {
                        return o1.t > o2.t ? 1 : o1.t < o2.t ? -1 : 0;
                    });
                    options.each(function(i, o) {
                        o.value = arr[i].v;
                        $(o).text(arr[i].t);
                    });
                    $('.selectpicker').selectpicker('refresh');
                }
            });

            Biblioteca.notificaciones('Municipios cargados', 'Erradicacion MEXW34', 'success');
        },
        error: function() {
            Biblioteca.notificaciones('Lo sentimos los municipios no fueron cargados.', 'Erradicacion MEXW34', 'error');
        }
    });


    $('#municipio_id').change(function(e){

        //we will send data and recive data fom our AjaxController
        var id_municipio = e.target.value;
        var url_localidad = window.location.origin+'/erradicaciones/public/admin/localidadesajax/'+ id_municipio; //Dirección ip absoluta para servidores remotos
        console.log('url_localidad: '+url_localidad);

        $.ajax({
            //url:'/admin/localidadesajax/'+id_municipio,
            url: url_localidad,
            //data:{'id_estado':id_estado},
            type:'post',
            success: function (respuesta) {
                var localidades_select = $('#localidad_id');
                localidades_select.empty();
                localidades_select.append('<option value="">Selecciona una Localidad</option>');
                localidades_select.selectpicker('refresh');
                console.log(respuesta);
                var waitCount = 0;
                $.each(respuesta, function(key, val){
                    waitCount++;
                });

                $.each(respuesta, function(key, val){

                    localidades_select.append('<option value="' + key + '">' + val+ '</option>');

                    if (--waitCount == 0) {
                        $('.selectpicker').selectpicker('refresh');
                        var options = $('#localidad_id option');
                        var arr = options.map(function(_, o) {
                            return {
                                t: $(o).text(),
                                v: o.value
                            };
                        }).get();
                        arr.sort(function(o1, o2) {
                            return o1.t > o2.t ? 1 : o1.t < o2.t ? -1 : 0;
                        });
                        options.each(function(i, o) {
                            o.value = arr[i].v;
                            $(o).text(arr[i].t);
                        });
                        $('.selectpicker').selectpicker('refresh');
                    }
                });

                Biblioteca.notificaciones('Localidades cargadas', 'Erradicacion MEXW34', 'success');
            },
            error: function() {
                Biblioteca.notificaciones('Lo sentimos no se cargaron las localidades.', 'Erradicacion MEXW34', 'error');
            }
        });

    });

});
