<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion toggled" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('workers.index') }}">
        <div class="sidebar-brand-icon">
            @php
                $logo = App\Models\Config::where('key','company_minilogo')->first()->value ?? null;
                $url = App\Models\File::where('id', $logo)->first()->source ?? null;
            @endphp
            @if ($url)
                <img width="60px" class="img-profile" src="{{ $url }}">
            @else
                <i class="fas fa-laugh-wink"></i>
            @endif
        </div>
        <div class="sidebar-brand-text mx-3">{{ __('Oficina Virtual') }}</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider mt-0">

    <!-- Heading -->
    <div class="sidebar-heading">
        {{__('Escritorio')}}
    </div>

    <li class="nav-item active">
        <a class="nav-link" href="{{ route('workers.index') }}">
            <i class="fas fa-user"></i>
            <span>{{__('Trabajadores')}}</span></a>
    </li>
    
    <li class="nav-item">
        <a class="nav-link" href="{{ route('offers.index') }}">
            <i class="fas fa-briefcase"></i>
            <span>{{__('Ofertas de Trabajo')}}</span></a>
    </li>

        <li class="nav-item">
        <a href="#collapseWorkOptions" class="nav-link" data-toggle="collapse" aria-expanded="true" aria-controls="collapseWorkOptions">
            <i class="fas fa-bars"></i>
            <span>Opciones de trabajo</span>
        </a>
        <div id="collapseWorkOptions" class="collapse dropdown-menu-right">
            <div class="bg-white py-2 collapse-inner rounded">
                <a href="{{ route('jobboards.index') }}" class="collapse-item">
                    <i class="fas fa-clipboard-list"></i>
                    <span>{{__('Bolsa de trabajo')}}</span>
                </a>
                <a href="{{ route('jobs.index') }}" class="collapse-item">
                    <i class="fas fa-briefcase"></i>
                    <span>{{__('Puestos de trabajo')}}</span>
                </a>
                <a href="{{ route('degreetitles.index') }}" class="collapse-item">
                    <i class="fas fa-graduation-cap"></i>
                    <span>{{ __('Titulaciones') }}</span>
                </a>
            </div>
        </div>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        {{__('Inventario')}}
    </div>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('stockmovements.index') }}">
            <i class="fas fa-exchange-alt"></i>
            <span>{{ __('Movimientos de Stock') }}</span>
        </a>
    </li>
    
    <li class="nav-item">
        <a class="nav-link" href="{{ route('products.index') }}">
            <i class="fas fa-cubes"></i>
            <span>{{__('Productos')}}</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('stockhistories.index') }}">
            <i class="fas fa-history"></i>
            <span>{{__('Historial')}}</span></a>
    </li>

    <li class="nav-item">
        <a href="#collapseTwo" class="nav-link" data-toggle="collapse" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-bars"></i>
            <span>Opciones de Inventario</span>
        </a>
        <div id="collapseTwo" class="collapse dropdown-menu-right">
            <div class="bg-white py-2 collapse-inner rounded">
                <a href="{{ route('providers.index') }}" class="collapse-item">
                    <i class="fas fa-truck"></i>
                    <span>{{__('Proveedores')}}</span>
                </a>
                <a href="{{ route('categories.index') }}" class="collapse-item">
                    <i class="fas fa-sitemap"></i>
                    <span>{{__('Categorías')}}</span>
                </a>
                <a href="{{ route('stockplaces.index') }}" class="collapse-item">
                    <i class="fas fa-warehouse"></i>
                    <span>{{ __('Lugares de Stock') }}</span>
                </a>
                <a href="{{ route('stockpersonals.index') }}" class="collapse-item">
                    <i class="fas fa-user"></i>
                    <span>{{ __('Personal de Stock') }}</span>
                </a>
            </div>
        </div>
    </li>
    
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        {{__('Herramientas')}}
    </div>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('calendar') }}">
            <i class="fas fa-fw fa-calendar"></i>
            <span>{{__('Calendario')}}</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('incidents.index') }}">
            <i class="fas fa-exclamation-triangle"></i>
            <span>{{__('Incidencias')}}</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('files.index') }}">
            <i class="fas fa-fw fa-folder-open"></i>
            <span>{{__('Ges. documental')}}</span></a>
    </li>

        <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        {{__('Ajustes')}}
    </div>
    
    <li class="nav-item">
        <a class="nav-link" href="{{ route('config') }}">
            <i class="fas fa-fw fa-wrench"></i>
            <span>{{__('Configuración')}}</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('users.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>{{__('Usuarios')}}</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('accesslog.index') }}">
            <i class="fas fa-fw fa-list"></i>
            <span>{{__('Log de accesos')}}</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
