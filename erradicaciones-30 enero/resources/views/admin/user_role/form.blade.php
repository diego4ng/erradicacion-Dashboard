<div class="form-group row">
    <label for="name" class="col-lg-3 control-label requerido">Usuario</label>
    <div class="col-lg-8">
        <select name="user_id" id="user_id" class="form-control" @if (isset($data)) disabled="true" @endif required>
            @foreach ($usuarios as $key => $value)
                <option value="{{ $key }}"
                @if (isset($data))
                    @if($data->user_id==$key) selected="selected" @endif
                @endif
                >{{ $value}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group row">
    <label for="name" class="col-lg-3 control-label requerido">Roles</label>
    <div class="col-lg-8">
        <select name="role_id" id="role_id" class="form-control" required>
            @foreach ($roles as $key => $value)
                <option value="{{ $key }}"
            @if (isset($data))
                @if($data->role_id==$key) selected="selected" @endif
            @endif
            >{{ $value}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group row">
    <label for="name" class="col-lg-3 control-label requerido">Estatus de acceso</label>
    <div class="col-lg-8">
        <select class="form-control" id="status" name="status">
            <option value=1>Activo</option>
            <option value=0>Inactivo</option>
        </select>
    </div>
</div>
