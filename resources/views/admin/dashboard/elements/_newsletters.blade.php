<div class="col-md-9">
  <div class="panel panel-default">
    <div class="panel-heading" style="background-color:rgba(22, 63, 146, .1)">
      <h4><i>Nieuwsbrief</i>      &nbsp;
        <a href="#" class="btn btn-primary btn-sm" data-target="#newNewsletter" data-toggle="modal" style="background-color:#163f92;">Schrijf een nieuwsbrief</a>
        &nbsp;
        <a href="#" class="btn btn-default btn-sm" data-target="#send" data-toggle="modal">Verstuur een nieuwsbrief</a> </h4>
    </div>
    <div class="panel-body">
      <div class="row">
        <div class="col-md-6">
          <h4><b>Ontvangers:</b></h4>
          @if(null !== $mailing_list->first())
            <table class="table table-striped">
              <tr>
                <th>E-Mail</th>
                <th>Inschrijf datum</th>
                <th>Acties</th>
              </tr>
              @foreach ($mailing_list as $recipient)
                <tr>
                  <td>{{ $recipient->email }}</td>
                  <td>{{ $recipient->created_at->format('d/m/Y') }}</td>
                  <td><a class="btn btn-primary btn-sm" style="background-color:rgba(22, 63, 146, 1)" href="/admin/dashboard/mail/delete/{{ $recipient->id }}">Verwijder</a> </td>
                </tr>
              @endforeach
            </table>
            {{ $mailing_list->links() }}
          @else
            <h4>Er zijn nog geen inschrijvingen</h4>
          @endif
        </div>
        <div class="col-md-6">
          <h4><b>Nieuwsbrieven:</b></h4>
          @if(null !== $newsletters->first())
            <table class="table table-striped">
              <tr>
                <th>Naam</th>
                <th>Aangemaakt op</th>
                <th>Acties</th>
              </tr>
              @foreach($newsletters as $newsletter)
                <tr>
                  <td>{{ $newsletter->name }}</td>
                  <td>{{ $newsletter->created_at->format('d/m/Y')}}</td>
                  <td><a href="#" class="btn btn-primary btn-sm" style="background-color:#163f92;" data-target="#{{ 'newsletter_' . $newsletter->id }}" data-toggle="modal">Wijzig</a> </td>
                </tr>
              @endforeach
              {{ $newsletters->links() }}
            </table>
          @else
            <h4>Er zijn nog geen nieuwsbrieven</h4>
          @endif
          <br>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal new -->
<div class="modal fade" id="newNewsletter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="/admin/dashboard/newsletter" method="post">
        {{ csrf_field() }}
        <div class="modal-header">
          <h5 class="modal-title"><b>Maak een nieuwe nieuwsbrief</b></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <label class="form-label">Naam</label>
          <input type="text" name="name" class="form-control" required>
          <br>
          <label class="form-label">Inhoud</label>
          <textarea required name="content" rows="8" cols="80" class="form-control"></textarea>
          <br>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluiten</button>
          <button type="submit" class="btn btn-primary" style="background-color:#163f92">Opslaan</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal send -->
<div class="modal fade" id="send" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="/admin/dashboard/newsletter/send" method="post">
        {{ csrf_field() }}
        <div class="modal-header">
          <h5 class="modal-title"><b>Verstuur een nieuwsbrief</b></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <label class="form-lable">Verstuur naar:</label>
          <select class="form-control" name="to[]" multiple>
            <option value="everyone">Iedereen</option>
            @foreach($mailing_list as $person)
              <option value="{{ $person->email }}">{{ $person->email}}</option>
            @endforeach
          </select>
          <br>
          <label class="form-label">Kies een nieuwsbrief om te versturen:</label>
          <select class="form-control" name="newsletter">
            @foreach ($newsletters as $newsletter)
              <option value="{{ str_slug($newsletter->id) }}">{{ $newsletter->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluiten</button>
          <button type="submit" class="btn btn-primary" style="background-color:#163f92">Verstuur</button>
        </div>
      </form>
    </div>
  </div>
</div>
