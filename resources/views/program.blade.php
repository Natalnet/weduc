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
    <div class="row mb-3">
        <div class="col-lg-9">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link" :class="{'active': mode === 'blockly'}" href="#"
                       @click.prevent="setBlocklyMode">Blockly</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" :class="{'active': mode === 'reduc'}" href="#"
                       @click.prevent="setReducMode">Reduc</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" :class="{'active': mode === 'target'}" href="#"
                       @click.prevent="setTargetMode">@{{ language.name }}</a>
                </li>
            </ul>
        </div>
        <div class="col-lg-3 text-right">
            <h4><small class="text-muted">@{{ language.robot }}</small></h4>
        </div>
    </div>
    <div v-if="mode === 'reduc' || mode === 'target'">
        <div class="row">
            <div class="col-lg-3">
                <reduc-functions :language="language"></reduc-functions>
            </div>
            <div class="col-lg-9">
                <div class="row">
                    <div class="col-lg-12 mb-3">
                        <div class="input-group bg-white">
                            <input class="form-control" type="text" id="nome-do-programa" v-model="program.name" :disabled="disableNameInput == true">
                            <span class="input-group-append">
                                <button class="btn btn-outline-info" @click="save">
                                    <i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar
                                </button>
                                <button v-if="programExists && mode === 'reduc'" class="btn btn-outline-warning" @click="compile">
                                    <i class="fa fa-code" aria-hidden="true"></i> Compilar
                                </button>
                                <button v-if="programExists && mode === 'target' && targetCanCompile" class="btn btn-outline-warning" @click="compile">
                                    <i class="fa fa-code" aria-hidden="true"></i> Compilar Alvo
                                </button>
                                <a v-if="programExists && targetCanSend" :href="downloadUrl" class="btn btn-outline-success" target="_blank" v-if="disableNameInput == true">
                                    <i class="fa fa-paper-plane-o" aria-hidden="true"></i> Enviar
                                </a>
                                <button class="btn btn-outline-primary" title="Solicitar Correção" disabled="disabled">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                </button>
                                <button class="btn btn-outline-primary" title="Download" disabled="disabled">
                                    <i class="fa fa-download" aria-hidden="true"></i>
                                </button>
                                <button class="btn btn-outline-primary" id="btn-new" @click="newProgram" title="Novo">
                                    <i class="fa fa-file-o" aria-hidden="true"></i>
                                </button>
                                <div class="btn-group b-dropdown dropdown">
                                    <a class="btn btn-outline-primary btn-square dropdown-toggle" href="#" role="button"
                                       id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                       style="margin-left: -1px;">
                                        <i class="fa fa-folder-open-o" aria-hidden="true"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <a v-for="item of programs" class="dropdown-item" href="#" @click="loadProgram(item)">@{{ item.name }}</a>
                                    </div>
                                </div>
                            </span>
                        </div>
                        @guest
                            <a href="{{ route('login') }}" class="btn btn-outline-primary float-right" title="Faça login para acessar todas as funcionalidades">
                                <i class="fa fa-unlock" aria-hidden="true"></i> Login
                            </a>
                        @endguest
                    </div>
                    <div class="col-lg-12">
                        <div class="card" :class="{ 'border-danger': errors }">
                            <editor v-if="mode === 'reduc'" editor-id="editor1" :content="program.code" @new-content="updateCode"></editor>
                            <editor v-else-if="mode === 'target'" editor-id="editor2" :content="program.customCode" @new-content="updateCustomCode"></editor>
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
        </div>
    </div>
    <div v-show="mode === 'blockly'" class="row">
        <div class="col-lg-12">
            <div id="blocklyDiv" style="height: 480px; width: 100%;"></div>
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