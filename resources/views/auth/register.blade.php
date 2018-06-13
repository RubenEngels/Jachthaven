@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color:rgba(22, 63, 146, .1);">
                  <h4>Registreer</h4>
                </div>

                <div class="panel-body">
                  <div class="col-md-10 col-md-offset-1">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="control-label">Naam</label>
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                          <label for="email" class="control-label">E-Mail Adres</label>
                          <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                          @if ($errors->has('email'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('email') }}</strong>
                              </span>
                          @endif
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="control-label">Wachtwoord</label>
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="control-label">Bevestig Wachtwoord</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                        </div>
                        <div class="form-group">
                          <label class="form-label">Postcode</label>
                          <input type="text" id="zip" name="zip" class="form-control" >
                          <br>
                          <label class="form-label">Huisnummer</label>
                          <input type="text" id="hnr" name="number" class="form-control" >
                          <br>
                          <label class="form-label">Straat</label>
                          <input type="text" id="street" name="street" class="form-control" >
                          <br>
                          <label class="form-label">Stad</label>
                          <input type="text" id="city" name="city" class="form-control" >
                          <br>
                          <label class="form-label">Tel. Nummer</label>
                          <input type="text" name="tel" class="form-control" >
                          <br>
                          <label class="form-label">Ik ben een tijdelijke passant</label>
                          <input type="checkbox" name="passant" class="form-control">
                          <br>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary" style="background-color:rgb(22, 63, 146);">
                                    Registreer
                                </button>
                            </div>
                        </div>
                    </form>
                  </div>
                </div>
            </div>
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
@endsection
