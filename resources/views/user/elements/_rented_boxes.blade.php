<div class="col-md-4">
  <div class="panel panel-default">
    <div class="panel-heading" style="background-color:rgba(22, 63, 146, .1)">
      <h4>Gehuurde Boxen</h4>
    </div>
    <div class="panel-body">
      @if (null !== $rented_boxes->first())
        <table class="table table-striped">
          <tr>
            <th>Box naam:</th>
            <th>Gehuurd op:</th>
            {{-- <th>Acties:</th> --}}
          </tr>
          @foreach ($rented_boxes as $rented)
            <tr>
              <td>Box {{ $rented->box->public_id }}</td>
              <td>{{ $rented->created_at->format('d/m/Y') }}</td>
              {{-- <td><a class="btn btn-primary btn-sm" style="background-color:rgb(22, 63, 146);" href="/user/rent/stop/{{ $rented->id }}">Stop met huren</a></td> --}}
            </tr>
          @endforeach
        </table>
      @else
        <h4>Je hebt op het moment geen boxen gehuurd</h4>
      @endif
    </div>
  </div>
</div>
