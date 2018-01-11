@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="col-md-12">
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
        </tr>
      </table>
    </div>
  </div>
@endsection
