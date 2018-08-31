@extends('layouts.singleform')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card p-4">
            <div class="card-body">
                <h1>Redefinir Senha</h1>
                <hr>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}

                        <div class="mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-envelope-o"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="E-mail">
                            </div>
                            @if ($errors->has('email'))
                                <div class="invalid-feedback" style="display: block;">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </div>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-block btn-primary">
                            Enviar Link para Redefinição de Senha
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
