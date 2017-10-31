@extends('layouts.app')

@push('scripts')
<script src='https://cloud.tinymce.com/stable/tinymce.min.js'></script>
<script>
    tinymce.init({
        selector: '#description'
    });
</script>
@endpush

@section('content')
<div class="container-fluid animated fadeIn">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4>Edição do Cadastro de Funções</h4>
                    <hr>
                    <p class="text-muted">Preencha os campos abaixo</p>
                    <form method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Nome</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Digite um nome para a função" value="{{ old('name') ?: $function->name }}">
                                </div>

                                <div class="form-group">
                                    <label for="description">Descrição</label>
                                    <textarea type="text" class="form-control" name="description" id="description" placeholder="Descrição">
                                        {{ old('description') ?: $function->description }}
                                    </textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type">Tipo</label>
                                    <select id="type" name="type" class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}">
                                        <option>Selecione uma opção</option>
                                        <option value="1">Escrita</option>
                                        <option value="2">Leitura</option>
                                        <option value="3">Movimentação</option>
                                        <option value="4">Outros</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="return_type">Retorno</label>
                                    <select id="return_type" name="return_type" class="form-control{{ $errors->has('return_type') ? ' is-invalid' : '' }}">
                                        <option>Selecione uma opção</option>
                                        <option value="1">boolean</option>
                                        <option value="2">float</option>
                                        <option value="3">String</option>
                                        <option value="4">Void</option>
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label for="parameters">Quantidade de parâmetros</label>
                                    <select id="parameters" name="parameters" class="form-control{{ $errors->has('parameters') ? ' is-invalid' : '' }}">
                                        <option>Selecione uma opção</option>
                                        <option value="1">0</option>
                                        <option value="2">1</option>
                                        <option value="3">2</option>
                                        <option value="4">3</option>
                                        <option value="3">4</option>
                                        <option value="4">5</option>
                                    </select>
                                </div>

                                @if ($errors->has('email'))
                                    <div class="invalid-feedback" style="display: block;">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="code">Código</label>
                            <textarea type="text" class="form-control" name="code" id="code" placeholder="Descrição" rows="6">
                                {{ old('code') ?: $function->code }}
                            </textarea>

                            @if ($errors->has('code'))
                                <div class="invalid-feedback" style="display: block;">
                                    <strong>{{ $errors->first('code') }}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary px-4">Salvar</button>
                            </div>
                            <div class="col-6 text-right">
                                <button type="button" class="btn btn-link px-0">Precisa de ajuda?</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
