@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-7">
        <div class="panel panel-default">
          <div class="panel-heading" style="background-color:rgba(22, 63, 146, .1)">
            <h4><i>Geplande Evenementen</i></h4>
          </div>
          <div class="panel-body">
            @if(null !== $events->first())
              <table class="table table-striped">
                  <tr>
                    <th>Naam:</th>
                    <th>Waar:</th>
                    <th>Wanneer:</th>
                    <th>Van - Tot:</th>
                    <th>Acties:</th>
                  </tr>
                  @foreach ($events as $event)
                    <tr>
                      <td>{{ $event->name }}</td>
                      <td>{{ $event->location }}</td>
                      <td>{{ $event->date->format('d/m/Y') }}</td>
                      <td><i>{{ $event->from }}</i> uur - <i>{{ $event->till }}</i> uur</td>
                      <td>
                        <button href="#" data-toggle="modal" data-target="#{{ str_slug($event->name) }}" class="btn btn-primary" style="background-color:rgba(22,63,146,1);">Wijzig</button>
                      </td>
                    </tr>
                  @endforeach
                </table>
                {{ $events->links() }}
            @else
              <h4>Er zijn nog geen geplande evenementen!</h4>
            @endif
          </div>
        </div>
      </div>
      <div class="col-md-5">
        <div class="panel panel-default">
          <div class="panel-heading" style="background-color:rgba(22, 63, 146, .1)">
            <h4><i>Maak een nieuw evenement</i></h4>
          </div>
          <div class="panel-body">
            <form action="/admin/events" method="post">
              {{ csrf_field() }}
              <label class="form-label">Naam</label>
              <input type="text" name="name" class="form-control" required>
              <br>
              <label class="form-label">Locatie</label>
              <input type="text" name="location" class="form-control" required>
              <br>
              <label class="form-label">Datum</label>
              <input type="date" name="date" class="form-control" required>
              <br>
              <label class="form-label">Vanaf</label>
              <input type="text" name="from" class="form-control" required>
              <br>
              <label class="form-label">Tot</label>
              <input type="text" name="till" class="form-control" required>
              <br>
              <button type="submit" class="btn btn-primary" style="background-color:rgba(22, 63, 146, 1);">Sla op!</button>
            </form>
          </div>
        </div>
        <img src="/img/calendar_half_icon.png" alt="" style="opacity:.2;">
      </div>
    </div>
  </div>
@endsection


@foreach ($events as $event)
  <!-- Modal -->
  <div class="modal fade" id="{{ str_slug($event->name) }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="/admin/events" method="post">
          {{ csrf_field() }}
          <input type="hidden" name="id" value="{{ $event->id }}">
          <div class="modal-header">
            <h5 class="modal-title"><b>Wijzig evenement:</b> <i>{{ $event->name }}</i></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <label class="form-label">Naam</label>
            <input type="text" name="name" class="form-control" value="{{ $event->name }}" required>
            <br>
            <label class="form-label">Locatie</label>
            <input type="text" name="location" class="form-control" value="{{ $event->location }}" required>
            <br>
            <label class="form-label">Datum</label>
            <input type="date" name="date" class="form-control" value="{{ $event->date->format('Y-m-d') }}" required>
            <br>
            <label class="form-label">Vanaf</label>
            <input type="text" name="from" class="form-control" value="{{ $event->from }}" required>
            <br>
            <label class="form-label">Tot</label>
            <input type="text" name="till" class="form-control" value="{{ $event->till }}" required>
          </div>
          <div class="modal-footer">
            <p>Er zijn {{ $event->rsvp->count() }} inschrijving(en)!</p>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluiten</button>
            <a href="/admin/events/delete/{{ $event->id }}" class="btn btn-danger">Verwijderen</a>
            <button type="submit" class="btn btn-primary" style="background-color:rgba(22, 63, 146, 1);">Opslaan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endforeach
