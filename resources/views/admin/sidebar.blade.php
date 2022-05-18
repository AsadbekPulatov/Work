<div class="sidebar sidebar-style-2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-primary">
                <li class="nav-item {{  request()->routeIs('admin.users.index') ? 'active' : '' }}">
                    <a href="{{route('admin.users.index')}}">
                        <i class="fas fa-user"></i>
                        <p>Foydalanuvchi</p>
                    </a>
                </li>

                @if(\Illuminate\Support\Facades\Auth::user()->role != 'super_admin')
                    <li class="nav-item {{  request()->routeIs('admin.students.index') ? 'active' : '' }}">
                        <a href="{{route('admin.students.index')}}">
                            <i class="fas fa-graduation-cap"></i>
                            <p>Talabalar</p>
                        </a>
                    </li>
                @endif
                @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
                    <li class="nav-item {{  request()->routeIs('admin.binos.index') ? 'active' : '' }}">
                        <a href="{{route('admin.binos.index')}}">
                            <i class="bi bi-bank"></i>

                            <p>Binolar</p>
                        </a>
                    </li>

                    <li class="nav-item {{  request()->routeIs('admin.facultets.index') ? 'active' : '' }}">
                        <a href="{{route('admin.facultets.index')}}">
                            <i class="fas fa-building"></i>
                            <p>Fakultet</p>
                        </a>
                    </li>
                @endif
                @if(\Illuminate\Support\Facades\Auth::user()->role != 'super_admin')
                    <li class="nav-item {{  request()->routeIs('admin.floors.index') ? 'active' : '' }}">
                        <a href="{{route('admin.floors.index')}}">
                            <i class="fas fa-door-closed"></i>
                            <p>Qavatlar</p>
                        </a>
                    </li>

                    <li class="nav-item {{  request()->routeIs('admin.rooms.index') ? 'active' : '' }}">
                        <a href="{{route('admin.rooms.index')}}">
                            <i class="fas fa-door-open"></i>
                            <p>Xonalar</p>
                        </a>
                    </li>
                @endif
                @if(\Illuminate\Support\Facades\Auth::user()->role != 'super_admin')
                    <li class="nav-item {{  request()->routeIs('admin.attendances.index') ? 'active' : '' }}">
                        <a href="{{route('admin.attendances.index')}}">
                            <i class="fas fa-address-book"></i>
                            <p>Davomat</p>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>


