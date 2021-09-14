@extends('user.layouts.default')

@section('content')

    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
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
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <h2> User Register</h2>
        <form method="POST" action="{{ url('/user/register') }}">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name')}}">
                 {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
            </div>

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
                <button style="cursor:pointer" type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>   
    </div>

    

@endsection