<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{asset("assets/$theme/dist/img/AdminLTELogo.png")}}" alt="AdminLTE Logo" class="brand-image elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">ERRADICACIÓN</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar scrollId"  >
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <!--div class="image">
                <img src="{{asset("assets/$theme/dist/img/onu.jpg")}}" class="img-circle elevation-2" alt="User Image">
            </div-->
            <div class="info">
                <a href="#" class="d-block">Hola, {{ session()->get('user_name') ?? 'Invitado'}}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column sidebar-menu" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                <?php
                    $menus = Session::get('menus');
                    if(isset($menus)){
                ?>

                @foreach ($menus as $key => $item)
                    @if ($item["menu_id"] != 0)
                        @break
                    @endif

                    @if ($item["submenu"] != [])
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa fa-fw {{isset($item["icono"]) ? $item["icono"] : ""}}"></i>
                                <p>
                                    {{$item["nombre"]}}
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ">
                                @foreach ($item["submenu"] as $submenu)
                                    @include("admin.menu.menu-item-user",[ "item" => $submenu ])
                                @endforeach
                            </ul>
                        </li>
                    @else
                        <li class="nav-item {{getMenuActivo($item["url"])}}">
                            <a href="{{url($item["url"])}}" class="nav-link {{getMenuActivo($item["url"])}}">
                                <i class="nav-icon fa fa-fw {{isset($item["icono"]) ? $item["icono"] : ""}}"></i>
                                <p>
                                    {{$item["nombre"]}}
                                </p>
                            </a>
                        </li>
                    @endif

                @endforeach
                <?php } ?>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
