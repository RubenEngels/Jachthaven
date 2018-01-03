<div class="col-md-6">
  <div class="panel panel-default">
    <div class="panel-heading" style="background-color:rgba(22, 63, 146, .1)">
      <h4>Facturen &nbsp;<a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#newInvoice" style="background-color:#163f92;">Maak een nieuwe factuur</a> <a href="/admin/dashboard/invoice/export" class="btn btn-default btn-sm">Exporteer overzicht</a> </h4>
    </div>
    <div class="panel-body">
      @foreach($users as $user)
        <div class="dropdown" style="margin-top:3px;">
          {{-- <img src="/uploads/avatars/{{ $user->image }}" alt="user" width="32px" height="32px"> --}}
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" style="font-size:17px;">
              {{ $user->name }}
              <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            @if (count($user->invoice) !== 0)
              @foreach ($user->invoice as $invoice)
                <li><a data-toggle="modal" data-target="#invoice_{{ str_slug($invoice->id)}}" href="#">{{ $invoice->name}}</a></li>
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
    <div class="modal fade" id="invoice_{{ str_slug($invoice->id) }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <button type="submit" class="btn btn-primary" style="background-color:#163f92;">Krediteer</button>
                <a href="/user/invoice/pdf/{{ $invoice->id }}" class="btn btn-default">Bekijk</a>
                @if($invoice->payed_at == null)
                  <a id="showDateAlert" class="btn btn-primary" style="background-color:#163f92;">Zet op betaald</a>
                  {{-- <a href="/admin/invoice/setAsPayed/{{ $invoice->id }}" class="btn btn-primary" style="background-color:#163f92;">Zet op betaald</a> --}}
                  <script>
                  $(document).ready(function () {
                    $('#showDateAlert').click(function() {
                      window.location.href = "/admin/invoice/setAsPayed/{{$invoice->id}}/" + prompt('Op welke datum is de factuur betaald?');
                    });
                  })
                  </script>
                @else
                  <button disabled type="button" class="btn btn-primary" style="background-color:#163f92;">Deze factuur is reeds betaald</button>
                @endif
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

<div class="modal fade" id="newInvoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><b>Maak een nieuwe factuur</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form action="/admin/dashboard/invoice/new" method="post">
          {{ csrf_field() }}
          <div class="modal-body">
            <label class="form-label">Naam</label>
            <input type="text" name="name" class="form-control" required>
            <br>
            <label class="form-label">Voor</label>
            <select class="form-control" name="for" required>
              @foreach (App\User::all() as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
              @endforeach
            </select>
            <br>
            <label class="form-label">Te betalen voor</label>
            <input type="date" name="dueDate" class="form-control datepicker" value="{{ \Carbon\Carbon::now()->addWeeks(2)->format('Y-m-d') }}">
            <br>
            <label class="form-label">Selecteer producten om toe te voegen</label>
            <select class="form-control" id="picker" name="items[]" multiple>
              @foreach ($defaultInvoiceItems as $product)
                <option id="option_{{ $loop->index }}" value="{{ $product->id }}">{{ $product->name }}, € {{ $product->price}}</option>
              @endforeach
            </select>
            <div class="item-add-wrapper">
              <br>
              @foreach ($defaultInvoiceItems as $product)
                @if ($product->default_on_invoice)
                  <div class="row">
                    <div class="col-md-5">
                      <label class="form-label">Naam</label>
                      <input type="text" class="form-control" name="item_name[]" value="{{ $product->name }}">
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Prijs €</label>
                      <input type="number" step="0.01" min="0" class="form-control" name="item_price[]" value="{{ $product->price }}">
                    </div>
                    <div class="col-md-3">
                      <label class="form-label">Aantal</label>
                      <input type="number" name="item_quantity[]" class="form-control" min="1" value="{{ $product->quantity}}">
                    </div>
                  </div>
                @endif
              @endforeach
              <br>
            </div>
            <div class="row">
              <div class="col-md-12">
                <br>
                <a href="#" class="btn btn-primary add-item" style="background-color:#163f92;">Voeg velden toe</a>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluiten</button>
            <button type="submit" class="btn btn-primary" style="background-color:#163f92;">Sla op</button>
          </div>
        </form>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".item-add-wrapper"); //Fields wrapper
    var add_button      = $(".add-item"); //Add button ID
    var x = 1; //initlal text box count

    @foreach($defaultInvoiceItems as $product)
      $('#option_{{ $loop->index }}').click(function () {
        if (this.value != '') {

          if(x < max_fields){ //max input box allowed
              x++; //text box increment
              $(wrapper).append('<div class="row"><div class="col-md-5"><label class="form-label">Naam</label><input id="line_name_{{ $loop->index }}" type="text" class="form-control" name="item_name[]"class="form-control"></div><div class="col-md-4"><label class="form-label">Prijs €</label><input id="line_price_{{ $loop->index }}" type="number" step="0.01" min="0" class="form-control" name="item_price[]"class="from-control"></div><div class="col-md-3"><label class="form-label">Aantal</label><input id="line_quantity_{{ $loop->index }}" type="number" name="item_quantity[]"class="form-control" min="1"></div></div><br>'); //add input box
          }

          $.ajax({
            method: "POST",
            url: "/admin/dashboard/invoice/new/get/",
            data: {
              "_token": '{{ csrf_token() }}',
              "id": this.value
            }
          })
          .done(function( data ) {
            console.log(data.name);
            $('#line_name_{{ $loop->index}}').val(data.name);
            $('#line_quantity_{{ $loop->index }}').val(data.quantity);
            $('#line_price_{{ $loop->index }}').val(data.price);
          });
        }
      });
    @endforeach

    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div class="row"><div class="col-md-5"><label class="form-label">Naam</label><input type="text" class="form-control" name="item_name[]"class="form-control"></div><div class="col-md-4"><label class="form-label">Prijs €</label><input type="number" step="0.01" min="0" class="form-control" name="item_price[]"class="from-control"></div><div class="col-md-3"><label class="form-label">Aantal</label><input type="number" name="item_quantity[]"class="form-control" min="1"></div></div><br>'); //add input box
        }
    });
  });
</script>
