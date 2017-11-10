@extends('layouts.app')

@section('content')
  <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
      <div class="panel panel-default">
        <div class="panel-heading" style="text-align:center;"><h3>Bewerk de instellingen</h3></div>
        <div class="panel-body">
          <form class="" action="/admin/settings" method="post">

            <label class="form-label">Box huur per jaar</label>
            <input type="text" name="box_jaar_huur" class="form-control" value="{!! $settings->box_jaar_huur !!}">
            <br>
            <label class="form-label">Toeristen belasting</label>
            <input type="text" name="toeristen_belasting" class="form-control" style="width:10%;" value="{!! $settings->toeristen_belasting !!}">
          </form>
        </div>
      </div>
    </div>
  </div>
@stop
