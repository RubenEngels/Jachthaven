<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" style="color:white;">
        Admin Paneel&nbsp;&nbsp;<i class="fa fa-dashboard" aria-hidden="true"></i>
    </a>

    <ul class="dropdown-menu">
        @if (Auth::user()->isAdmin())
          <li><a href="/admin/settings">Instellingen <i class="fa fa-cog" style="padding-left:26px;" aria-hidden="true"></i> </a></li> {{-- not as management or --}}
          <li><a href="/admin/stats">Statestieken<i class="fa fa-bar-chart" style="padding-left:25px;" aria-hidden="true"></i> </a> </li>
        @endif
        @if (Auth::user()->isAdmin() || Auth::user()->isManagement())
          <li><a href="/admin/events">Agenda <i class="fa fa-calendar" style="padding-left:50px;" aria-hidden="true"></i> </a></li>
          <li><a href="/admin/documents">Documenten <i class="fa fa-file" style="padding-left:18px;" aria-hidden="true"></i> </a> </li>
        @endif

        @if (Auth::user()->isAdmin() || Auth::user()->isDocumenter())
          <li><a href="/admin/dashboard">Overzicht <i class="fa fa-home" style="padding-left:38px;" aria-hidden="true"></i> </a></li>
            <li><a href="/admin/users">Gebruikers<i class="fa fa-user" style="padding-left:36px;" aria-hidden="true"></i> </a> </li>
            <li><a href="/admin/boat/create">Boten<i class="fa fa-ship" style="padding-left:65px;" aria-hidden="true"></i> </a> </li>
            <li><a href="/admin/habour/overview">De Haven<i class="fa fa-ship" style="padding-left:40px;" aria-hidden="true"></i> </a> </li>
        @endif
    </ul>
</li>
