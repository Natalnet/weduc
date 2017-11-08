@extends('layouts.app')

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.8/ace.js"></script>

    <script src="{{ asset('blockly/blockly_compressed.js') }}"></script>
    <script src="{{ asset('blockly/generators/reduc.js') }}"></script>
    <script src="{{ asset('blockly/generators/reduc/lists.js') }}"></script>
    <script src="{{ asset('blockly/generators/reduc/logic.js') }}"></script>
    <script src="{{ asset('blockly/generators/reduc/loops.js') }}"></script>
    <script src="{{ asset('blockly/generators/reduc/math.js') }}"></script>
    <script src="{{ asset('blockly/generators/reduc/procedures.js') }}"></script>
    <script src="{{ asset('blockly/generators/reduc/text.js') }}"></script>
    <script src="{{ asset('blockly/generators/reduc/variables.js') }}"></script>

    <script>
        @foreach ($languages as $language)
            @foreach ($language->functions as $function)
{{--                {{ $function->name }}--}}
{{--                {{ /*getBlockCode().encodeAsRaw()*/  }}--}}
            @endforeach
        @endforeach
    </script>

    <script src='{{ asset("blockly/blocks/lists.js") }}'></script>
    <script src='{{ asset("blockly/blocks/logic.js") }}'></script>
    <script src='{{ asset("blockly/blocks/loops.js") }}'></script>
    <script src='{{ asset("blockly/blocks/math.js") }}'></script>
    <script src='{{ asset("blockly/blocks/procedures.js") }}'></script>
    <script src='{{ asset("blockly/blocks/text.js") }}'></script>
    <script src='{{ asset("blockly/blocks/variables.js") }}'></script>

    <script>
        @foreach ($languages as $language)
            @foreach ($language->functions as $function)
{{--                {{ $function->name }}--}}
{{--                {{ /*getBlokcDefinition().encodeAsRaw()*/  }}--}}
            @endforeach
        @endforeach
    </script>


    <script src='{{ asset("blockly/msg/js/pt-br.js")}}'></script>
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
                    <a href="#blockeduc" aria-controls="blockeduc" role="tab" data-toggle="tab" class="nav-link" @click="setupBlockly">
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
                                    <button class="btn btn-outline-warning" @click="compile">
                                        <i class="fa fa-code" aria-hidden="true"></i> Compilar
                                    </button>
                                    @auth
                                        <a :href="downloadUrl" class="btn btn-outline-success" target="_blank" v-if="disableNameInput == true">
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
                                    <button class="btn btn-outline-warning" @click="compileTarget">
                                        <i class="fa fa-code" aria-hidden="true"></i> Compilar
                                    </button>
                                    @auth
                                        <a :href="downloadUrl" class="btn btn-outline-success" target="_blank" v-if="disableNameInput == true">
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
                <div class="tab-pane fade show" role="tabpanel" id="blockeduc" aria-lavelledby="blockeduc-tab">
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="blocklyDiv" style="height: 480px; width: 100%;"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</ide>
@endsection

@push('bottom-scripts')
    <xml id="toolbox" style="display: none">
        <category name="Lógica" colour="210">
            <block type="controls_if"></block>
            <block type="logic_compare"></block>
            <block type="logic_operation"></block>
            <block type="logic_negate"></block>
            <block type="logic_boolean"></block>
        </category>
        <category name="Repetição" colour="120">
            <block type="controls_repeat_ext">
                <value name="TIMES">
                    <shadow type="math_number">
                        <field name="NUM">10</field>
                    </shadow>
                </value>
            </block>
            <block type="controls_whileUntil"></block>
            <block type="controls_for">
                <value name="FROM">
                    <shadow type="math_number">
                        <field name="NUM">1</field>
                    </shadow>
                </value>
                <value name="TO">
                    <shadow type="math_number">
                        <field name="NUM">10</field>
                    </shadow>
                </value>
                <value name="BY">
                    <shadow type="math_number">
                        <field name="NUM">1</field>
                    </shadow>
                </value>
            </block>
        </category>
        <category name="Matemática" colour="230">
            <block type="math_number"></block>
            <block type="math_arithmetic">
                <value name="A">
                    <shadow type="math_number">
                        <field name="NUM">1</field>
                    </shadow>
                </value>
                <value name="B">
                    <shadow type="math_number">
                        <field name="NUM">1</field>
                    </shadow>
                </value>
            </block>
            <block type="math_constant"></block>
        </category>
        <category name="Texto" colour="160">
            <block type="text"></block>
            <block type="text_join"></block>
            <block type="text_append">
                <value name="TEXT">
                    <shadow type="text"></shadow>
                </value>
            </block>
            <block type="text_length">
                <value name="VALUE">
                    <shadow type="text">
                        <field name="TEXT">abc</field>
                    </shadow>
                </value>
            </block>
            <block type="text_isEmpty">
                <value name="VALUE">
                    <shadow type="text">
                        <field name="TEXT"></field>
                    </shadow>
                </value>
            </block>
            <block type="text_print">
                <value name="TEXT">
                    <shadow type="text">
                        <field name="TEXT">abc</field>
                    </shadow>
                </value>
            </block>
        </category>
        <sep></sep>
        <category name="Variáveis" colour="330" custom="VARIABLE"></category>
        <category name="Tarefas" colour="290" custom="PROCEDURE"></category>
        <category name="Funções R-Educ" colour="185">
        @foreach ($languages as $language)
            @foreach ($language->functions as $function)
                <!--<block type="function{{ $function->id }}"></block>-->
                @endforeach
            @endforeach
        </category>
    </xml>
@endpush