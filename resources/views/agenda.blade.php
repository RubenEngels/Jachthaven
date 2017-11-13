@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h3>Opkomende evenementen</h3>
        <hr style="border:.5px solid gray">
      </div>
    </div>
    <div class="row">
      <div class="col-md-2">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
      </div>
      <div class="col-md-7">
        @foreach($events as $event)
          
          <hr>
        @endforeach
      </div>
      <div class="col-md-3">
          <img src="/img/calendar_icon.png" alt="" style="opacity:0.1;">
      </div>
    </div>
  </div>
@endsection
