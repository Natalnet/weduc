@extends('layouts.app')

@section('content')
<div class="container-fluid animated fadeIn">
    @role('admin')
    <div class="row">
        <div class="col-md-4">
            <compilations-per-day></compilations-per-day>
        </div>
        <div class="col-md-8">
            <compilation-errors></compilation-errors>
        </div>
    </div>
    @endrole
    <div class="row">
        <div class="col-md-12">
            <div class="card card-accent-primary">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h4>
                        @auth
                            Olá {{auth()->user()->name}}!
                        @endauth
                        Seja bem vindo ao Weduc!
                    </h4>
                    <hr>
                    <p>Este é um ambiente completo para robótica educacional. Aqui você pode programar diversos robôs, discutir sobre robótica no nosso fórum, ser acompanhado por professores de robótica de todo o mundo e muito mais!</p>
                    <a href="{{ route('program') }}" class="btn btn-primary">Comece a programar aqui!</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
