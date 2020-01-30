<div class="form-group row">
    <label for="name" class="col-lg-3 control-label requerido">Nombre del cuartel</label>
    <div class="col-lg-8">
    <input type="text" name="descripcion" id="descripcion" class="form-control" value="{{old('descripcion', $data->descripcion ?? '')}}" required/>
    </div>
</div>
