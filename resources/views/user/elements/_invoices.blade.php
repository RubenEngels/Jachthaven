<div class="col-md-8">
  <div class="panel panel-default">
    <div class="panel-heading" style="background-color:rgba(22, 63, 146, .1)">
      <h4>Facturen</h4>
    </div>
    <div class="panel-body">
      @if(Auth::user()->invoice->first() != null)
        <table class="table table-striped">
          <tr>
            <th>Id</th>
            <th>Naam</th>
            <th>Verstuurd op</th>
            <th>Te betalen voor</th>
            <th>Acties</th>
          </tr>
          @foreach (Auth::user()->invoice->sortByDesc('id') as $invoice)
            <tr>
              <td>#{{ $loop->index + 1 }}</td>
              <td>{{ $invoice->name }}</td>
              <td>{{ $invoice->sendDate->format('d/m/Y') }}</td>
              <td>
                @if (isset($invoice->payed_at))
                  <i>Is al betaald!</i>
                @else
                  {{ $invoice->dueDate->format('d/m/Y') }}
                @endif
              </td>
              <td>
                <a class="btn btn-primary" style="background-color:#163f92;" href="/user/invoice/pdf/{{ $invoice->id }}">Bekijk de factuur</a>
              </td>
            </tr>
          @endforeach
        </table>
      @else
        <h4>Er zijn nog geen facturen</h4>
      @endif
    </div>
  </div>
</div>
