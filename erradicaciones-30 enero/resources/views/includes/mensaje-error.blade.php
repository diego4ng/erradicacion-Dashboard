@if (session("mensaje-error"))
    <div class="alert alert-danger alert-dismissible" data-auto-dismiss="3000">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> Mensaje Erradicacion MEXW34</h4>
        <ul>
            <li>{{ session("mensaje-error") }}</li>
        </ul>
    </div>
@endif
