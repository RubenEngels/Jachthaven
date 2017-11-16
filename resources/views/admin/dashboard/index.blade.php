@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
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
    </div>
</div>
@endsection
