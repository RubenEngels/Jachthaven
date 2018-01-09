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
            <td>
              <a href="#" class="btn btn-primary btn-sm" style="background-color:#163f92;" data-target="#{{ 'box_' . $box->id }}" data-toggle="modal">Acties</a>
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
            @if (null !== $box->boat)
              <a class="btn btn-default" href="/admin/habour/clearfortransfer/{{ $box->boat->id }}">Geef de boot vrij voor overplaatsing</a>
            @endif
            <button type="submit" class="btn btn-primary" style="background-color:#163f92">Opslaan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endforeach
