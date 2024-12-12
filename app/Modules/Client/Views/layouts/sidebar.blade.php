<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item {{ Request::is('dashboard*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('modules*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('modules.index') }}">
                <i class="icon-layout menu-icon"></i>
                <span class="menu-title">Modules</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('roles*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('roles.index') }}">
                <i class="icon-head menu-icon"></i>
                <span class="menu-title">Roles</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('privileges*') ? 'active' : '' }}">
            <a class="nav-link " href="{{ route('privileges.index') }}">
                <i class="icon-columns menu-icon"></i>
                <span class="menu-title">Privileges</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('clients*') ? 'active' : '' }}">
            <a class="nav-link"  href="{{ route('clients.index') }}">
                <i class="icon-head menu-icon"></i>
                <span class="menu-title">Clients</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('users*') ? 'active' : '' }}">
            <a class="nav-link"  href="{{ route('users.index') }}">
                <i class="icon-head menu-icon"></i>
                <span class="menu-title">Users</span>
            </a>
        </li>
    </ul>
  </nav>
