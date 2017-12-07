@extends('layouts.app')

@section('content')

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <ul class="nav nav-tabs">
        <li class=""><a  href="#1" data-toggle="tab">Algemene instellingen</a></li>
        <li class="active"><a href="#2" data-toggle="tab">Standaard producten factuur</a></li>
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
                        <th>Acties</th>
                      </tr>
                      @foreach ($invoice_products as $product)
                        <tr>
                          <td>{{ $product->id }}</td>
                          <td>{{ $product->name }}</td>
                          <td>{{ $product->quantity }}</td>
                          <td>€ {{ $product->price }}</td>
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
                    <button type="submit" class="btn btn-primary" style="background-color:rgba(22, 63, 146, 1);">Sla op</button>
                  </form>
                </div>
              </div>
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

@stop
