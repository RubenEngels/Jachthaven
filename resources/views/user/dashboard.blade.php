@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading" style="background-color:rgba(22, 63, 146, .1)">
            Facturen
          </div>
          <div class="panel-body">
            @if(!empty(Auth::user()->invoice))
              <table class="table table-striped">
                <tr>
                  <th>Id</th>
                  <th>Naam</th>
                  <th>Verstuurd op</th>
                  <th>Te betalen voor</th>
                  <th>Acties</th>
                </tr>
                @php $i = 1; @endphp
                @foreach (Auth::user()->invoice->sortByDesc('id') as $invoice)
                  <tr>
                    <td>#{{ $i }}</td>
                    <td>{{ $invoice->name }}</td>
                    <td>{{ $invoice->sendDate->format('d/m/Y') }}</td>
                    <td>{{ $invoice->dueDate->format('d/m/Y') }}</td>
                    <td>
                      <a class="btn btn-primary" style="background-color:#163f92;" href="/user/invoice/pdf/{{ $invoice->id }}">Bekijk de factuur</a>
                    </td>
                  </tr>
                  @php $i++; @endphp
                @endforeach
              </table>
            @else
              <h4>Er zijn nog geen facturen</h4>
            @endif
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading" style="background-color:rgba(22, 63, 146, .1)">
          <h4>Plan een kraan reservering</h4>
        </div>
        <div class="panel-body">
          <form class="form" action="/user/dashboard/reservation/new" method="post">
            <label class="form-label">Datum</label>
            <input type="date" name="date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="form-control">
            <br>
            <label class="form-label">Type</label>
            <select class="form-control" name="type">
              <option value="in-water">In het water tillen</option>
              <option value="out-water">Uit het water tillen</option>
            </select>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection


{{-- <select class="form-control" name="date">
  @for ($i=1; $i <= 16; $i++)
    @foreach ($crane_reservations as $reservation)
      @if (\Carbon\Carbon::parse($reservation->time)->format('H:i') == $current_time->format('H:i'))
        <option disabled>Al Bezet</option>
      @else
        <option>{{ $current_time->format('H:i') }}</option>
      @endif
      @php $start_date = $start_date->addMinutes(30) @endphp
    @endforeach
  @endfor
</select> --}}
