@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('admin.dashboard.elements._notifications')
        @include('admin.dashboard.elements._newsletters')
    </div>
    <div class="row">
      @include('admin.dashboard.elements._invoices')
      @include('admin.dashboard.elements._crane_overview')
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
            <button type="submit" class="btn btn-primary" style="background-color:#163f92">Opslaan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endforeach

@endsection
