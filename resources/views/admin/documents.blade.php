@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading" style="background-color:rgba(22, 63, 146, .1)">
            <h4><i>Gedeelde Documenten</i> </h4>
          </div>
          <div class="panel-body">
            @if (null !== $documents->first())
              @foreach ($documents as $document)
                <div class="row" style="padding-bottom:20px;">
                  <div class="col-md-2">
                    <img src="/img/file_icon.png" alt="" width="100px;">
                  </div>
                  <div class="col-md-10">
                    <p style="margin-left:15px;">
                      <br>
                      <b>Naam:</b> <i>{{ $document->name }}</i>
                      <br>
                      <b>Gepubliceerd op:</b> <i>{{ $document->created_at->format('d/m/Y H:i') }}</i>
                      <br>
                      <a href="#"  data-toggle="modal" data-target="#{{ $document->id }}" class="btn btn-sm btn-primary" style="background-color:rgba(22, 63, 146, 1);">Wijzig</a>
                      <a href="/admin/documents/download/{{ $document->id }}" class="btn btn-sm btn-default">Download</a>
                    </p>
                  </div>
                </div>

                {{--  modal for changing --}}
                <div class="modal fade" id="{{ $document->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><b>Wijzig:</b> {{ $document->name }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form action="/admin/documents" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $document->id }}">
                        <div class="modal-body">
                          <label class="form-label">Naam</label>
                          <input type="text" name="name" class="form-control" value="{{ $document->name }}" required>
                          <br>
                          <label class="form-label">Link naar bestand</label>
                          <input type="text" name="name" class="form-control" value="{{ $document->link }}" disabled>
                          <br>
                          <label class="form-label">Publiek Beschikbaar</label>
                          <select class="form-control" name="public">
                            <option value="true" {{ ($document->public) ? 'selected' : null }} >Voor iedereen beschikbaar</option>
                            <option value="false" {{ (!$document->public) ? 'selected' : null }} >Alleen voor leden beschikbaar</option>
                          </select>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluiten</button>
                          <a href="/admin/documents/delete/{{ $document->id}}" class="btn btn-danger">Verwijderen!</a>
                          <button type="submit" class="btn btn-primary" style="background-color:rgba(22, 63, 146, 1);">Sla op!</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              @endforeach
              {{ $documents->links() }}
            @else
              <h4>Er zijn nog geen bestanden gedeeld!</h4>
            @endif
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading" style="background-color:rgba(22, 63, 146, .1)">
            <h4><i>Deel een nieuw document</i> </h4>
          </div>
          <div class="panel-body">
            <form action="/admin/documents/new" method="post" enctype="multipart/form-data">
              {{ csrf_field() }}
              <label class="form-label">Link naar bestand</label>
              <input type="file" name="file" class="form-control" required>
              <br>
              <label class="form-label">Publiek Beschikbaar</label>
              <select class="form-control" name="public" required>
                <option value="true">Voor iedereen beschikbaar</option>
                <option value="false">Alleen voor leden beschikbaar</option>
              </select>
              <br>
              <button type="submit" class="btn btn-primary" style="background-color:rgba(22, 63, 146, 1);">Opslaan!</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
