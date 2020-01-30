<div class="form-group row">
    <label for="imei" class="col-lg-3 control-label requerido">IMEI</label>
    <div class="col-lg-5">
        <input type="text" name="imei" id="imei" class="form-control" value="{{old('imei', $data->imei ?? '')}}" required/>
    </div>
</div>
<div class="form-group row">
    <label for="psn" class="col-lg-3 control-label requerido">PSN</label>
    <div class="col-lg-5">
        <input type="text" name="psn" id="psn" class="form-control" value="{{old('psn', $data->psn ?? '')}}" required/>
    </div>
</div>
<div class="form-group row">
    <label for="institucion_id" class="col-lg-3 control-label requerido">Dependencia</label>
    <div class="col-lg-5">
        <select name="institucion_id" id="institucion_id">
            @foreach ($catalogo_dependencia as $key => $value)
                <option value="{{ $key }}"
            @if (isset($data))
                @if($data->institucion_id==$key) selected="selected" @endif
            @endif
            >{{ $value }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group row">
    <label for="asignacion_id" class="col-lg-3 control-label">Cuartel que asigna el dispositivo</label>
    <div class="col-lg-5">
        <select name="asignacion_id" id="asignacion_id" class="form-control">
            <option value="">Selecciona un Cuartel</option>
            @foreach ($catalogo_asignacion as $key => $value)
                <option value="{{ $key }}"
            @if (isset($data))
                @if($data->asignacion_id==$key) selected="selected" @endif
            @endif
            >{{ $value}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group row">
    <label for="entidad_id" class="col-lg-3 control-label">Estado</label>
    <div class="col-lg-5">
        <select name="entidad_id" id="entidad_id" class="form-control selectpicker"  data-live-search="true" title='Selecciona un Estado'  data-selected-text-format="count>3" data-actions-box="true" >
            @foreach ($catalogo_estados as $key => $value)
                <option value="{{ $key }}"
            @if (isset($data))
                @if($data->entidad_id==$key) selected="selected" @endif
            @endif
            >{{ $value}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group row">
    <label for="municipio_id" class="col-lg-3 control-label">Municipio</label>
    <div class="col-lg-5">
        <select name="municipio_id" id="municipio_id" class="form-control selectpicker"  data-live-search="true" title='Selecciona un Municipio' data-selected-text-format="count>3" data-actions-box="true" ></select>
    </div>
</div>
<div class="form-group row">
    <label for="localidad_id" class="col-lg-3 control-label">Localidad</label>
    <div class="col-lg-5">
        <select name="localidad_id" id="localidad_id" class="form-control selectpicker"  data-live-search="true" title='Selecciona una Localidad'  data-selected-text-format="count>3" data-actions-box="true" ></select>
    </div>
</div>
<div class="form-group row">
    <label for="observaciones" class="col-lg-3 control-label">Observaciones</label>
    <div class="col-lg-5">
        <textarea name="observaciones" rows="5" id="observaciones" class="form-control" value="{{old('observaciones', $data['observaciones'] ?? '')}}">{{old('observaciones', $data['observaciones'] ?? '')}}</textarea>
    </div>
</div>

