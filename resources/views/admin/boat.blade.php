@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading" style="background-color:rgba(22, 63, 146, .1)">
          <h4><i>Registreer een nieuwe boot</i></h4>
        </div>
        <div class="panel-body">
          <form action="/admin/boat/create" method="post">
            {{ csrf_field() }}
            <label class="form-label">Naam: </label>
            <input type="text" name="name" class="form-control">
            <br>
            <label class="form-label">Eigenaar: </label>
            <select class="form-control" name="owner">
              @foreach (App\User::all() as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
              @endforeach
            </select>
            <br>
            <label class="form-label">Merk: </label>
            <input type="text" name="brand" class="form-control">
            <br>
            <label class="form-label">Type: </label>
            <input type="text" name="type" class="form-control">
            <br>
            <label class="form-label">Kleur: </label>
            <input type="text" name="color" class="form-control">
            <br>
            <label class="form-label">Lengte: </label>
            <input type="number" step="0.01" min="0" name="length" class="form-control">
            <br>
            <label class="form-label">Breedte: </label>
            <input type="number" step="0.01" min="0" name="width" class="form-control">
            <br>
            <label class="form-label">Diepte: </label>
            <input type="number" step="0.01" min="0" name="depth" class="form-control">
            <br>
            <label class="form-label">Hoogte: </label>
            <input type="number" step="0.01" min="0" name="heigth" class="form-control">
            <br>
            <label class="form-label">Type boot: </label>
            <select class="form-control" name="boatType">
              <option value="sailboat">Zeilboot</option>
              <option value="motorboat">Motorboot</option>
            </select>
            <br>
            <button type="submit" class="btn btn-primary" style="background-color:rgb(22, 63, 146);">Registreer</button>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading" style="background-color:rgba(22, 63, 146, .1)">
          <h4><i>Geregistreerde boten</i></h4>
        </div>
        <div class="panel-body">
          @if (!empty($boats->all()))
            @foreach ($boats as $boat)
              <h5>Naam: {{ $boat->name }}</h5>
            @endforeach
          @else
            <h5>Er zijn nog geen boten geregistreerd</h5>
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection
