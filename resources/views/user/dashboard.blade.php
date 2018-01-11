@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-success text-center">
            Welkom terug {{ Auth::user()->name }}. Je bent ingelogd als
            @if (Auth::user()->isAdmin())
              <i><b>Havenmeester</b></i>.
            @elseif (Auth::user()->isOwner())
              <i><b>Boot eigenaar</b></i>.
            @else
              <i><b>Jachthaven lid</b></i>.
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
