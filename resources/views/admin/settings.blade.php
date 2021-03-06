@extends('layouts.app')

@section('content')

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <ul class="nav nav-tabs">
        <li class=""><a  href="#1" data-toggle="tab">Algemene instellingen</a></li>
        <li class="active"><a href="#2" data-toggle="tab">Standaard producten factuur</a></li>
        <li><a href="#3" data-toggle="tab">Indeling box / wal plaatsen</a> </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane" id="1">
            <div class="panel-heading" style="text-align:center;"><h3>Bewerk de algemene instellingen</h3></div>
            <div class="panel-body">
              <form class="" action="/admin/settings" method="post" style="align:center;">
                {!! csrf_field() !!}
                <div class="row">
                  <div class="col-md-3"></div>
                  <div class="col-md-3">
                    <label class="form-label">Box huur per jaar</label>
                    <input type="text" name="box_jaar_huur" class="form-control" value="{!! $settings->box_jaar_huur !!}">
                    <br>
                    <label class="form-label">Toeristen belasting</label>
                    <input type="text" name="toeristen_belasting" class="form-control" value="{!! $settings->toeristen_belasting !!}">
                    <br>
                    <label class="form-label">Btw percentage</label>
                    <input type="text" name="btw" class="form-control" value="{!! $settings->btw !!}">
                    <br>
                    <label class="form-label">Inschijf geld</label>
                    <input type="text" name="inschrijf_geld" class="form-control" value="{!! $settings->inschrijf_geld !!}">
                    <br>
                    <label class="form-label">Lidmaatschap geld per jaar</label>
                    <input type="text" name="lidmaatschap_prijs" class="form-control" value="{!! $settings->lidmaatschap_prijs !!}">
                    <br>
                    <label class="form-label">Vereiste tijd voor kraan reserveringen</label>
                    <input type="text" name="kraan_tijd_vereist" class="form-control" value="{!! $settings->kraan_tijd_vereist !!}">
                    <br>
                    <label class="form-label">Kraan reservering start tijd</label>
                    <input type="text" name="crane_start_time" class="form-control" value="{!! $settings->crane_start_time !!}">
                    <br>
                    <label class="form-label">Duur van een periode</label>
                    <select class="form-control" name="period">
                      @for ($i=0; $i < 12; $i++)
                        <option {{ ($settings->period == $i + 1) ? 'selected' : null }} value="{{ $i + 1 }}">{{ $i + 1 }} Maand(en)</option>
                      @endfor
                    </select>
                    <br>
                    <input type="submit" class="btn btn-primary btn-lg" style="background-color:rgba(22, 63, 146, 1);" value="Sla op!">
                  </div>
                  <div class="col-md-6">
                    <img src="/img/settings_icon.png" alt="settings half wheel" style="opacity:.1">
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="tab-pane active" id="2">
            <div class="panel-heading" style="text-align:center;">
              <h3>Standaard producten factuur</h3>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-6">
                  <h4>Bestaande producten</h3>
                  <br>
                  @if (null !== $invoice_products->first())
                    <table class="table table-striped">
                      <tr>
                        <th>Id</th>
                        <th>Naam</th>
                        <th>Standaard aantal</th>
                        <th>Prijs</th>
                        <th>Op factuur</th>
                        <th>Acties</th>
                      </tr>
                      @foreach ($invoice_products as $product)
                        <tr>
                          <td>{{ $product->id }}</td>
                          <td>{{ $product->name }}</td>
                          <td>{{ $product->quantity }}</td>
                          <td>€ {{ $product->price }}</td>
                          <td>
                            @if ($product->default_on_invoice)
                              <i class="fa fa-check" aria-hidden="true"></i>
                            @else
                              <i class="fa fa-times" aria-hidden="true"></i>
                            @endif
                          </td>
                          <td><a href="#" class="btn btn-primary" style="background-color:rgba(22, 63, 146, 1);" data-toggle="modal" data-target="#product_{{ $product->id }}">Wijzig</a></td>
                        </tr>
                      @endforeach
                    </table>
                    {{ $invoice_products->links()}}
                  @else
                    <h3>Er zijn nog geen standaard producten aangemaakt</h3>
                  @endif
                </div>
                <div class="col-md-6">
                  <h4>Maak een nieuw product aan</h4>
                  <br>
                  <form action="/admin/settings/invoice/products/new" method="post">
                    {{ csrf_field() }}
                    <label class="form-label">Naam</label>
                    <input type="text" name="name" class="form-control">
                    <br>
                    <label class="form-label">Aantal</label>
                    <input type="number" name="quantity" class="form-control">
                    <br>
                    <label class="form-label">Prijs</label>
                    <input type="number" step="0.01" name="price" class="form-control">
                    <br>
                    <label class="form-label">Standaard op factuur</label>
                    <input type="checkbox" name="default_on_invoice" class="form-control">
                    <br>
                    <button type="submit" class="btn btn-primary" style="background-color:rgba(22, 63, 146, 1);">Sla op</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane" id="3">
            <div class="panel-heading" style="text-align:center;">
              <h3>Indeling box / wal plaatsen</h3>
            </div>
            <div class="panel-body">
              <form action="/admin/settings/layout" method="post" onsubmit="return confirm('Als u dit doet moeten alle boten opnieuw ingedeeld worden!');">
                {{ csrf_field() }}
                <label class="from-label">Aantal boxen</label>
                <input type="number" name="boxes" value="{{ App\Box::where('isWalplaats', 0)->count() }}" class="form-control" min="0" max="400">
                <br>
                <label class="from-label">Aantal walplaatsen</label>
                <input type="number" name="walplaatsen" value="{{ App\Box::where('isWalplaats', 1)->count() }}" class="form-control" min="0" max="400">
                <br>
                <p>
                  <button type="submit" class="btn btn-primary" style="background-color:rgb(22, 63, 146);">Wijzig indeling</button>
                  &nbsp;&nbsp;(Totaal maximaal 400)
                </p>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@foreach($invoice_products as $product)
  <div class="modal fade" id="product_{{ str_slug($product->id) }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="/admin/invoice/product/change/{{ $product->id }}" method="post">
          {{ csrf_field() }}
          <div class="modal-header">
            <h5 class="modal-title"><b>Wijzig product</b>: {{ $product->name }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <label class="form-label">Naam</label>
            <input type="text" name="name" value="{{ $product->name }}" class="form-control">
            <br>
            <label class="form-label">Aantal</label>
            <input type="number" name="quantity" value="{{ $product->quantity }}" class="form-control">
            <br>
            <label class="form-label">Prijs</label>
            <input type="number" step="0.01" name="price" value="{{ $product->price }}" class="form-control">
            <br>
            <label class="form-label">Standaard op factuur</label>
            <input type="checkbox" name="default_on_invoice" class="form-control" {{ ($product->default_on_invoice) ? 'checked' : null }}>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluiten</button>
            <a href="/admin/invoice/product/delete/{{ $product->id }}" class="btn btn-danger">Verwijderen</a>
            <button type="submit" class="btn btn-primary" style="background-color:rgba(22, 63, 146, 1);">Opslaan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endforeach

{{-- <script>
  $(document).ready(function () {
    $('#test').click(function () {
      swal({
        title: "Weet u dit zeker?",
        text: "Alle boten zullen opnieuw ingedeeld moeten worden",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      }).then((willDelete) => {
        if (willDelete) {
          $.post('/admin/settings/layout', {
            'boxes': $('#boxes').value,
            'walplaatsen': $('#walplaatsen').value,
            'csrf_token': '{{ csrf_token() }}',
          }, function (data) {
            swal('De box / wal plaatsen zijn opnieuw ingedeeld');
          });
        } else {
          swal("De wijzigingen worden niet uitgevoerd");
        }
      });
    });
  });
</script> --}}

@stop
