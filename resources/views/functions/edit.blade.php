@extends('layouts.app')

@push('scripts')
<script src='https://cloud.tinymce.com/stable/tinymce.min.js'></script>
<script>
    tinymce.init({
        // selector: '#description'
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
                    <form method="POST" action="{{ route('functions.update', ['function' => $function->id]) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Nome</label>
                                    <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="name" placeholder="Digite um nome para a função" value="{{ old('name', $function->name) }}">

                                    @if ($errors->has('name'))
                                        <div class="invalid-feedback" style="display: block;">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="description">Descrição</label>
                                    <textarea
                                        type="text"
                                        class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                        name="description"
                                        id="description"
                                        placeholder="Descrição"
                                    >{{ old('description', $function->description) }}</textarea>

                                    @if ($errors->has('description'))
                                        <div class="invalid-feedback" style="display: block;">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="target_description">Descrição para Linguagem Alvo</label>
                                    <textarea
                                        type="text"
                                        class="form-control{{ $errors->has('target_description') ? ' is-invalid' : '' }}"
                                        name="target_description"
                                        id="target_description"
                                        placeholder="Descrição"
                                    >{{ old('target_description', $function->target_description) }}</textarea>

                                    @if ($errors->has('target_description'))
                                        <div class="invalid-feedback" style="display: block;">
                                            <strong>{{ $errors->first('target_description') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type">Tipo</label>
                                    <select id="type" name="type" class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}">
                                        <option value="">Selecione uma opção</option>
                                        <option value="Escrita" {{ $function->type == 'Escrita' ? 'selected' : '' }}>Escrita</option>
                                        <option value="Leitura" {{ $function->type == 'Leitura' ? 'selected' : '' }}>Leitura</option>
                                        <option value="Movimentação" {{ $function->type == 'Movimentação' ? 'selected' : '' }}>Movimentação</option>
                                        <option value="Outros" {{ $function->type == 'Outros' ? 'selected' : '' }}>Outros</option>
                                    </select>

                                    @if ($errors->has('type'))
                                        <div class="invalid-feedback" style="display: block;">
                                            <strong>{{ $errors->first('type') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="return_type">Retorno</label>
                                    <select id="return_type" name="return_type" class="form-control{{ $errors->has('return_type') ? ' is-invalid' : '' }}">
                                        <option>Selecione uma opção</option>
                                        <option value="boolean" {{ $function->return_type == 'boolean' ? 'selected' : '' }}>boolean</option>
                                        <option value="float" {{ $function->return_type == 'float' ? 'selected' : '' }}>float</option>
                                        <option value="String" {{ $function->return_type == 'String' ? 'selected' : '' }}>String</option>
                                        <option value="Void" {{ $function->return_type == 'Void' ? 'selected' : '' }}>Void</option>
                                    </select>

                                    @if ($errors->has('return_type'))
                                        <div class="invalid-feedback" style="display: block;">
                                            <strong>{{ $errors->first('return_type') }}</strong>
                                        </div>
                                    @endif
                                </div>


                                <div class="form-group">
                                    <label for="parameters">Quantidade de parâmetros</label>
                                    <select id="parameters" name="parameters" class="form-control{{ $errors->has('parameters') ? ' is-invalid' : '' }}">
                                        <option>Selecione uma opção</option>
                                        <option value="0" {{ $function->parameters == '0' ? 'selected' : '' }}>0</option>
                                        <option value="1" {{ $function->parameters == '1' ? 'selected' : '' }}>1</option>
                                        <option value="2" {{ $function->parameters == '2' ? 'selected' : '' }}>2</option>
                                        <option value="3" {{ $function->parameters == '3' ? 'selected' : '' }}>3</option>
                                        <option value="4" {{ $function->parameters == '4' ? 'selected' : '' }}>4</option>
                                        <option value="5" {{ $function->parameters == '5' ? 'selected' : '' }}>5</option>
                                    </select>

                                    @if ($errors->has('parameters'))
                                        <div class="invalid-feedback" style="display: block;">
                                            <strong>{{ $errors->first('parameters') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="code">Código</label>
                            <code-field name="code" value="{{ old('code') ?: $function->code }}"></code-field>

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
