@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading" style="background-color:rgba(22, 63, 146, .1)">
            <div class="row">
              <div class="col-md-10">
                <h4>Geregistreerde gebruikers</h4>
              </div>
              <div class="col-md-2">
                <a style="margin-top:3.5px;background-color:#163f92;" data-target="#user_search" data-toggle="modal" class="btn btn-primary">Zoeken</a>
              </div>
            </div>

          </div>
          <div class="panel-body">
            @if (null !== $users->first())
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
                      <div class="btn-group">
                        <button href="#" class="btn btn-primary btn-sm" style="background-color:#163f92;" data-target="#user_{{ $user->id }}" data-toggle="modal">Rechten</button>
                        <button type="button" style="background-color:#163f92;" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="caret"></span> </button>
                        <ul class="dropdown-menu">
                          <li><a href="#" data-toggle="modal" data-target="#user_change_{{ $user->id }}">Wijzig</a> </li>
                        </ul>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </table>
              {{ $users->links() }}
            @else
              <h5>Er zijn geen gebruikers gevonden</h5>
            @endif
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
              @if(Auth::user()->isAdmin())
                <label class="form-label">De gebruiker is havenmeester</label>
                <input type="checkbox" name="isAdmin" class="form-control" {{ ($user->isAdmin()) ? 'checked' : null }}>
                <input type="hidden" name="check1" value="show">
                <br>
              @else
                <input type="hidden" name="check1" value="hidden">
              @endif

              <label class="form-label">De gebruiker is boot eigenaar</label>
              <input type="checkbox" name="isOwner" class="form-control" {{ ($user->isOwner()) ? 'checked' : null}}>
              <br>
              <label class="form-label">De gebruiker is administratief medewerker</label>
              <input type="checkbox" name="isDocumenter" class="form-control" {{ ($user->isDocumenter()) ? 'checked' : null}}>
              <br>
              <label class="form-label">De gebruiker is een lid van bestuurd</label>
              <input type="checkbox" name="isManagement" class="form-control" {{ ($user->isManagement()) ? 'checked' : null}}>
              <br>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluiten</button>
              <button type="submit" class="btn btn-primary" style="background-color:#163f92">Opslaan</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="user_change_{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form action="/admin/users/change" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $user->id }}">
            <div class="modal-header">
              <h5 class="modal-title"><b>Wijzig gebruiker:</b> <i>{{ $user->name }}</i></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <label class="form-label">Naam</label>
              <input type="text" name="name" class="form-control" value="{{ $user->name }}" disabled>
              <br>
              <label class="form-label">E-Mail</label>
              <input type="email" name="email" class="form-control" value="{{ $user->email }}">
              <br>
              <label class="form-label">Stad</label>
              <input type="text" name="city" class="form-control" value="{{ $user->city }}">
              <br>
              <label class="form-label">Straat + Huisnummer</label>
              <input type="text" name="street" class="form-control" value="{{ $user->street }}">
              <br>
              <label class="form-label">Postcode</label>
              <input type="text" name="zip" class="form-control" value="{{ $user->zip }}">
              <br>
              <label class="form-label">Tel. Nummer</label>
              <input type="text" name="tel" class="form-control" value="{{ $user->tel }}">
              <br>
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

  <div class="modal fade" id="user_search" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><b>Zoek gebruikers op naam</b></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="text" class="form-control" placeholder="Jan Jansen..." id="search_input">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluiten</button>
          <button type="button" id="search_submit" class="btn btn-primary" style="background-color:#163f92">Zoeken</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function () {

      $('#search_submit').click(function () {
        window.location.href = '/admin/users/' + $('#search_input').val();
      });

      $('#search_input').keyup(function(e){
        if (e.keyCode == 13) {
          window.location.href = '/admin/users/' + this.value;
        }
      });

    });
  </script>
@endsection
