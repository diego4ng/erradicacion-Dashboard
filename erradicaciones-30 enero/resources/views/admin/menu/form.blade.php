<div class="form-group row">
    <label for="nombre" class="col-lg-3 control-label requerido">Nombre</label>
    <div class="col-lg-5">
        <input type="text" name="nombre" id="nombre" class="form-control" value="{{old('nombre', $data->nombre ?? '')}}" required/>
    </div>
</div>
<div class="form-group row">
    <label for="url" class="col-lg-3 control-label requerido">Url</label>
    <div class="col-lg-5">
        <input type="text" name="url" id="url" class="form-control" value="{{old('url', $data->url ?? '')}}" required/>
    </div>
</div>
<div class="form-group row">
    <label for="icono" class="col-lg-3 control-label">Icono</label>
    <div class="col-lg-5">
        <input type="text" name="icono" id="icono" class="form-control" value="{{old('icono', $data->icono ?? '')}}" placeholder="Ejemplo: fa-user" />
    </div>
    <div class="col-lg-2">
            <a class="btn btn-primary" href="https://fontawesome.com/v4.7.0/icons/" target="_blank" ><i class="fa fa-list" aria-hidden="true"></i> Ver iconos</a>
        </div>
    <div class="col-lg-1">
        <span id="mostrar-icono" class="fa fa-fw {{old("icono", $data->icono ?? '')}} fa-3x"></span>
    </div>

</div>
