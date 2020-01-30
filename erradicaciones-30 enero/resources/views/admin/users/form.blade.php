<div class="form-group row">
    <label for="name" class="col-lg-3 control-label requerido">Nombre de usuario</label>
    <div class="col-lg-8">
        <input type="text" name="name" id="name" class="form-control" value="{{old('name', $data->name ?? '')}}" required/>
    </div>
</div>
<div class="form-group row">
    <label for="name" class="col-lg-3 control-label requerido">Correo electrónico</label>
    <div class="col-lg-8">
        <input type="email" name="email" id="email" class="form-control" value="{{old('email', $data->email ?? '')}}" required/>
    </div>
</div>
<div class="form-group row">
    <label for="name" class="col-lg-3 control-label requerido">Contraseña</label>
    <div class="col-lg-8">
        <input type="password" name="password" id="password" class="form-control"  required/>
    </div>
</div>
<div class="form-group row">
    <label for="name" class="col-lg-3 control-label requerido">Confirmar Contraseña</label>
    <div class="col-lg-8">
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required/>
    </div>
</div>
