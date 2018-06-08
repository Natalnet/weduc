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
    <form method="POST" action="{{ route('languages.update', ['language' => $language->id]) }}">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4>Edição do Cadastro de Linguagem</h4>
                        <hr>
                        <p class="text-muted">
                            Para cadastrar uma linguagem você deverá preencher todos os campos seguindo os exemplos aprensentados. Observe que existem algumas palavras específicas que são utilizadas para identificar e tratar os dados fornecidos, como por exemplo: <b>comandos, comandos1, comandos2, principal, nomedoprograma, funcao, variavel, valor</b>.
                        </p>
                        <p class="text-muted">
                            Os únicos dados que não são de preenchimento obrigatório são: <b>descrição, cabeçalho, rodapé e funções</b>. Caso você professor deseje facilitar a manipulação da linguagem para os seus alunos é possível utilizar o cabeçalho para definir as funções que serão apenas manipuladas ao serem cadastradas no item <b>funções</b>. A palavra chave <b>nomedoprograma</b> ao ser encontrada nos itens do cadastro será substituída pelo nome do programa salvo pelo usuário.
                        </p>
                        <p class="text-muted">
                            Ao término do preenchimento, você deve validar a linguagem clicando na imagem de validação. Caso você tenha deixado de utilizar as palavras reservadas em um dos itens o sistema o informará marcando de vermelho o item.
                        </p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Nome</label>
                                    <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="name" placeholder="Digite um nome para a função" value="{{ old('name', $language->name) }}">

                                    @if ($errors->has('name'))
                                        <div class="invalid-feedback" style="display: block;">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="robot">Nome do Robô</label>
                                    <input type="text" class="form-control" name="robot" id="robot" placeholder="Digite um nome para a função" value="{{ old('robot') ?: $language->robot }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="description">Descrição</label>
                                    <textarea
                                        type="text"
                                        class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                        name="description"
                                        id="description"
                                        placeholder="Descrição"
                                        rows="6"
                                    >{{ old('description', $language->description) }}</textarea>

                                    @if ($errors->has('description'))
                                        <div class="invalid-feedback" style="display: block;">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                @if ($errors->has('email'))
                                    <div class="invalid-feedback" style="display: block;">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-4">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#compilation" role="tab" aria-controls="compilation" aria-expanded="true">
                            Compilação
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#sending" role="tab" aria-controls="sending" aria-expanded="false">
                            Envio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#header-footer" role="tab" aria-controls="header-footer" aria-expanded="false">
                            Cabeçalho e Rodapé
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#main-function" role="tab" aria-controls="main-function" aria-expanded="false">
                            Função Principal
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#functions" role="tab" aria-controls="functions" aria-expanded="false">
                            Funções
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#data-types" role="tab" aria-controls="data-types" aria-expanded="false">
                            Tipos de Dados
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#operators" role="tab" aria-controls="operators" aria-expanded="false">
                            Operadores
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#control-flow" role="tab" aria-controls="control-flow" aria-expanded="false">
                            Controle de Fluxo
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="compilation" role="tabpanel" aria-expanded="true">
                        <p class="text-muted">
                            Nesta seção você deve inserir a chamada de compilação em Windows, a extensão do arquivo gerado na sua linguagem e o compilador a ser utilizado. Os dados fornecidos serão utilizados para geração do código intermediário na linguagem NXC e geração do código objeto para envio ao robô.
                        </p>
                        <p class="text-muted">
                            O código de compilação deve ser inserido referenciando a localização de todos os arquivos necessários(códigos fonte e compilador) com a palavra chave diretorio para indicar o endereço dos arquivos. Já o nome do programa deve ser indicado com a palavra chave nomedoprograma. Por exemplo, caso o seu código de compilação seja nbc nomedoprograma.nxc -O=nomedoprograma.rxe ele deverá ser escrito da seguinte forma:
                            <br><kbd>diretorio/nbc diretorio/nomedoprograma.nxc -O=diretorio/nomedoprograma.rxe</kbd>
                        </p>
                        <p class="text-muted">
                            Caso seja necessário descompactar os arquivos do compilador ou realizar algum tipo de instalação. Marque o item Instalação necessária.
                        </p>
                        <div class="form-group">
                            <label for="compile_code">Código de Compilação</label>
                            <input
                                type="text"
                                class="form-control"
                                name="compile_code"
                                id="compile_code"
                                placeholder="Digite código de compilação"
                                value="{{ old('compile_code', $language->compile_code) }}"
                            >
                        </div>
                        <div class="form-group">
                            <label for="extension">Extensão dos arquivos na linguagem</label>
                            <input
                                type="text"
                                class="form-control"
                                name="extension"
                                id="extension"
                                placeholder="Digite código de compilação"
                                value="{{ old('extension', $language->extension) }}"
                            >
                        </div>
                        <div class="form-group">
                            <label for="compilation_files">Arquivos de Compilação</label>
                            <input type="file" class="form-control" name="compilation_files" id="compilation_files">
                            <span class="help-block">Envia os arquivos necessários em um único aquivo zip.</span>
                        </div>
                        <div class="form-group">
                            <label for="include_files">Arquivos de Include</label>
                            <input type="file" class="form-control" name="include_files" id="include_files">
                            <span class="help-block">Envia os arquivos necessários em um único aquivo zip.</span>
                        </div>
                    </div>
                    <div class="tab-pane" id="sending" role="tabpanel" aria-expanded="false">
                        <p class="text-muted">
                            Nesta seção você deve inserir a chamada de envio do programa em sua plataforma e a extensão do código a ser enviado ao computador local para posteriormente ser enviado ao robô através da chamada inserida.
                        </p>
                        <p class="text-muted">
                            O código de envio deve ser inserido referenciando a localização de todos os arquivos necessários(códigos fonte e programa de envio) com a palavra chave diretorio para indicar o endereço dos arquivos. Já o nome do programa deve ser indicado com a palavra chave nomedoprograma. Por exemplo, caso o seu código de envio seja nbc -d nomedoprograma.nxc ele deverá ser escrito da seguinte forma: diretorio/nbc -d diretorio/nomedoprograma.nxc. Esse endereço de diretório será tratado e substituído pelo endereço de sua pasta local de arquivos temporários.
                        </p>
                        <div class="form-group">
                            <label for="send_code">Código de Envio</label>
                            <input type="text" class="form-control" name="send_code" id="send_code" placeholder="Digite código de envio" value="{{ old('send_code', $language->send_code) }}">
                        </div>
                        <div class="form-group">
                            <label for="sent_extension">Nome do arquivo a ser enviado com sua respectiva extensão</label>
                            <input type="text" class="form-control" name="sent_extension" id="sent_extension" placeholder="Digite nome do arquivo" value="{{ old('sent_extension', $language->sent_extension) }}">
                        </div>
                        <div class="form-group">
                            <label for="sending_files">Arquivos de Envio</label>
                            <input type="file" class="form-control" name="sending_files" id="sending_files">
                            <span class="help-block">Envia os arquivos necessários em um único aquivo zip.</span>
                        </div>
                        <div class="form-group">
                            <label for="compiler_file">Nome do Arquivo</label>
                            <input type="text" class="form-control" name="compiler_file" id="compiler_file" placeholder="Digite nome do arquivo" value="{{ old('compiler_file', $language->compiler_file) }}">
                        </div>
                    </div>
                    <div class="tab-pane" id="header-footer" role="tabpanel" aria-expanded="false">
                        <p class="text-muted">
                            Nesta seção você deve inserir o cabeçalho e rodapé necessários para gerar o seu código. Lembre-se de incluir todas as bibliotecas e fazer todas as definições necessárias para o funcionamento do seu programa. O cabeçalho e o rodapé inseridos serão adicionados a todos os códigos gerados para esta linguagem.
                        </p>
                        <p class="text-muted">
                            Caso você deseje facilitar a manipulação da linguagem para os seus alunos é possível utilizar o cabeçalho para definir as funções que serão manipuladas ao serem cadastradas no item funções. Novas estruturas também podem ser definidas nesta seção.
                        </p>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="header">Cabeçalho</label>
                                <textarea
                                    type="text"
                                    class="form-control"
                                    name="header"
                                    id="header"
                                    placeholder="Cabeçalho"
                                    rows="6"
                                >{{ old('header', $language->header) }}</textarea>

                                @if ($errors->has('header'))
                                    <div class="invalid-feedback" style="display: block;">
                                        <strong>{{ $errors->first('header') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="form-group col-md-6">
                                <label for="footnote">Rodapé</label>
                                <textarea
                                    type="text"
                                    class="form-control"
                                    name="footnote"
                                    id="footnote"
                                    placeholder="Rodapé"
                                    rows="6"
                                >{{ old('footnote', $language->footnote) }}</textarea>

                                @if ($errors->has('footnote'))
                                    <div class="invalid-feedback" style="display: block;">
                                        <strong>{{ $errors->first('footnote') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="main-function" role="tabpanel" aria-expanded="false">
                        <p class="text-muted">
                            Nesta seção você deve declarar a função principal do seu programa.
                        </p>
                        <p class="text-muted">
                            Os exemplos abaixo mostram como é definida a função principal nas linguagens de programação R-Educ e C. Observe que a palavra reservada comandos deve ser utilizada.
                        </p>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="main_function">Função Principal na Linguagem Alvo</label>
                                <textarea
                                    type="text"
                                    class="form-control"
                                    name="main_function"
                                    id="main_function"
                                    placeholder="Cabeçalho"
                                    rows="10"
                                >{{ old('main_function', $language->main_function) }}</textarea>

                                @if ($errors->has('main_function'))
                                    <div class="invalid-feedback" style="display: block;">
                                        <strong>{{ $errors->first('main_function') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-block">
                                    <b>Linguagem R-Educ</b>
                                    <pre><code>tarefa principal {<br>    comandos<br>}</code></pre>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-block">
                                    <b>Linguagem C</b>
                                    <pre><code>int main() {<br>    comandos<br>    return 0;<br>}</code></pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="functions" role="tabpanel" aria-expanded="false">
                        <p class="text-muted">
                            Nesta seção você deve identificar como é feita a declaração de funções sem retorno do seu programa.
                        </p>
                        <p class="text-muted">
                            Os exemplos abaixo mostram como são definidas as funções sem retorno nas linguagens de programação R-Educ e C. Observe que as palavras reservadas comandos e funcao devem ser utilizadas.
                        </p>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="other_functions">Função na linguagem alvo</label>
                                <textarea
                                    type="text"
                                    class="form-control"
                                    name="other_functions"
                                    id="other_functions"
                                    placeholder="Função na linguagem alvo"
                                    rows="6"
                                >{{ old('other_functions', $language->other_functions) }}</textarea>

                                @if ($errors->has('other_functions'))
                                    <div class="invalid-feedback" style="display: block;">
                                        <strong>{{ $errors->first('other_functions') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-block">
                                    <b>Linguagem R-Educ</b>
                                    <pre><code>tarefa funcao {<br>    comandos<br>}</code></pre>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-block">
                                    <b>Linguagem C</b>
                                    <pre><code>void funcao() {<br>    comandos<br>}</code></pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <p class="text-muted">
                            Depois que a função foi declarada, ela pode ser chamada. Os exemplos abaixo mostram como são feitas chamadas de funções nas linguagens de programação R-Educ e C. Observe que a palavra reservada funcao deve ser utilizada.
                        </p>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="call_function">Função na linguagem alvo</label>
                                <textarea
                                    type="text"
                                    class="form-control"
                                    name="call_function"
                                    id="call_function"
                                    rows="6"
                                >{{ old('call_function', $language->call_function) }}</textarea>

                                @if ($errors->has('call_function'))
                                    <div class="invalid-feedback" style="display: block;">
                                        <strong>{{ $errors->first('call_function') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-block">
                                    <b>Linguagem R-Educ</b>
                                    <pre><code>funcao</code></pre>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-block">
                                    <b>Linguagem C</b>
                                    <pre><code>funcao();</code></pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="data-types" role="tabpanel" aria-expanded="false">
                        <p class="text-muted">
                            Nesta seção você deve definir como são declaradas variáveis utilizando tipos específicos de dados na Linguagem Alvo.
                        </p>
                        <p class="text-muted">
                            A linguagem R-Educ possui três tipos de dados: texto, numero e booleano. Siga os exemplos abaixo para declarar as variáveis. Observe que as palavras reservadas variavel e valor devem ser utilizadas.
                        </p>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="type_string">Declaração do Tipo Texto</label>
                                <textarea
                                    type="text"
                                    class="form-control"
                                    name="type_string"
                                    id="type_string"
                                    placeholder="Tipo texto"
                                    rows="6"
                                >{{ old('type_string', $language->getDataType('declare_string')) }}</textarea>

                                @if ($errors->has('type_string'))
                                    <div class="invalid-feedback" style="display: block;">
                                        <strong>{{ $errors->first('type_string') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-block">
                                    <b>Linguagem R-Educ</b>
                                    <pre><code>texto variavel = "valor"</code></pre>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-block">
                                    <b>Linguagem C</b>
                                    <pre><code>String variavel = "valor";</code></pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="type_float">Declaração do Tipo Número</label>
                                <textarea
                                    type="text"
                                    class="form-control"
                                    name="type_float"
                                    id="type_float"
                                    placeholder="Tipo número"
                                    rows="6"
                                >{{ old('type_float', $language->getDataType('declare_float')) }}</textarea>

                                @if ($errors->has('type_float'))
                                    <div class="invalid-feedback" style="display: block;">
                                        <strong>{{ $errors->first('type_float') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-block">
                                    <b>Linguagem R-Educ</b>
                                    <pre><code>numero variavel = valor</code></pre>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-block">
                                    <b>Linguagem C</b>
                                    <pre><code>float variavel = valor;</code></pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="type_boolean">Declaração do Tipo Booleano</label>
                                <textarea
                                    type="text"
                                    class="form-control"
                                    name="type_boolean"
                                    id="type_boolean"
                                    placeholder="Tipo número"
                                    rows="6"
                                >{{ old('type_boolean', $language->getDataType('declare_boolean')) }}</textarea>

                                @if ($errors->has('type_boolean'))
                                    <div class="invalid-feedback" style="display: block;">
                                        <strong>{{ $errors->first('type_boolean') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-block">
                                    <b>Linguagem R-Educ</b>
                                    <pre><code>booleano variavel = valor</code></pre>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-block">
                                    <b>Linguagem C</b>
                                    <pre><code>bool variavel = valor;</code></pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="type_true">Verdadeiro</label>
                                <textarea
                                    type="text"
                                    class="form-control"
                                    name="type_true"
                                    id="type_true"
                                    placeholder="Verdadeiro"
                                    rows="6"
                                >{{ old('type_true', $language->getDataType('declare_true')) }}</textarea>

                                @if ($errors->has('type_true'))
                                    <div class="invalid-feedback" style="display: block;">
                                        <strong>{{ $errors->first('type_true') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-block">
                                    <b>Linguagem R-Educ</b>
                                    <pre><code>verdadeiro</code></pre>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-block">
                                    <b>Linguagem C</b>
                                    <pre><code>true</code></pre>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="type_false">Falso</label>
                                <textarea
                                    type="text"
                                    class="form-control"
                                    name="type_false"
                                    id="type_false"
                                    placeholder="Falso"
                                    rows="6"
                                >{{ old('type_false', $language->getDataType('declare_false')) }}</textarea>

                                @if ($errors->has('type_false'))
                                    <div class="invalid-feedback" style="display: block;">
                                        <strong>{{ $errors->first('type_false') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-block">
                                    <b>Linguagem R-Educ</b>
                                    <pre><code>falso</code></pre>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-block">
                                    <b>Linguagem C</b>
                                    <pre><code>false</code></pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="operators" role="tabpanel" aria-expanded="false">
                        <p class="text-muted">
                            Nesta seção você deve definir os operadores lógicos e relacionais da Linguagem Alvo. Os exemplos abaixo mostram como são definidos estes operadores nas linguagens de programação R-Educ e C.
                        </p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Operadores na Linguagem Alvo</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">e</span>
                                        <input type="text" name="op_and" class="form-control" value="{{ old('op_and', $language->operators->logical_and) }}">
                                    </div>

                                    @if ($errors->has('op_and'))
                                        <div class="invalid-feedback" style="display: block;">
                                            <strong>{{ $errors->first('op_and') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">ou</span>
                                        <input type="text" name="op_or" class="form-control" value="{{ old('op_or', $language->operators->logical_or) }}">
                                    </div>

                                    @if ($errors->has('op_or'))
                                        <div class="invalid-feedback" style="display: block;">
                                            <strong>{{ $errors->first('op_or') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">!</span>
                                        <input type="text" name="op_not" class="form-control" value="{{ old('op_not', $language->operators->logical_not) }}">
                                    </div>

                                    @if ($errors->has('op_not'))
                                        <div class="invalid-feedback" style="display: block;">
                                            <strong>{{ $errors->first('op_not') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">==</span>
                                        <input type="text" name="op_equals" class="form-control" value="{{ old('op_equals', $language->operators->equals_to) }}">
                                    </div>

                                    @if ($errors->has('op_equals'))
                                        <div class="invalid-feedback" style="display: block;">
                                            <strong>{{ $errors->first('op_equals') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">!=</span>
                                        <input type="text" name="op_different" class="form-control" value="{{ old('op_different', $language->operators->not_equal_to) }}">
                                    </div>

                                    @if ($errors->has('op_different'))
                                        <div class="invalid-feedback" style="display: block;">
                                            <strong>{{ $errors->first('op_different') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">></span>
                                        <input type="text" name="op_greater" class="form-control" value="{{ old('op_greater', $language->operators->greater_than) }}">
                                    </div>

                                    @if ($errors->has('op_greater'))
                                        <div class="invalid-feedback" style="display: block;">
                                            <strong>{{ $errors->first('op_greater') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">>=</span>
                                        <input type="text" name="op_greater_equals" class="form-control" value="{{ old('op_greater_equals', $language->operators->greater_than_or_equals_to) }}">
                                    </div>

                                    @if ($errors->has('op_greater_equals'))
                                        <div class="invalid-feedback" style="display: block;">
                                            <strong>{{ $errors->first('op_greater_equals') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><</span>
                                        <input type="text" name="op_less" class="form-control" value="{{ old('op_less', $language->operators->less_than) }}">
                                    </div>

                                    @if ($errors->has('op_less'))
                                        <div class="invalid-feedback" style="display: block;">
                                            <strong>{{ $errors->first('op_less') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><=</span>
                                        <input type="text" name="op_less_equals" class="form-control" value="{{ old('op_less_equals', $language->operators->less_than_or_equals_to) }}">
                                    </div>

                                    @if ($errors->has('op_less_equals'))
                                        <div class="invalid-feedback" style="display: block;">
                                            <strong>{{ $errors->first('op_less_equals') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Linguagem R-Educ e Linguagem C</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">e</span>
                                        <input type="text" class="form-control" value="&&" disabled="disabled">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">ou</span>
                                        <input type="text" class="form-control" value="||" disabled="disabled">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">!</span>
                                        <input type="text" class="form-control" value="!" disabled="disabled">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">==</span>
                                        <input type="text" class="form-control" value="==" disabled="disabled">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">!=</span>
                                        <input type="text" class="form-control" value="!=" disabled="disabled">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">></span>
                                        <input type="text" class="form-control" value=">" disabled="disabled">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">>=</span>
                                        <input type="text" class="form-control" value=">=" disabled="disabled">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><</span>
                                        <input type="text" class="form-control" value="<" disabled="disabled">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><=</span>
                                        <input type="text" class="form-control" value="<=" disabled="disabled">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="control-flow" role="tabpanel" aria-expanded="false">
                        <p class="text-muted">
                            Nesta sestao você deve definir as estruturas de controle de fluxo da Linguagem Alvo. A linguagem R-Educ possui as seguintes funções de controle de fluxo: se, enquanto, repita, teste, farei, para e sair.
                        </p>
                        <p class="text-muted">
                            Siga os exemplos abaixo para declarar as estruturas. Observe que cada definição possui um conjunto de palavras reservadas que devem ser utilizadas em cada caso, sendo elas: condicao, comandos, variavel, casos, valor, e passo.
                        </p>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="control_flow_if">Se</label>
                                <textarea type="text" class="form-control" name="control_flow_if" id="control_flow_if"
                                          rows="6"
                                >{{ old('control_flow_if', $language->controlFlowStatements->if_code) }}</textarea>

                                @if ($errors->has('control_flow_if'))
                                    <div class="invalid-feedback" style="display: block;">
                                        <strong>{{ $errors->first('control_flow_if') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-block">
                                    <b>Linguagem R-Educ</b>
                                    <pre><code>se (condicao) entao {<br>    comandos<br>}</code></pre>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-block">
                                    <b>Linguagem C</b>
                                    <pre><code>if (condicao) {<br>    comandos<br>}</code></pre>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="control_flow_else_if">Senão se</label>
                                <textarea type="text" class="form-control" name="control_flow_else_if" id="control_flow_else_if"
                                          rows="6"
                                >{{ old('control_flow_else_if', $language->controlFlowStatements->else_if) }}</textarea>

                                @if ($errors->has('control_flow_else_if'))
                                    <div class="invalid-feedback" style="display: block;">
                                        <strong>{{ $errors->first('control_flow_else_if') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-block">
                                        <b>Linguagem R-Educ</b>
                                        <pre><code>senao se (condicao) entao {<br>    comandos<br>}</code></pre>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-block">
                                        <b>Linguagem C</b>
                                        <pre><code>else if (condicao) {<br>    comandos1<br>}</code></pre>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="control_flow_else">Senão</label>
                                <textarea type="text" class="form-control" name="control_flow_else" id="control_flow_else"
                                          rows="6"
                                >{{ old('control_flow_else', $language->controlFlowStatements->else) }}</textarea>

                                @if ($errors->has('control_flow_else'))
                                    <div class="invalid-feedback" style="display: block;">
                                        <strong>{{ $errors->first('control_flow_else') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-block">
                                        <b>Linguagem R-Educ</b>
                                        <pre><code>senao {<br>    comandos<br>}</code></pre>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-block">
                                        <b>Linguagem C</b>
                                        <pre><code>else {<br>    comandos<br>}</code></pre>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="control_flow_repeat">Repita</label>
                                <textarea type="text" class="form-control" name="control_flow_repeat" id="control_flow_repeat"
                                          rows="6"
                                >{{ old('control_flow_repeat', $language->controlFlowStatements->repeat_code) }}</textarea>

                                @if ($errors->has('control_flow_repeat'))
                                    <div class="invalid-feedback" style="display: block;">
                                        <strong>{{ $errors->first('control_flow_repeat') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-block">
                                        <b>Linguagem R-Educ</b>
                                        <pre><code>repita var vezes {<br>    comandos<br>}</code></pre>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-block">
                                        <b>Linguagem C</b>
                                        <pre><code>for (int k = 0; k < var; k++) {<br>    comandos<br>}</code></pre>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="control_flow_while">Enquanto</label>
                                <textarea type="text" class="form-control" name="control_flow_while" id="control_flow_while"
                                          rows="6"
                                >{{ old('control_flow_while', $language->controlFlowStatements->while_code) }}</textarea>

                                @if ($errors->has('control_flow_while'))
                                    <div class="invalid-feedback" style="display: block;">
                                        <strong>{{ $errors->first('control_flow_while') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-block">
                                    <b>Linguagem R-Educ</b>
                                    <pre><code>enquanto (condicao) farei {<br>    comandos<br>}</code></pre>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-block">
                                    <b>Linguagem C</b>
                                    <pre><code>while (condicao) {<br>    comandos<br>}</code></pre>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="control_flow_do">Faça</label>
                                <textarea type="text" class="form-control" name="control_flow_do" id="control_flow_do"
                                          rows="6"
                                >{{ old('control_flow_do', $language->controlFlowStatements->do_code) }}</textarea>

                                @if ($errors->has('control_flow_do'))
                                    <div class="invalid-feedback" style="display: block;">
                                        <strong>{{ $errors->first('control_flow_do') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-block">
                                        <b>Linguagem R-Educ</b>
                                        <pre><code>faca {<br>    comandos<br>} enquanto (condicao) </code></pre>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-block">
                                        <b>Linguagem C</b>
                                        <pre><code>do {<br>    comandos<br>} while (condicao)</code></pre>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="control_flow_switch">Teste</label>
                                <textarea type="text" class="form-control" name="control_flow_switch" id="control_flow_switch"
                                          rows="6"
                                >{{ old('control_flow_switch', $language->controlFlowStatements->switch_code) }}</textarea>

                                @if ($errors->has('control_flow_switch'))
                                    <div class="invalid-feedback" style="display: block;">
                                        <strong>{{ $errors->first('control_flow_switch') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-block">
                                        <b>Linguagem R-Educ</b>
                                        <pre><code>teste (variavel) {<br>    casos<br>    outros:<br>        comandos<br>}</code></pre>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-block">
                                        <b>Linguagem C</b>
                                        <pre><code>switch (variavel) {<br>    casos<br>    default:<br>        comandos<br>        break;<br>}</code></pre>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="control_flow_case">Caso</label>
                                <textarea type="text" class="form-control" name="control_flow_case" id="control_flow_case"
                                          rows="6"
                                >{{ old('control_flow_case', $language->controlFlowStatements->case) }}</textarea>

                                @if ($errors->has('control_flow_case'))
                                    <div class="invalid-feedback" style="display: block;">
                                        <strong>{{ $errors->first('control_flow_case') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-block">
                                        <b>Linguagem R-Educ</b>
                                        <pre><code>caso valor:<br>    comandos<br></code></pre>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-block">
                                        <b>Linguagem C</b>
                                        <pre><code>case valor:<br>    comandos<br>    break;</code></pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
        <div class="row card-body">
            <div class="col-6">
                <button type="submit" class="btn btn-primary px-4">Salvar</button>
            </div>
            <div class="col-6 text-right">
                <button type="button" class="btn btn-link px-0">Precisa de ajuda?</button>
            </div>
        </div>
        </div>
    </form>
</div>
@endsection
