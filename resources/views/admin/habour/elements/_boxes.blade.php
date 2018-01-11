<div class="col-md-6">
  <div class="panel panel-default">
    <div class="panel-heading" style="background-color:rgba(22, 63, 146, .1);">
      <h3>Box overzicht</h3>
    </div>
    <div class="panel-body">
      <table class="table table-striped">
        <tr>
          <th>Naam:</th>
          <th>Boot:</th>
          <th>In de haven:</th>
          <th>Steiger:</th>
          <th>Acties: </th>
        </tr>
        @foreach ($boxes as $box)
          <tr>
            <td>Box {{ $box->public_id }}</td>
            <td>{!! (!empty($box->boat)) ? $box->boat->name : '<b>-</b>' !!}</td>
            <td>
              @if (isset($box->boat))
                {!! ($box->boat->inHabour) ? '<i class="fa fa-check" aria-hidden="false"></i>' : '<i class="fa fa-times" aria-hidden="false"></i>'  !!}
              @else
                <b>-</b>
              @endif
            </td>
            <td>{{ $box->pier->public_id }}</td>
            <td>
              <div class="btn-group">
                <button href="#" data-toggle="modal" data-target="#{{ 'box_' . $box->id }}" style="background-color:#163f92;" class="btn btn-primary btn-sm">Wijs een boot toe</button>
                <button type="button" style="background-color:#163f92;" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="caret"></span></button>
                <ul class="dropdown-menu">
                  @if (null !== $box->boat)
                    <li><a href="/admin/habour/clearfortransfer/{{ $box->boat->id }}">Geef de boot vrij voor overplaatsing</a></li>
                    @if (!$box->boat->inHabour)
                      <li><a href="#" data-toggle="modal" data-target="#{{ 'rent_' . $box->id }}">Verhuur deze box</a> </li>
                    @endif
                  @else
                    <li><a href="#" data-toggle="modal" data-target="#{{ 'rent_' . $box->id }}">Verhuur deze box</a> </li>
                  @endif
                  <li><a href="#" data-toggle="modal" data-target="#{{ 'change_box_' . $box->id }}">Wijzig</a> </li>
                </ul>
              </div>
            </td>
          </tr>
        @endforeach
      </table>
      {{ $boxes->links() }}
    </div>
  </div>
</div>

@foreach ($boxes as $box)
  <div class="modal fade" id="{{ 'box_' . $box->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="/admin/habour/assign/box" method="post">
          {{ csrf_field() }}
          <input type="hidden" name="box_id" value="{{ $box->id }}">
          <div class="modal-header">
            <h5 class="modal-title"><b>Box acties:</b></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <label style="font-size:16px;" class="form-label"><i>Wijs een box toe aan een boot.</i></label>
            <br>
            <label class="form-label">Boot om toe te wijzen</label>
            @if (null !== $boats->first())
              <select class="form-control" name="boat_id">
                  @foreach ($boats as $boat)
                    <option value="{{ $boat->id }}">{{ $boat->name }}</option>
                  @endforeach
              </select>
            @elseif (isset($box->boat))
              <select class="form-control" disabled>
                <option>Er zit al een boot in deze box</option>
              </select>
            @else
              <select class="form-control" name="" disabled>
                <option value="">Er zijn geen boten beschikbaar</option>
              </select>
            @endif
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluiten</button>
            <button type="submit" class="btn btn-primary" style="background-color:#163f92">Opslaan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="{{ 'rent_' . $box->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="/admin/habour/rent" method="post">
          {{ csrf_field() }}
          <input type="hidden" name="box_id" value="{{ $box->id }}">
          <div class="modal-header">
            <h5 class="modal-title"><b>Verhuur deze box:</b></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            @if (isset($box->rent))
              <label class="form-label">Deze box is verhuurd aan</label>
              <select class="form-control" disabled>
                <option>{{ $box->rent->user->name }}</option>
              </select>
            @else
              <label class="form-label">Verhuur aan</label>
              <select class="form-control" name="rentTo">
                @foreach (App\User::all() as $user)
                  <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
              </select>
            @endif

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluiten</button>
            @if (isset($box->rent))
              <a class="btn btn-primary" style="background-color:#163f92;" href="/admin/habour/rent/relase/{{ $box->rent->id }}">Geef deze box vrij</a>
            @else
              <button type="submit" class="btn btn-primary" style="background-color:#163f92">Verhuur</button>
            @endif
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="change_box_{{ $box->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="/admin/habour/box/change" method="post">
          {{ csrf_field() }}
          <input type="hidden" name="box_id" value="{{ $box->id }}">
          <div class="modal-header">
            <h5 class="modal-title"><b>Wijzig deze box:</b></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <label class="form-label">Lengte:</label>
            <input type="number" step="0.01" class="form-control" name="length" value="{{ $box->length }}">
            <br>
            <label class="form-label">Breedte:</label>
            <input type="number" step="0.01" class="form-control" name="width" value="{{ $box->width }}">
            <br>
            <label class="form-label">Diepte:</label>
            <input type="number" step="0.01" class="form-control" name="depth" value="{{ $box->depth }}">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluiten</button>
            <button type="submit" class="btn btn-primary" style="background-color:#163f92">Sla op</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endforeach
