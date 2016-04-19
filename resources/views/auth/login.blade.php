@extends('layouts.app')

@section('content')
<div class="container">
    <form class="login-form" method="POST" action="{{ route('internal.post.login') }}">
     {!! csrf_field() !!}
        <div class="login-wrap">
            <p class="login-img"><i class="icon_lock_alt"></i> <span>Inter. User</span></p>
            <div class="input-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <span class="input-group-addon"><i class="icon_profile"></i></span>
                <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email Address" />
            </div>
            <div class="gap-error">
                @if ($errors->has('email'))
                    <span class="error">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <div class="input-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <span class="input-group-addon"><i class="icon_key_alt"></i></span>
                <input type="password" class="form-control" name="password" placeholder="Password" />
            </div>
            <div class="gap-error">
                @if ($errors->has('password'))
                    <span class="error">{{ $errors->first('password') }}</span>
                @endif
            </div>
 
            <button type="submit" class="btn btn-primary btn-lg btn-block">Login</button>
        </div>
    </form>
</div>
@endsection
