
<div class="row" style="background-color:#163f92;border-radius:10px;margin:5px;">
  <div class="container">
    <div class="col-md-1">

    </div>
    <div class="col-md-5">
      <h3 style="color:white;">Schrijf je nu in voor onze nieuwsbrief!</h3>
      <p style="color:white;">als je je inschrijft krijg je elke week een E-Mail met het laatste nieuws van de Jachthaven</p>
    </div>
    <form action="/" method="post">
      {{ csrf_field() }}
      <div class="col-md-2" style="margin-top:20px;">
        <label style="color:white;" class="form-label">E-Mail</label>
        <input style="color:black;" type="text" class="form-control" name="email" placeholder="jan@jansen.nl" required>

      </div>
      <div class="col-md-1" style="margin-top:47px;">
        <button type="submit" class="btn btn-default">Schrijf je in!</button>
        <br>
        <br>
      </div>
      <div class="col-md-3">

      </div>
    </form>
  </div>
</div>
