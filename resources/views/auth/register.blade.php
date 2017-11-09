@extends('layouts.singleform')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card p-4">
            <div class="card-body">
                <h1>Cadastro</h1>
                <hr>
                <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}

                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="icon-user"></i></span>
                            <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" placeholder="Username">
                        </div>
                        @if ($errors->has('name'))
                            <div class="invalid-feedback" style="display: block;">
                                <strong>{{ $errors->first('name') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                            <input type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="E-mail">
                        </div>
                        @if ($errors->has('email'))
                            <div class="invalid-feedback" style="display: block;">
                                <strong>{{ $errors->first('email') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                            <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="{{ old('password') }}" placeholder="@lang('register.form.password')">
                        </div>
                        @if ($errors->has('password'))
                            <div class="invalid-feedback" style="display: block;">
                                <strong>{{ $errors->first('password') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <div class="input-group mb-3">
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                            <input type="password" class="form-control" name="password_confirmation" placeholder="@lang('register.form.password_confirmation')">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-block btn-primary">
                        Cadastrar
                    </button>
                    <a href="{{ route('login') }}" class="btn btn-block btn-success">
                        Fazer login
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
