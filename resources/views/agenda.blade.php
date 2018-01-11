@extends('layouts.app')

@section('content')
  {{-- idea inschrijven voor envent --}}
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h3>Geplande evenementen</h3>
        <hr style="border:.5px solid gray">
      </div>
    </div>
    <div class="row">
      <div class="col-md-2">
        Op deze pagina vind u het overzicht met evenementen die bij ons geplant zijn. <br>Als u vragen heeft over een van deze evenementen of over iets anders, kan u contact opnemen via onze <a href="/contact">contact</a> pagina.
        <br>
        <br>
        <img src="/img/zeilboot_lang.jpg" alt="" width="90%">
        <br>&nbsp;
      </div>
      <div class="col-md-7">
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
                    <button href="#" data-toggle="modal" data-target="#{{ 'event_' . $event->id }}" class="btn btn-primary" style="background-color:rgba(22,63,146,1);">Ik kom!</button>
                  </td>
                </tr>
              @endforeach
            </table>
            {{ $events->links() }}
        @else
          <h4>Er zijn nog geen geplande evenementen!</h4>
        @endif
      </div>
      <div class="col-md-3">
          <img src="/img/calendar_icon.png" id="img_calendar" style="opacity:0.1;">
      </div>
    </div>
  </div>

  @foreach($events as $event)
    <!-- Modal -->
    <div class="modal fade" id="event_{{ $event->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form action="/event/rsvp" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $event->id }}">
            <div class="modal-header">
              <h5 class="modal-title"><b>Schrijf je in voor:</b> <i>{{ $event->name }}</i></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <label class="form-label">Naam</label>
              <input type="text" name="name" class="form-control" value="{{ @Auth::user()->name }}">
              <br>
              <label class="form-label">E-Mail:</label>
              <input type="email" name="email" class="form-control" value="{{ @Auth::user()->email }}">
              <br>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluiten</button>
              <button type="submit" class="btn btn-primary" style="background-color:#163f92">Schrijf je in</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  @endforeach
@endsection
