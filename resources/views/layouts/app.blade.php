<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
</head>
<body>

    <div id="app">
        @include('layouts.elements._nav')

        @if (session('status'))
          <div class="alert alert-success text-center" id="alert">
              {!! session('status') !!}
          </div>
        @endif

        @if(session('notifications'))
          <div class="alert alert-success text-center">
            Er zijn {{ session('notifications') }} nieuwe melding(en)! Klik <a href="/login">hier</a> om in te loggen.
          </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{!! $error !!}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://use.fontawesome.com/6b049bdfb5.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    {{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> --}}
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBfFVbzEvLOX-rl_kPlD6A-FtFORpfh4vQ&callback=initMap"
    async defer></script>

    <script>
      setTimeout(function() {
        $('#alert').hide();
      }, 5000)
    </script>
    <!-- Modal -->
    <div class="modal fade" id="inboxModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header" style="background-color:rgba(22, 63, 146, .1)">
            <h5 class="modal-title"><b>Inbox</b></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <?php $active = App\UserNotifications::where('show', true)->get(); ?>
            {{-- {{ dd($active)}} --}}

            @foreach($active as $notification)
              {{-- {{ dd($notification)}} --}}
              <p><b>Melding:</b> {!! $notification->message !!} </p>
              <hr>
            @endforeach

          <div class="modal-footer">
            <button type="button" class="btn btn-primary" style="background-color:rgba(22, 63, 146, 1);" data-dismiss="modal">Sluiten</button>
          </div>
        </div>
      </div>
    </div>
</body>
</html>
