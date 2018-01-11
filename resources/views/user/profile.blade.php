@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-6">
              <form class="" action="/user/profile" method="post">
                {!! csrf_field() !!}
                <label class="form-label">Uw naam</label>
                <input type="text" name="name" class="form-control" value="{{ $user->name }}" disabled>
                <br>
                <label class="form-label">E-Mail</label>
                <input type="email" name="email" class="form-control" value="{{ $user->email }}">
                <br>
                <label class="form-label">Stad</label>
                <input type="text" name="city" class="form-control" value="{{ $user->city }}">
                <br>
                <label class="form-label">Straat + Huisnummer</label>
                <input type="text" name="street" class="form-control" value="{{ $user->street }}">
                <br>
                <label class="form-label">Postcode</label>
                <input type="text" name="zip" class="form-control" value="{{ $user->zip }}">
                <br>
                <label class="form-label">Tel. Nummer</label>
                <input type="text" name="tel" class="form-control" value="{{ $user->tel }}">
                <br>

                <button type="submit" class="btn btn-lg btn-primary" style="background-color:rgba(22, 63, 146, 1);">Sla op!</button>
              </form>
            </div>
            <div class="col-md-6">
              <img src="/img/user_icon.png" alt="test" style="opacity:0.05">
            </div>
        </div>
      </div>
    </div>
  </div>


  {{-- MODAL --}}
  <div class="modal fade" id="editPhoto" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <form action="/user/profile/photo" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Wijzig uw foto</h4>
          </div>
          <div class="modal-body">
            <label class="form-label">Upload een foto</label>
            <input type="file" name="photo" class="form-control">
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Opslaan</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Sluiten</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@stop
