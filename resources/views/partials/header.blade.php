<header class="header-area">
    <div class="header-logo">
        <a href="">
            <h3>Admin Template</h3>
        </a>
        <div class="nav-bar">
            <i class="bx bx-menu"></i>
        </div>
    </div>
    <div class="header-nav">
        <div class="nav-items">
            <div class="nav-item">
                @if(Auth::guard('admin')->user())
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" id="dropdownMenuLink" data-bs-toggle="dropdown">
                        <i class="bx bx-user"></i>
                        <span>{{ Auth::guard('admin')->user()->name  }}</span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li><a class="dropdown-item" href="{{ route('admin.change.password') }}">Change Password</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            {!! Form::open(['route' => 'admin.logout', 'method' => 'POST']) !!}
                                <button type="submit" class="dropdown-item">Logout</button>
                            {!! Form::close() !!}
                        </li>
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>
</header>
