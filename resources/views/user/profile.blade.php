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
                <label class="form-label">Postcode</label>
                <input type="text" id="zip" name="zip" class="form-control" value="{{ $user->zip }}">
                <br>
                <label class="form-label">Huisnummer</label>
                <input type="text" id="hnr" name="number" class="form-control" value="{{ explode(' ', $user->street)[1] }}">
                <br>
                <label class="form-label">Straat</label>
                <input type="text"  id="street" name="street" class="form-control" value="{{ explode(' ', $user->street)[0] }}" disabled>
                <br>
                <label class="form-label">Stad</label>
                <input type="text" id="city" name="city" class="form-control" value="{{ $user->city }}" disabled>
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

  <script>
    $(document).ready(function () {
      $('#hnr').focusout(function (e) {
        e.preventDefault();

        $.ajax({
          "async": true,
          "crossDomain": true,
          "url": "https://api.postcodeapi.nu/v2/addresses/?postcode=" + $('#zip').val() + "&number=" + $('#hnr').val(),
          "method": "GET",
          "headers": {
            "x-api-key": "eQwbdysRpp16m01kld7C73CkxZjK4SBv6FlxdFU8",
            "accept": "application/hal+json"
          }
        }).done(function (response) {
          var addresses = response._embedded.addresses[0];

          $('#street').val(addresses.street);
          $('#city').val(addresses.municipality.label)

          console.log(addresses);
        });
      });
    });
  </script>
@stop
