/* Boton Borrar Campos De Formulario*/
$(document).ready(function () {
    //Cerrar Las Alertas Automaticamente
    $('.alert[data-auto-dismiss]').each(function (index, element) {
        const $element = $(element),
            timeout = $element.data('auto-dismiss') || 5000;
        setTimeout(function () {
            //$element.alert('close');
            $element.animate({opacity: 1.0}, 1000).fadeOut("slow","swing");
        }, timeout);
    });

    $('ul.sidebar-menu').find('li.active').parents('li').addClass('nav-item has-treeview menu-open').children('a').addClass('active open-menu');

    //TOOLTIPS
    $('body').tooltip({
        trigger: 'hover',
        selector: '.tooltipsC',
        placement: 'top',
        html: true,
        container: 'body'
    });

    //DATATABLES INITIALIZE
    if($(".example").length){
        $('.example').DataTable({
            "order": [[ 0, "desc" ]],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            //"processing": true,
            //"deferLoading": 50,
            //deferRender: true
        });
    }

    //DATA TABLES EXPORT
    if(($(".table").length) && ($(".table-nondownload").length == 0)){
        $(".align-middle").each(function(){
            $(this).text($.trim($(this).text()));
        });

        $("table").tableExport({
            formats: ["xlsx","txt", "csv"], //Tipo de archivos a exportar ("xlsx","txt", "csv", "xls")
            position: 'bottom',  // Posicion que se muestran los botones puedes ser: (top, bottom)
            bootstrap: true,//Usar lo estilos de css de bootstrap para los botones (true, false)
            fileName: "Erradicacion MEXW34",    //Nombre del archivo
        });
    }

    //SCROLLBARS
    $('.scrollId').overlayScrollbars({
       //Parameters
    });

    $('body').overlayScrollbars({
        //Parameters
     });

     //GO BACK ON BUTTON
     $('button#cancel').on('click', function(e){
        e.preventDefault();
        window.history.back();
    });
});
