<div class="col-md-6">
  <div class="panel panel-default">
    <div class="panel-heading" style="background-color:rgba(22, 63, 146, .1)">
      <h4>Kraan Overzicht</h4>
    </div>
    <div class="panel-body">
      <h4>Vandaag:</h4>
      <table class="table table-striped">
        <tr>
          <th>Tijd: </th>
          <th>Actie: </th>
          <th>Eigenaar: </th>
          <th>Boot: </th>
        </tr>
        @foreach ($crane_reservations as $reservation)
          <tr>
            <td>{{ $reservation->time }}</td>
            <td>{{ ($reservation->type == 'in-water') ? 'Boot in het water zetten' : 'Boot op de kant zetten' }}</td>
            <td>{{ $reservation->user->name }}</td>
            <td>{{ $reservation->boat->name }}</td>
          </tr>
        @endforeach
      </table>
    </div>
  </div>
</div>
