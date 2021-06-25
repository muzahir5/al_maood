@extends('user.layouts.default')

@section('content')

    <h2>Log In</h2> 
    
    @if($errors->any())
        <h4 class="text-danger">{{$errors->first('message')}}</h4>
    @endif
    <form method="POST" action="{{ url('/user/login')}} ">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" class="form-control" id="email" name="email" value="{{ old('email')}}">
             {!! $errors->first('email', '<p class="text-danger">:message</p>') !!}
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" value="{{ old('password')}}">
             {!! $errors->first('password', '<p class="text-danger">:message</p>') !!}
        </div>

        <div class="form-group">
            <button style="cursor:pointer" type="submit" class="btn btn-primary">Login</button>
        </div>
    </form>

@endsection