<div class="col-md-6">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4>Kraan Overzicht</h4>
    </div>
    <div class="panel-body">
      <h4>Vandaag:</h4>
      <select class="" name="">
        @for ($i=1; $i <= 16; $i++)
          @foreach ($crane_reservations as $reservation)
            @if (\Carbon\Carbon::parse($reservation->time)->format('H:i') == $current_time->format('H:i'))
              <option disabled>Already taken</option>
            @else
              <option>{{ $current_time->format('H:i') }}</option>
            @endif
            @php $start_date = $start_date->addMinutes(30) @endphp
          @endforeach
        @endfor
      </select>
    </div>
  </div>
</div>
{{--

for ($i=1; $i <= 16 ; $i++) {
  $current_time = $start_date->addMinutes(30);
  foreach (App\CraneReservation::all() as $reservation) {
    if (Carbon::parse($reservation->time)->format('H:i') == $current_time->format('H:i')) {
      echo "already taken <br>";
    } else {
      echo $current_time->format('H:i') . '<br>';
    }
    $start_date = $current_time;
  }
}
return; --}}
