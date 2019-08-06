@extends('layouts.app')

@section('content')
<div class="container-fluid animated fadeIn">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-5">
                            <h4 class="card-title">Funções da Linguagem</h4>
                        </div>
                        <div class="col-sm-7">
                            <div class="float-right">
                                <a href="{{  route('functions.create', ['language' => $language->id]) }}" class="btn btn-outline-primary btn-sm">
                                    Criar
                                </a>
                            </div>
                        </div>
                        <hr>
                    </div>
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
                                    <a href="{{ route('functions.destroy', $function) }}" class="btn btn-outline-primary btn-sm"
                                       onclick="event.preventDefault();
                                       document.getElementById('destroy-form-{{ $function->id }}').submit();">
                                        Excluir função
                                    </a>

                                    <form id="destroy-form-{{ $function->id }}" action="{{ route('functions.destroy', $function) }}"
                                          method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
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
