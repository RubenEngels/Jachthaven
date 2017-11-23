@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
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
                      <a class="btn btn-primary" href="/user/invoice/pdf/{{ $invoice->id }}">Bekijk de factuur</a>
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
  </div>
@endsection
