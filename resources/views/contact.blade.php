@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row" style="padding-top:25px;">
      <div class="col-md-1"></div>
      <div class="col-md-3">
        <h2 style="padding-bottom:20px;">Neem contact met ons op!</h2>
        <p>Als je een vraag hebt over de prijzen, het huren van ligplaatsen of iets anders kan je ons altijd bereiken op de onderstaande contact gegevens of via het formulier op deze pagina.</p>
        <ul>
          <li><a href="tel:+31634891974">+31634891974</a></li>
          <li><a href="mailto:info@jachthavenharderwijk.nl">info@jachthavenharderwijk.nl</a></li>
        </ul>
        <div id="googleMap" style="width:100%;height:200px;margin-top:40px;"></div>

        <script>
          function initMap() {
            var mapSettings = {
                center: new google.maps.LatLng(51.508742,-0.120850),
                zoom: 8,
            };
            var Map = new google.maps.Map(document.getElementById("googleMap"), mapSettings);
          }
        </script>
      </div>
      <div class="col-md-7">
        <h2>&nbsp;</h2>
        <form class="" action="/contact" method="post">
          {{ csrf_field() }}
          <label class="form-label">Uw volledige naam *</label>
          <input type="text" name="name" placeholder="Jan Jansen" class="form-control" required>
          <br>
          <label class="form-label">Uw E-Mail adres *</label>
          <input type="email" name="email" placeholder="jan@jansen.nl" class="form-control" required>
          <br>
          <label class="form-label">Uw bericht *</label>
          <textarea name="message" rows="8" cols="80" class="form-control" placeholder="Beste Jachthaven..." required></textarea>
          <br>
          <p>* Deze velden zijn verplicht.</p>
          <button type="submit" class="btn btn-lg btn-primary" style="background-color:rgba(22, 63, 146, 1);">Verstuur!</button>
        </form>
      </div>
      <div class="col-md-1"></div>
    </div>
    <div class="row">
      <div class="col-md-2">

      </div>
      <img src="/img/mail_icon.png" alt="" style="opacity:0.05">
    </div>
  </div>
@endsection
