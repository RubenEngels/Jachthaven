@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="panel panel-default">
        <div class="panel-heading" style="text-align:center;">
          <h3>Je eigen profiel</h3>
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-md-12" style="text-align:center;">
              <p>
                <img src="/uploads/avatars/{{ Auth::user()->image }}" alt="default" style="border-radius:50%;margin-right:20px;border:1px solid black;" width="200;" height="200px;">
                <a data-toggle="modal" data-target="#editPhoto"><span style="font-size:20px;"><i class="fa fa-camera" aria-hidden="true"></i> Wijzig uw foto</span></a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  {{-- MODAL --}}
  <div class="modal fade" id="editPhoto" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <form action="/user/profile/photo" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Wijzig uw foto</h4>
          </div>
          <div class="modal-body">
            <label class="form-label">Upload een foto</label>
            <input type="file" name="photo" class="form-control">
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Opslaan</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Sluiten</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@stop
