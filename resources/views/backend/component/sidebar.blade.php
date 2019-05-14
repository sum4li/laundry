<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-left justify-content-left" href="#">
        <div class="sidebar-brand-text">{{App\Setting::where('slug','title')->get()->first()->description}}</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Menu Utama
    </div>
    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{request()->route()->getName() == 'dashboard' ? 'active':''}}">
        <a class="nav-link" href="{{route('dashboard')}}">
            <i class="fas fa-fw fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="nav-item {{request()->route()->getName() == 'menuType.index' ? 'active':''}}">
        <a class="nav-link" href="{{route('menuType.index')}}">
            <i class="fas fa-fw fa-bars"></i>
            <span>Tipe Menu</span>
        </a>
    </li>
    <li class="nav-item {{request()->route()->getName() == 'menu.index' ? 'active':''}}">
        <a class="nav-link" href="{{route('menu.index')}}">
            <i class="fas fa-fw fa-bars"></i>
            <span>Menu</span>
        </a>
    </li>

    @foreach (App\Menu::orderBy('order','asc')->get() as $row)

    <li class="nav-item {{request()->route()->getName() == $row->menu_type->route && request()->route('menu_id')==$row->id ? 'active':''}}">
        <a class="nav-link" href="{{route($row->menu_type->route,$row->id)}}">
            <i class="fas fa-fw fa-bullet"></i>
            <span>{{title_case($row->name)}}</span>
        </a>
    </li>
    @endforeach

    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Addons
    </div>
    <li class="nav-item {{request()->route()->getName() == 'slideshow.index' ? 'active':''}}">
        <a class="nav-link" href="{{route('slideshow.index')}}">
            <i class="fas fa-fw fa-images"></i>
            <span>Slideshow</span>
        </a>
    </li>
    <li class="nav-item {{request()->route()->getName() == 'socmed.index' ? 'active':''}}">
        <a class="nav-link" href="{{route('socmed.index')}}">
            <i class="fa fa-fw fa-share-alt"></i>
            <span>Sosial Media</span>
        </a>
    </li>
    <li class="nav-item {{request()->route()->getName() == 'setting.index' ? 'active':''}}">
        <a class="nav-link" href="{{route('setting.index')}}">
            <i class="fas fa-fw fa-cog"></i>
            <span>Setting</span>
        </a>
    </li>

</ul>
<!-- End of Sidebar -->
