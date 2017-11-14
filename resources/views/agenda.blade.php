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
      </div>
      <div class="col-md-7">
        @foreach($events as $event)
          <p><b>{{ $event->name }}</b></p>
          <p>
            <b>Waar / Wanneer:</b> <i>{{ $event->location }} / {{ $event->date->format('d/m/Y')}}</i>
          </p>
          <p>
            <b>Van:</b> <i>{{ $event->from }}</i> uur - <b>Tot:</b> <i>{{ $event->till }}</i> uur
          </p>
          <hr style="border:.5px solid gray">
        @endforeach
        {{ $events->links() }}
      </div>
      <div class="col-md-3">
          <img src="/img/calendar_icon.png" alt="" style="opacity:0.1;">
      </div>
    </div>
  </div>
@endsection
