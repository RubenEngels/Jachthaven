@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-success text-center">
            Welkom terug {{ Auth::user()->name }}. Je bent ingelogd als
            @if (Auth::user()->isAdmin())
              <i><b>administrator</b></i>.
            @elseif (Auth::user()->isOwner())
              <i><b>boot eigenaar</b></i>.
            @else
              <i><b>jachthaven lid</b></i>.
            @endif
        </div>
      </div>
    </div>
    <div class="row">
      @include('user.elements._invoices')
      @include('user.elements._rented_boxes')
    </div>
    <div class="row">
      @include('user.elements._boats')
    </div>
  </div>
@endsection
