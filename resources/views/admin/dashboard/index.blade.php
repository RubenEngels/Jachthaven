@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4><i>Meldingen</i>&nbsp; <a href="#" data-toggle="modal" data-target="#newNotification"><i class="fa fa-plus fs-4x" aria-hidden="true"></i></a></h4>
              <!-- Modal -->
              <div class="modal fade" id="newNotification" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <form action="/admin/notifications" method="post">
                      {{ csrf_field() }}
                      <div class="modal-header">
                        <h4 class="modal-title"><b>Maak een nieuwe melding aan</b></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <label class="form-label">Bericht</label>
                        <textarea name="message" rows="8" class="form-control" cols="80" required></textarea>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluiten</button>
                        <button type="submit" class="btn btn-primary">Opslaan</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              {{-- End modal --}}
            </div>
            <div class="panel-body">
              @if(null !== $active->first())
                @foreach ($active as $notification)
                  <p>
                    <b>Bericht: </b><br>{{ $notification->message }}
                    <br>
                    <button href="#" data-toggle="modal" data-target="#{{ str_slug($notification->id) }}" style="margin-top:10px;" class="btn btn-primary">Wijzig</button>
                  </p>

                  <!-- Modal -->
                  <div class="modal fade" id="{{ str_slug($notification->id) }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <form action="/admin/notifications" method="post">
                          {{ csrf_field() }}
                          <input type="hidden" name="id" value="{{ $notification->id }}">
                          <div class="modal-header">
                            <h5 class="modal-title"><b>Wijzig Melding</b></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <label class="form-label">Bericht</label>
                            <textarea name="message" rows="8" class="form-control" cols="80" required>{{ $notification->message }}</textarea>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluiten</button>
                            <a href="/admin/notifications/delete/{{ $notification->id }}" class="btn btn-danger">Verwijderen</a>
                            <button type="submit" class="btn btn-primary">Opslaan</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                @endforeach
                {{ $active->links() }}
              @else
                <h5><i>Er zijn geen meldingen</i></h5>
              @endif
            </div>
          </div>
        </div>
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
                          <td><a href="#" class="btn btn-primary btn-sm" data-target="#{{ $newsletter->id }}" data-toggle="modal">Wijzig</a> </td>
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
    </div>
</div>
@foreach($newsletters as $newsletter)
  <!-- Modal -->
  <div class="modal fade" id="{{ $newsletter->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="/admin/dashboard/newsletter" method="post">
          {{ csrf_field() }}
          <input type="hidden" name="id" value="{{ $newsletter->id }}">
          <div class="modal-header">
            <h5 class="modal-title"><b>Wijzig nieuwsbrief:</b> <i>{{ $newsletter->name }}</i></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <label class="form-label">Naam</label>
            <input type="text" name="name" class="form-control" value="{{ $newsletter->name }}" required>
            <br>
            <label class="form-label">Inhoud</label>
            <textarea name="content" rows="8" cols="80" class="form-control">{{ $newsletter->content }}</textarea>
            <br>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluiten</button>
            <a href="/admin/dashboard/newsletter/delete/{{ $newsletter->id }}" class="btn btn-danger">Verwijderen</a>
            <button type="submit" class="btn btn-primary">Opslaan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endforeach

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
          <button type="submit" class="btn btn-primary">Opslaan</button>
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
          <select class="form-control" name="to">
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
          <button type="submit" class="btn btn-primary">Verstuur</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
