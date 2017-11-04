@extends('layouts.app')

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.8/ace.js"></script>
@endpush

@section('content')
<notifications group="ide" position="bottom right" ></notifications>
<ide inline-template :languages='{{ $test }}'>
<div class="container-fluid animated fadeIn" v-cloak v-if="language">
    <div class="row">
        <div class="col-lg-12">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" id="blockeduc-tab" class="nav-item">
                    <a href="#blockeduc" aria-controls="blockeduc" role="tab" data-toggle="tab" class="nav-link disabled">
                        <b>BlockEduc</b>
                    </a>
                </li>
                <li role="presentation" id="reduc-tab" class="nav-item">
                    <a href="#reduc" aria-controls="reduc" role="tab" data-toggle="tab" class="nav-link active">
                        <b>R-Educ</b>
                    </a>
                </li>
                <li role="presentation" id="custom-tab" class="nav-item">
                    <a href="#custom" aria-controls="custom" role="tab" data-toggle="tab" class="nav-link">
                        <b>@{{ language.name }}</b>
                    </a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane fade show active" role="tabpanel" id="reduc" aria-labelledby="reduc-tab">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="input-group has-warning">
                                <input class="form-control" type="text" id="robot-name" disabled="" :value="language.robot">
                                <span class="input-group-btn">
                                    <button class="btn btn-outline-warning" @click="onCompile">
                                        <i class="fa fa-code" aria-hidden="true"></i> Compilar
                                    </button>
                                    @auth
                                        <button type="button" id="enviarBtn" class="btn btn-outline-success" disabled="" onclick="enviarCliente();">
                                            <i class="fa fa-paper-plane-o" aria-hidden="true"></i> Enviar
                                        </button>
                                    @endauth
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            @auth
                                <div class="input-group">
                                    <input class="form-control" type="text" id="nome-do-programa" v-model="program.name" :disabled="disableNameInput == true">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-outline-primary" @click="save" title="Salvar">
                                            <i class="fa fa-floppy-o" aria-hidden="true"></i>
                                        </button>
                                        <button class="btn btn-outline-primary" title="Solicitar Correção" disabled="disabled">
                                            <i class="fa fa-check" aria-hidden="true"></i>
                                        </button>
                                        <button class="btn btn-outline-primary" title="Download" disabled="disabled">
                                            <i class="fa fa-download" aria-hidden="true"></i>
                                        </button>
                                        <button class="btn btn-outline-primary" id="btn-new" @click="newProgram" title="Novo">
                                            <i class="fa fa-file-o" aria-hidden="true"></i>
                                        </button>
                                        <button
                                            class="btn btn-outline-primary dropdown-toggle"
                                            type="button"
                                            id="dropdownMenu1"
                                            data-toggle="dropdown"
                                            aria-haspopup="true"
                                            aria-expanded="true"
                                            title="Abrir"
                                        >
                                            <i class="fa fa-folder-open-o" aria-hidden="true"></i>
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
                                            <li v-for="item of language.programs" class="dropdown-item">
                                                <a href="#" @click="loadProgram(item)">@{{ item.name }}</a>
                                            </li>
                                        </ul>
                                    </span>
                                </div>
                            @endauth
                            @guest
                                <a href="{{ route('login') }}" class="btn btn-outline-primary float-right" title="Faça login para acessar todas as funcionalidades">
                                    <i class="fa fa-unlock" aria-hidden="true"></i> Login
                                </a>
                            @endguest
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="card-header">
                                    <b>Funções R-Educ</b>
                                </div>

                                <!-- List group -->
                                <ul class="list-group list-group-flush" style="max-height: 380px; overflow-y: scroll;">
                                    <li v-for="item of language.functions" class="list-group-item">
                                        <a href="#" data-toggle="modal" :data-target="'#func-' + item.id">
                                            @{{ item.name }}
                                        </a>
                                        <!-- Modal -->
                                        <div class="modal fade" :id="'func-' + item.id" tabindex="-1" role="dialog" :aria-labelledby="'func-' + item.id">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">@{{ item.name }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>@{{ item.description }}</p>
                                                        <p><b>Parâmetros:</b> @{{ item.parameters }}</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="card" :class="{ 'border-danger': errors }">
                                <editor editor-id="editor1" :content="program.code" v-on:new-content="updateCode"></editor>
                                <div class="card-footer">
                                    <div id="comp-result">
                                        <div class="text-info" v-if="errors">
                                            <b v-text="errors"></b>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade show" role="tabpanel" id="custom" aria-labelledby="custom-tab">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="input-group has-warning">
                                <input class="form-control" type="text" id="robot-name" disabled="" :value="language.robot">
                                <span class="input-group-btn">
                                    <button class="btn btn-outline-warning" @click="onCompile">
                                        <i class="fa fa-code" aria-hidden="true"></i> Compilar
                                    </button>
                                    @auth
                                        <a :href="downloadUrl" class="btn btn-outline-success" target="_blank">
                                            <i class="fa fa-paper-plane-o" aria-hidden="true"></i> Enviar
                                        </a>
                                    @endauth
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            @auth
                                <div class="input-group">
                                    <input class="form-control" type="text" id="nome-do-programa" v-model="program.name" :disabled="disableNameInput == true">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-outline-primary" @click="save" title="Salvar">
                                            <i class="fa fa-floppy-o" aria-hidden="true"></i>
                                        </button>
                                        <button class="btn btn-outline-primary" title="Solicitar Correção" disabled="disabled">
                                            <i class="fa fa-check" aria-hidden="true"></i>
                                        </button>
                                        <button class="btn btn-outline-primary" title="Download" disabled="disabled">
                                            <i class="fa fa-download" aria-hidden="true"></i>
                                        </button>
                                        <button class="btn btn-outline-primary" id="btn-new" @click="newProgram" title="Novo">
                                            <i class="fa fa-file-o" aria-hidden="true"></i>
                                        </button>
                                        <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" title="Abrir">
                                            <i class="fa fa-folder-open-o" aria-hidden="true"></i>
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
                                            <li v-for="item of language.programs" class="dropdown-item">
                                                <a href="#" @click="loadProgram(item)">@{{ item.name }}</a>
                                            </li>
                                        </ul>
                                    </span>
                                </div>
                            @endauth
                            @guest
                                <a href="{{ route('login') }}" class="btn btn-outline-primary float-right" title="Faça login para acessar todas as funcionalidades">
                                    <i class="fa fa-unlock" aria-hidden="true"></i> Login
                                </a>
                            @endguest
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="card-header">
                                    <b>Funções R-Educ</b>
                                </div>

                                <!-- List group -->
                                <ul class="list-group list-group-flush" style="max-height: 380px; overflow-y: scroll;">
                                    <li v-for="item of language.functions" class="list-group-item">
                                        <a href="#" data-toggle="modal" :data-target="'#func-' + item.id">
                                            @{{ item.name }}
                                        </a>
                                        <!-- Modal -->
                                        <div class="modal fade" :id="'func-' + item.id" tabindex="-1" role="dialog" :aria-labelledby="'func-' + item.id">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">@{{ item.name }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>@{{ item.description }}</p>
                                                        <p><b>Parâmetros:</b> @{{ item.parameters }}</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="card" :class="{ 'border-danger': errors }">
                                <editor editor-id="editor2" :content="program.customCode" v-on:new-content="updateCustomCode"></editor>
                                <div class="card-footer">
                                    <div id="comp-result">
                                        <div class="text-info" v-if="errors">
                                            <b v-text="errors"></b>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="blockeduc" aria-lavelledby="blockeduc-tab">
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="blocklyDiv" style="height: 480px; width: 100%;"></div>
                            <br>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</ide>
@endsection
