@extends('adminlte::page')

@section('title', env('APP_NAME'))

@section('content_header')
    <h1 class="d-inline">Profil utilizator</h1>
@stop

@section('content')

@if($errors->any())
  <div class="alert alert-danger alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>	
      <strong>{{ $errors->first() }}</strong>
  </div>
@endif

<div class="box col-lg-12">
    <div class="col-lg-3">
        &nbsp;
    </div>
    <div class="box-body col-lg-2">
        <a href="#" data-toggle="modal" data-target="#changeUserImage">
            @if ($user->profile_picture === null)
                <img style="width: 200px; height: 200px" class="img-fluid img-thumbnail img-circle" src="/storage/profile_pictures/user_dummy.png" alt="profile picture">
            @else
                <img style="width: 300px; height: 300px" class="img-fluid img-thumbnail img-circle" src="/storage/profile_pictures/{{ $user->profile_picture }}" alt="profile picture" data-holder-rendered="true">
            @endif
            
        </a>
    </div>
    <div class="box-body col-lg-4">
        <h1>{{ $user->name }} &nbsp; <a href="#" data-toggle="modal" data-target="#changeUserDetails"><small><i class="fa fa-edit"></i></small></a></h1>
        <div class="box-body col-lg-12">
            <p>Membru din {{ date("d M Y", strtotime($user->created_at)) }}</p>    
            <p>{{ $user->email }}</p>
        </div>
        <div class="box-body col-lg-12">    
            <a href="#" class="btn" data-toggle="modal" data-target="#changeUserPassword">Schimba parola</a>
        </div>
    </div>
    <div class="col-lg-3">
        &nbsp;
    </div>
</div>

@include('profile.details')
@include('profile.password')
@include('profile.image')

@stop


@section('footer')
    @include('footer')
@endsection

@section('js')
  <script>
    $(document).on('click', '#changePassword', function () {
        var error = false
        var pass1 = $('#password1').val();
        var pass2 = $('#password2').val();
        if(pass1 != pass2) {
            $('#password1').after('<span class="error">Parolele nu sunt identice!</span>');
            error = true;
        }
        if(error == true) {return false;}
    });
  </script>
@endsection
