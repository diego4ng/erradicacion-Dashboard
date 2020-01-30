@if (isset($catalogo_estados))

    <!-- The Modal -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog ">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <p class="modal-title">Filtrar información</p>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                @if ((Route::current()->getName()=='registros') || (Route::current()->getName()=='register_filter'))
                    <form action="{{route('register_filter')}}" id="form-general" class="form-horizontal row container" method="POST" autocomplete="off">
                @else
                    @if ((Route::current()->getName()=='total') || (Route::current()->getName()=='filter_total'))
                        <form action="{{route('filter_total')}}" id="form-general" class="form-horizontal row container" method="POST" autocomplete="off">
                    @else
                        @if ((Route::current()->getName()=='graficas') || (Route::current()->getName()=='graph_filter'))
                            <form action="{{route('graph_filter')}}" id="form-general" class="form-horizontal row container" method="POST" autocomplete="off">
                        @else
                            @if ((Route::current()->getName()=='registers_map') || (Route::current()->getName()=='registers_map_filter'))
                                <form action="{{route('registers_map_filter')}}" id="form-general" class="form-horizontal row container" method="POST" autocomplete="off">
                            @else
                                @if ((Route::current()->getName()=='images') || (Route::current()->getName()=='images_filter'))
                                    <form action="{{route('images_filter')}}" id="form-general" class="form-horizontal row container" method="POST" autocomplete="off">
                                @else
                                    @if ((Route::current()->getName()=='validation') || (Route::current()->getName()=='validation_filter'))
                                        <form action="{{route('validation_filter')}}" id="form-general" class="form-horizontal row container" method="POST" autocomplete="off">
                                    @endif
                                @endif
                            @endif
                        @endif
                    @endif
                @endif

                @csrf

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group row">

                        <div class="col-md-6">
                            <label for="startDate" class="control-label">Fecha inicial de registro:</label>
                            <input type="text" name="startDate" id="startDate" class="form-control"  required/>
                        </div>
                        <div class="col-md-6">
                            <label for="endDate" class="control-label">Fecha final de registro:</label>
                            <input type="text" name="endDate" id="endDate" class="form-control"  required/>
                        </div>
                        <div class="col-md-12" style="margin-top: 15px;">
                            <label for="endDate" class="control-label">Estado(s) de registro:</label>
                            <select name="estado_ids[]" id="estado_id" class="form-control selectpicker" multiple data-live-search="true" title='Selecciona estados a filtrar...' data-size="5" data-selected-text-format="count>3" data-actions-box="true">
                                @foreach ($catalogo_estados as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <?php $validaciones = [1=>'Pendiente',2=>'Validado',3=>'Rechazado'] ?>
                        <div class="col-md-12" style="margin-top: 15px;">
                            <label for="endDate" class="control-label">Validación:</label>
                            <select name="validacion" id="validacion" class="form-control selectpicker" data-live-search="true" title='Selecciona tipo de validación a filtrar...' >
                                @foreach ($validaciones as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer col-md-12 ">
                    <div class="col-md-12 text-center">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Filtrar <i class="fa fa-filter"></i></button>
                    </div>
                </div>

                </form>
            </div>
        </div>
    </div>

    <script>
        //var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());

        var today = new Date();
        var dd = today.getDate();

        var mm = today.getMonth()+1;
        var yyyy = today.getFullYear();
        if(dd<10)
        {
            dd='0'+dd;
        }

        if(mm<10)
        {
            mm='0'+mm;
        }

        today = yyyy+'-'+mm+'-'+dd;

        $('#startDate').datepicker({
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',
            locale: 'es-es',
            //modal: true,
            header: true,
            //footer: true,
            format: 'yyyy-mm-dd',
            value: today,
            maxDate: today,
        });
        $('#endDate').datepicker({
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',
            locale: 'es-es',
            //modal: true,
            header: true,
            //footer: true,
            format: 'yyyy-mm-dd',
            value: today,
            maxDate: today,
            minDate: function () {
                return $('#startDate').val();
            }
        });

    </script>
@endif
