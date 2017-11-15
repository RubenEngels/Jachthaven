@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h3><i>De gedeelde documenten</i></h3>
        @if (null !== $documents->first())
          @foreach ($documents as $document)
            <div class="row" style="padding-bottom:20px;">
              <div class="col-md-2">
                <img src="/img/file_icon.png" style="margin-top:20px;" width="100px;">
              </div>
              <div class="col-md-10">
                <p style="margin-left:15px;">
                  <br>
                  <b>Naam:</b> <i>{{ $document->name }}</i>
                  <br>
                  <b>Gepubliceerd op:</b> <i>{{ $document->created_at->format('d/m/Y H:i') }}</i>
                  <br>
                  <a href="/documents/download/{{ $document->id }}" class="btn btn-primary" style="margin-top:10px; margin-bottom:10px;">Download bestand</a>
                </p>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <hr style="border: 1px solid gray; opacity:.3;">
              </div>
            </div>

          @endforeach
          {{ $documents->links() }}
        @else
          <h4>Er zijn nog geen bestanden gedeeld!</h4>
        @endif
      </div>
      <div class="col-md-6">
        <img src="/img/jachthaven.jpg" width="100%" alt="">
        <br>
        <h4>Vragen?</h4>
        <p>Als u vragen heeft over de gedeelde documenten of vragen over iets anders met betrekking tot de website kan u altijd even contact met ons opnemen via het <a href="/contant">contact</a> formulier of via de contact gegevens die ook op de bovengenoemde pagina staan.</p>
        <img src="/img/file_icon_2.png" alt="" style="opacity:.07;">
      </div>
    </div>
  </div>
@endsection
