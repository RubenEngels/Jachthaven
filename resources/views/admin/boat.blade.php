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
            <table class="table table-striped">
              <tr>
                <th>Boot naam: </th>
                <th>Toegevoegd op: </th>
                <th>Acties: </th>
              </tr>
              @foreach ($boats as $boat)
                <tr>
                  <td>{{ $boat->name }}</td>
                  <td>{{ $boat->created_at->format('d/m/Y')}}</td>
                  <td><button href="#" data-toggle="modal" data-target="#boat_{{ str_slug($boat->id) }}" style="background-color:#163f92;" class="btn btn-primary">Wijzig</button></td>
                </tr>
              @endforeach
            </table>
          @else
            <h5>Er zijn nog geen boten geregistreerd</h5>
          @endif
        </div>
      </div>
    </div>
  </div>
  @foreach ($boats as $boat)
    <div class="modal fade" id="boat_{{ str_slug($boat->id) }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form action="/admin/boat/edit/{{ $boat->id }}" method="post">
            {{ csrf_field() }}
            <div class="modal-header">
              <h5 class="modal-title"><b>Wijzig boot</b></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <label class="form-label">Naam: </label>
              <input type="text" name="name" class="form-control" value="{{ $boat->name }}">
              <br>
              <label class="form-label">Eigenaar: </label>
              <select class="form-control" name="owner" disabled>
                @foreach (App\User::all() as $user)
                  <option value="{{ $user->id }}" {{ ($user->id == $boat->user->id) ? 'selected' : null }}>{{ $user->name }}</option>
                @endforeach
              </select>
              <br>
              <label class="form-label">Merk: </label>
              <input type="text" name="brand" class="form-control" value="{{ $boat->brand }}">
              <br>
              <label class="form-label">Type: </label>
              <input type="text" name="type" class="form-control" value="{{ $boat->type }}">
              <br>
              <label class="form-label">Kleur: </label>
              <input type="text" name="color" class="form-control" value="{{ $boat->color }}">
              <br>
              <label class="form-label">Lengte: </label>
              <input type="number" step="0.01" min="0" name="length" class="form-control" value="{{ $boat->length }}">
              <br>
              <label class="form-label">Breedte: </label>
              <input type="number" step="0.01" min="0" name="width" class="form-control" value="{{ $boat->width }}">
              <br>
              <label class="form-label">Diepte: </label>
              <input type="number" step="0.01" min="0" name="depth" class="form-control" value="{{ $boat->depth }}">
              <br>
              <label class="form-label">Hoogte: </label>
              <input type="number" step="0.01" min="0" name="heigth" class="form-control" value="{{ $boat->heigth }}">
              <br>
              <label class="form-label">Type boot: </label>
              <select class="form-control" name="boatType">
                <option value="sailboat" {{ ($boat->boatType == 'sailboat') ? 'selected' : null }}>Zeilboot</option>
                <option value="motorboat" {{ ($boat->boatType != 'sailboat') ? 'selected' : null }}>Motorboot</option>
              </select>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluiten</button>
              <a href="/admin/boat/delete/{{ $boat->id }}" class="btn btn-danger">Verwijderen</a>
              <button type="submit" class="btn btn-primary" style="background-color:#163f92;">Opslaan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  @endforeach
  {{ $boats->links() }}
@endsection