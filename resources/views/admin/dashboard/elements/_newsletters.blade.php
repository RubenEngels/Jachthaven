<div class="col-md-9">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4><i>Nieuwsbrief</i>      &nbsp;
        <a href="#" class="btn btn-primary btn-sm" data-target="#newNewsletter" data-toggle="modal">Schrijf een nieuwsbrief</a>
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
                  <td><a class="btn btn-danger btn-sm" href="/admin/dashboard/mail/delete/{{ $recipient->id }}">Verwijder</a> </td>
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
                  <td><a href="#" class="btn btn-primary btn-sm" data-target="#{{ 'newsletter_' . $newsletter->id }}" data-toggle="modal">Wijzig</a> </td>
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
