@extends('layouts.app')

@section('content')

  <div class="row" style="background-color:rgba(218, 218, 218, .5);border-radius:10px;">
    <div class="container">
      <div class="col-md-1">

      </div>
      <div class="col-md-5">
        <h3>Schrijf je nu in voor onze nieuwsbrief!</h3>
        <p>als je je inschrijft krijg je elke week een E-Mail met het laatste nieuws van de Jachthaven</p>
      </div>
      <form action="/" method="post">
        {{ csrf_field() }}
        <div class="col-md-2" style="margin-top:20px;">
          <label class="form-label">E-Mail</label>
          <input type="text" class="form-control" name="email" placeholder="jan@jansen.nl" required>

        </div>
        <div class="col-md-1" style="margin-top:47px;">
          <button type="submit" class="btn btn-primary">Schrijf je in!</button>
        </div>
        <div class="col-md-3">

        </div>
      </form>
    </div>
  </div>
@endsection
