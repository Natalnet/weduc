@extends('layouts.app')

@section('content')
<div class="container-fluid animated fadeIn">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4>Funções da Linguagem</h4>
                    <hr>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Nome da Função</th>
                                <th scope="col">Opções</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($functions as $function)
                            <tr>
                                <td><a href="{{  route('functions.show', ['function' => $function->id]) }}">{{ $function->name }}</a></td>
                                <td>
                                    <a href="{{  route('functions.edit', ['function' => $function->id]) }}" class="btn btn-outline-primary btn-sm">
                                        Editar função
                                    </a>
                                    <a href="/weduc/linguagem/excluir/{{ $function->id }}" class="btn btn-outline-primary btn-sm">
                                        Excluir função
                                    </a>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
