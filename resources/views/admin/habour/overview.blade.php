@extends('layouts.app')

@section('content')

<div class="container">
  <div class="row">
    @include('admin.habour.elements._boxes')
    @include('admin.habour.elements._walplaatsen')
  </div>
</div>

@endsection
