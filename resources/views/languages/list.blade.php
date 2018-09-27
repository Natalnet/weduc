@extends('layouts.app')

@section('content')
<div class="container-fluid animated fadeIn">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4>Linguagens do Usuário</h4>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Nome da Linguagem</th>
                                    <th scope="col">Opções</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($languages as $language)
                                <tr>
                                    <td>{{ $language->name }}</td>
                                    <td>
                                        @if($language->user_id == auth()->id())
                                        <a href="{{  route('languages.edit', ['language' => $language->id]) }}" class="btn btn-outline-primary btn-sm">
                                            Editar linguagem
                                        </a>
                                        <a href="{{  route('functions.by-language', ['language' => $language->id]) }}" class="btn btn-outline-primary btn-sm">
                                            Ver funções
                                        </a>
                                        <a href="/weduc/linguagem/clonar/{{ $language->id }}" class="btn btn-outline-primary btn-sm">
                                            Clonar linguagem
                                        </a>
                                        <a href="/weduc/linguagem/excluir/{{ $language->id }}" class="btn btn-outline-primary btn-sm">
                                            Excluir linguagem
                                        </a>
                                        @endif
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
