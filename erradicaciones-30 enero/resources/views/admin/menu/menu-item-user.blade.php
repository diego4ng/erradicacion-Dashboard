<li class="nav-item {{getMenuActivo($item["url"])}}">
    <a href="{{url($item["url"])}}" class="nav-link {{getMenuActivo($item["url"])}}">
        <i class="nav-icon fa fa-fw {{isset($item["icono"]) ? $item["icono"] : ""}}"></i>
        <p>
            {{$item["nombre"]}}
        </p>
    </a>
</li>
