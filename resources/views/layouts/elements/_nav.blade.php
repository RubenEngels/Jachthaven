<nav class="navbar navbar-default navbar-static-top" style="background-color:rgba(214, 214, 214,0.7)">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                &nbsp;
                @include('layouts.elements._public_pages')
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">

              @role('Admin')
                @include('layouts.elements._admin_nav')
              @endrole




                <!-- Authentication Links -->
              @guest
                <li><a href="{{ route('login') }}">Log in <i class="fa fa-sign-in" aria-hidden="true"></i> </a></li>
              @else
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" style="position:relative;padding-left:50px;">
                        <img src="/uploads/avatars/{{ Auth::user()->image }}" alt="user" width="32px" height="32px" style="border-radius:50%;position:absolute;top:10px;left:10px;">
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu">
                        <li><a href="/user/profile"><i class="fa fa-user" aria-hidden="true"></i> Eigen profiel</a></li>
                        <li>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out" aria-hidden="true"></i> Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
              @endguest
            </ul>
        </div>
    </div>
</nav>
