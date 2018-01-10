@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading" style="background-color:rgba(22,63,146,.1);">
            <h4>Gebruikers</h4>
          </div>
          <div class="panel-body">
            <table class="table table-striped">
              <tr>
                <th>Administrators:</th>
                <th>Boot eigenaren:</th>
                <th>Leden:</th>
                <th>Totaal:</th>
              </tr>
              <tr>
                <td><b>{{ $users->where('admin', true)->count() }}</b> Administrator(s)</td>
                <td><b>{{ $users->where('owner', true)->count() }}</b> Boot eigenaren</td>
                <td><b>{{ $users->where('admin', false)->where('owner', false)->count() }}</b> Leden</td>
                <td><b>{{ $users->count() }}</b> Gebruikers</td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading" style="background-color:rgba(22,63,146,.1);">
            <h4>Agenda items</h4>
          </div>
          <div class="panel-body">
            <table class="table table-striped">
              <tr>
                <th>Agenda items:</th>
                <th>Eerste item:</th>
                <th>Laaste item:</th>
                <th>Totaal inschrijvingen:</th>
              </tr>
              <tr>
                <td><b>{{ $events->count() }}</b> Item(s)</td>
                <td>{{ $events->sortBy('date')->first()->date->format('d/m/Y') }}</td>
                <td>{{ $events->sortByDesc('date')->first()->date->format('d/m/Y') }}</td>
                <td><b>{{ $rsvp->count() }}</b> inschrijving(en)</td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading" style="background-color:rgba(22,63,146,.1);">
            <h4>Boxen</h4>
          </div>
          <div class="panel-body">
            <table class="table table-striped">
              <tr>
                <th>Boxen / Walplaatsen:</th>
                <th>Verhuurde Boxen:</th>
                <th>Boten</th>
              </tr>
              <tr>
                <td><b>{{ $boxes->count() }}</b> / <b>{{ $walplaatsen->count() }}</b></td>
                <td><b>{{ $rented->count() }}</b> Box(en)</td>
                <td><b>{{ $boats->count() }}</b> Boten  </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
