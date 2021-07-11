@extends('layouts.app')

@section('breadcrumb-data')
    <ol class="breadcrumb" style="background-color: white">
        <li class="breadcrumb-item">
            <a href="{{ url('/home') }}">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>Edit</a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="container">
        @if(Session::has('message'))
            <p class="alert alert-info">{{ Session::get('message') }}</p>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center">
                        <h4 class="card-title" id="basic-layout-card-center">Edit SuperHero</h4>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            <form class="form" method="post" autocomplete="off"
                                  action="{{ @url('/update/'.$superHeroesData['id']) }}"
                                  enctype="multipart/form-data"
                                  id="user_form">
                                @csrf
                                @method('PUT')
                                <input type="hidden" id="portal_user_id" value="0" name="portal_user_id">
                                <div class="form-body">
                                    <div class="form-group">
                                        <div class="form-group row last">
                                            <label class="col-md-1 label-control"
                                                   for="Avatar">Photo
                                            </label>
                                            <img src="{{ URL::to('/') }}/{{$superHeroesData['path_to_image']}}"
                                                 id="myImg"
                                                 style="width: 200px; height: 200px">
                                            <input type="file" name="avatar" accept="image/png, image/jpeg"
                                                   class="form-control-file"
                                                   style="padding-top: 1%; padding-left: 1.5%;">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nickname">Nick Name</label>
                                    <input type="text" id="nickname" class="form-control" placeholder="Nick Name"
                                           name="nickname" required
                                           value="{{ old('nickname',$superHeroesData['nickname']) }}">
                                </div>
                                <div class="form-body">
                                    <div class="form-group">
                                        <label for="real_name">Real Name</label>
                                        <input type="text" id="real_name" class="form-control" placeholder="Real Name"
                                               name="real_name" required
                                               value="{{ old('real_name',$superHeroesData['real_name']) }}">
                                    </div>
                                </div>
                                <div class="form-body">
                                    <div class="form-group">
                                        <label for="origin_description">Origin Description</label>
                                        <input type="text" id="origin_description" class="form-control"
                                               placeholder="Origin Description"
                                               name="origin_description"
                                               required
                                               value="{{ old('origin_description',$superHeroesData['origin_description']) }}">
                                    </div>
                                </div>
                                <div class="form-body">
                                    <div class="form-group">
                                        <label for="superpowers">Superpowers</label>
                                        <input type="text" id="superpowers" class="form-control"
                                               placeholder="Superpowers"
                                               name="superpowers"
                                               required
                                               value="{{ old('superpowers',$superHeroesData['superpowers']) }}">
                                    </div>
                                </div>
                                <div class="form-body">
                                    <div class="form-group">
                                        <label for="catch_phrase">Catch Phrase</label>
                                        <input type="text" id="catch_phrase" class="form-control"
                                               placeholder="Catch Phrase"
                                               name="catch_phrase"
                                               required
                                               value="{{ old('catch_phrase',$superHeroesData['catch_phrase']) }}">
                                    </div>
                                </div>
                                <div class="form-actions center">
                                    <button type="button" onclick="history.back();" class="btn btn-danger mr-1">
                                        <i class="ft-x"></i> Cancel
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-check-square-o"></i> Save
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            window.addEventListener('load', function () {
                document.querySelector('input[type="file"]').addEventListener('change', function () {
                    if (this.files && this.files[0]) {
                        let img = document.querySelector('img');
                        img.onload = () => {
                            URL.revokeObjectURL(img.src);  // no longer needed, free memory
                        }
                        img.src = URL.createObjectURL(this.files[0]); // set src to blob url
                    }
                });
            });
        });
    </script>
@endpush
