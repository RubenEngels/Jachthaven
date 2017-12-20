@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading" style="background-color:rgba(22, 63, 146, .1)">
            <h4>Geregistreerde gebruikers</h4>
          </div>
          <div class="panel-body">
            <table class="table table-striped">
              <tr>
                <th>Naam:</th>
                <th>E-Mail:</th>
                <th>Geregistreerd op:</th>
                <th>Acties: </th>
              </tr>
              @foreach ($users as $user)
                <tr>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->email }}</td>
                  <td>{{ $user->created_at->format('d/m/Y') }}</td>
                  <td>
                    <a href="#" class="btn btn-primary btn-sm" style="background-color:#163f92;" data-target="#user_{{ $user->id }}" data-toggle="modal">Acties</a>
                  </td>
                </tr>
              @endforeach
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  @foreach ($users as $user)
    <!-- Modal -->
    <div class="modal fade" id="user_{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form action="/admin/users" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $user->id }}">
            <div class="modal-header">
              <h5 class="modal-title"><b>Wijzig gebruiker:</b> <i>{{ $user->name }}</i></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <label class="form-label">Naam: </label>
              <input type="text" name="name" class="form-control" value="{{ $user->name }}">
              <br>
              <label class="form-label">E-Mail: </label>
              <input type="email" name="email" class="form-control" value="{{ $user->email }}">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluiten</button>
              <a href="/admin/users/delete/{{ $user->id }}" class="btn btn-danger">Verwijderen</a>
              <button type="submit" class="btn btn-primary" style="background-color:#163f92">Opslaan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  @endforeach
@endsection
