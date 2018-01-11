@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading" style="background-color:rgba(22, 63, 146, .1);">
          <h4>Statestieken</h4>
        </div>
        <div class="panel-body">
          <table class="table table-striped">
            <tr>
              <th>Leden</th>
              <th>Boten</th>
              <th>Passanten</th>
              <th>Totaal verhuurde boxen</th>
              <th>Omzet (afgelopen periode)</th>
            </tr>
            <tr>
              <td>{{ $users->where('owner', false)->where('admin', false)->count() }} Leden</td>
              <td>{{ $boats->count() }} Boten</td>
              <td>{{ $users->where('passant', true)->count() }} Passant(en)</td>
              <td>{{ $rented->count() }} Box(en)</td>
              <td>&euro; {{ $revenue }} ,-</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection
