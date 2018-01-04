<div class="col-md-12">
  <div class="panel panel-default">
    <div class="panel-heading" style="background-color:rgba(22, 63, 146, .1)">
      <h4>Je eigen boten</h4>
    </div>
    <div class="panel-body">
      @if(Auth::user()->boats->first() != null)
        <table class="table table-striped">
          <tr>
            <th>Naam:</th>
            <th>Geregistreerd op:</th>
            <th>In de haven:</th>
            <th>Acties:</th>
          </tr>
          @foreach (Auth::user()->boats as $boat)
            <tr>
              <td>{{ $boat->name }}</td>
              <td>{{ $boat->created_at->format('d/m/Y') }}</td>
              <td>{!! ($boat->inHabour) ? '<i class="fa fa-check" aria-hidden="false"></i>' : '<i class="fa fa-times" aria-hidden="false"></i>' !!}</td>
              <td>
                <button href="#" data-toggle="modal" data-target="#{{ str_slug($boat->name) }}" style="background-color:#163f92;" class="btn btn-primary">Acties</button>
              </td>
            </tr>
          @endforeach
        </table>
      @else
        <h4>Er zijn nog geen geregistreerde boten!</h4>
      @endif
    </div>
  </div>
</div>

@foreach (Auth::user()->boats as $boat)
  <!-- Modal -->
  <div class="modal fade" id="{{ str_slug($boat->name) }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="/user/dashboard/plan" method="post">
          {{ csrf_field() }}
          <div class="modal-header">
            <h5 class="modal-title"><b>Plan een reservering</b></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <label class="form-label">Kies een datum</label>
            <input type="date" name="date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="form-control">
            <br>
            <input type="hidden" name="boat_id" value="{{ $boat->id }}">
            <label class="form-label">Type</label>
            <select class="form-control" name="type">
              <option value="in-water">In het water zetten</option>
              <option value="out-water">Op de kant zetten</option>
            </select>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluiten</button>
            <button type="submit" class="btn btn-primary" id="reserve" style="background-color:#163f92;">Reserveer</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endforeach