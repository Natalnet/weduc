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
                    <input type="hidden" name="redirect" value="{{ request('redirect') }}">

                    <div class="mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-user"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" placeholder="Nome">
                        </div>
                        @if ($errors->has('name'))
                            <div class="invalid-feedback" style="display: block;">
                                <strong>{{ $errors->first('name') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <div>Sexo</div>
                        <div class="input-group">
                            <div class="control">
                                <label class="radio">
                                    <input type="radio" class="custom-radio{{ $errors->has('gender') ? ' is-invalid' : '' }}" name="gender" value="m" {{ old('gender') === 'm' ? 'checked' : '' }}>
                                    Masculino
                                </label>
                                <label class="radio">
                                    <input type="radio" class="custom-radio{{ $errors->has('gender') ? ' is-invalid' : '' }}" name="gender" value="f" {{ old('gender') === 'f' ? 'checked' : '' }}>
                                    Feminino
                                </label>
                                <label class="radio">
                                    <input type="radio" class="custom-radio{{ $errors->has('gender') ? ' is-invalid' : '' }}" name="gender" value="o" {{ old('gender') === 'o' ? 'checked' : '' }}>
                                    Outros
                                </label>
                            </div>
                        </div>
                        @if ($errors->has('gender'))
                            <div class="invalid-feedback" style="display: block;">
                                <strong>{{ $errors->first('gender') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-baby"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control{{ $errors->has('dob') ? ' is-invalid' : '' }}" name="dob" value="{{ old('dob') }}" placeholder="Data de nascimento">
                        </div>
                        @if ($errors->has('dob'))
                            <div class="invalid-feedback" style="display: block;">
                                <strong>{{ $errors->first('dob') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="mb-1">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-university"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control{{ $errors->has('institution') ? ' is-invalid' : '' }}" name="institution" value="{{ old('institution') }}" placeholder="Instituição">
                        </div>
                        @if ($errors->has('institution'))
                            <div class="invalid-feedback" style="display: block;">
                                <strong>{{ $errors->first('institution') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <div class="input-group form-check">
                            <input type="checkbox" class="form-check-input{{ $errors->has('is_public_institution') ? ' is-invalid' : '' }}" name="is_public_institution" value="1" {{ old('is_public_institution') ? 'checked' : '' }} placeholder="É instituição pública">
                            <label for="is_public_institution" class="form-check-label">É instituição pública</label>
                        </div>

                        @if ($errors->has('is_public_institution'))
                            <div class="invalid-feedback" style="display: block;">
                                <strong>{{ $errors->first('is_public_institution') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="mb-1">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-map-marked"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" value="{{ old('address') }}" placeholder="Endereço">
                        </div>
                        @if ($errors->has('address'))
                            <div class="invalid-feedback" style="display: block;">
                                <strong>{{ $errors->first('address') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}" name="city" value="{{ old('city') }}" placeholder="Cidade">
                            <input type="text" class="form-control{{ $errors->has('state') ? ' is-invalid' : '' }}" name="state" value="{{ old('state') }}" placeholder="Estado">
                        </div>
                        @if ($errors->has('city'))
                            <div class="invalid-feedback" style="display: block;">
                                <strong>{{ $errors->first('city') }}</strong>
                            </div>
                        @endif
                        @if ($errors->has('state'))
                            <div class="invalid-feedback" style="display: block;">
                                <strong>{{ $errors->first('state') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-envelope"></i>
                                </span>
                            </div>
                            <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="E-mail">
                        </div>
                        @if ($errors->has('email'))
                            <div class="invalid-feedback" style="display: block;">
                                <strong>{{ $errors->first('email') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-lock"></i>
                                </span>
                            </div>
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
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-lock"></i>
                                </span>
                            </div>
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
