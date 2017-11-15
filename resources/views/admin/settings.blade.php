@extends('layouts.app')

@section('content')

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <ul class="nav nav-tabs">
        <li class="active"><a  href="#1" data-toggle="tab">Algemene instellingen</a></li>
      </ul>
      <div class="tab-content ">
        <div class="tab-pane active" id="1">
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
                    <input type="submit" class="btn btn-primary btn-lg" value="Sla op!">
                  </div>
                  <div class="col-md-6">
                    <img src="/img/settings_icon.png" alt="settings half wheel" style="opacity:.1">
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@stop
