<div class="col-md-12">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4>Facturen</h4>
    </div>
    <div class="panel-body">
      @foreach($users as $user)
        <div class="dropdown" style="margin-top:3px;">
          <img src="/uploads/avatars/{{ $user->image }}" alt="user" width="32px" height="32px">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" style="font-size:17px;">
              {{ $user->name }}
              <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            @if (count($user->invoice) !== 0)
              @foreach ($user->invoice as $invoice)
                <li><a data-toggle="modal" data-target="#{{ str_slug($invoice->id)}}" href="#">{{ $invoice->name}}</a></li>
              @endforeach
            @else
              <p style="padding-left:10px;padding-right:10px;">Deze gebruiker heeft nog geen facturen</p>
            @endif
          </ul>
        </div>
        <hr>
      @endforeach
      {{ $users->links() }}
    </div>
  </div>
</div>
@foreach($users as $user)
  @foreach ($user->invoice as $invoice)
    <div class="modal fade" id="{{ str_slug($invoice->id) }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"><b>Factuur:</b> {{ $invoice->name }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          @if(!$invoice->isCredited())
            <form action="/admin/dashboard/credit/invoice/{{ $invoice->id }}" method="post">
              {{ csrf_field() }}
              <div class="modal-body">
                <h4>Krediteer de factuur</h4>
                <label class="form-label">Reden</label>
                <textarea name="reason" rows="8" cols="80" class="form-control"></textarea>
                <br>
                <label class="from-control">Bedrag</label>
                <input type="number" name="amount" class="form-control" value="{{ $invoice->getTotal() }}" max="{{ $invoice->getTotal() }}">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluiten</button>
                <a href="/admin/invoice/delete/{{ $invoice->id}}" class="btn btn-danger">Verwijder</a>
                <button type="submit" class="btn btn-primary">Krediteer</button>
                <a href="/user/invoice/pdf/{{ $invoice->id }}" class="btn btn-default">Bekijk</a>
              </div>
            </form>
          @else
            <div class="modal-body">
              <h1>Deze factuur is a gekrediteerd!</h1>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluiten</button>
              <a href="/admin/invoice/delete/{{ $invoice->id}}" class="btn btn-danger">Verwijder</a>
              <a href="/user/invoice/pdf/{{ $invoice->id }}" class="btn btn-default">Bekijk</a>
            </div>
          @endif
        </div>
      </div>
    </div>
  @endforeach
@endforeach
