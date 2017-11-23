@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('admin.dashboard.elements._notifications')
        @include('admin.dashboard.elements._newsletters')
    </div>
    <div class="row">
      @include('admin.dashboard.elements._invoices')
    </div>
</div>
@foreach($newsletters as $newsletter)
  <!-- Modal -->
  <div class="modal fade" id="{{ 'newsletter_' . $newsletter->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
