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
        <form method="POST" action="{{ route('languages.store') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
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
                                        <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="name" placeholder="Digite um nome para a função" value="{{ old('name') }}">

                                        @if ($errors->has('name'))
                                            <div class="invalid-feedback" style="display: block;">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="robot">Nome do Robô</label>
                                        <input type="text" class="form-control" name="robot" id="robot" placeholder="Digite um nome para a função" value="{{ old('robot') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="description">Descrição</label>
                                        <textarea type="text" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" id="description" placeholder="Descrição" rows="6">
                                        {{ old('description') }}
                                    </textarea>

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

                            <h5>Compilação e Envio</h5>
                            <b>Compilação</b>
                            <p class="text-muted">
                                Nesta seção você deve inserir a chamada de compilação em Windows, a extensão do arquivo gerado na sua linguagem e o compilador a ser utilizado. Os dados fornecidos serão utilizados para geração do código intermediário na linguagem NXC e geração do código objeto para envio ao robô.
                            </p>
                            <p class="text-muted">
                                O código de compilação deve ser inserido referenciando a localização de todos os arquivos necessários(códigos fonte e compilador) com a palavra chave diretorio para indicar o endereço dos arquivos. Já o nome do programa deve ser indicado com a palavra chave nomedoprograma. Por exemplo, caso o seu código de compilação seja nbc nomedoprograma.nxc -O=nomedoprograma.rxe ele deverá ser escrito da seguinte forma: diretorio/nbc diretorio/nomedoprograma.nxc -O=diretorio/nomedoprograma.rxe
                            </p>
                            <p class="text-muted">
                                Caso seja necessário descompactar os arquivos do compilador ou realizar algum tipo de instalação. Marque o item Instalação necessária.
                            </p>
                            <div class="form-group">
                                <label for="compile_code">Código de Compilação</label>
                                <input type="text" class="form-control" name="compile_code" id="compile_code" placeholder="Digite código de compilação" value="{{ old('compile_code') }}">
                            </div>
                            <div class="form-group">
                                <label for="extension">Extensão dos arquivos na linguagem</label>
                                <input type="text" class="form-control" name="extension" id="extension" placeholder="Digite código de compilação" value="{{ old('extension') }}">
                            </div>

                            <div class="form-group">
                                <label for="code">Código</label>
                                <textarea type="text" class="form-control" name="code" id="code" placeholder="Descrição" rows="6">
                                {{-- {{ old('code') ?: $function->code }} --}}
                            </textarea>

                                @if ($errors->has('code'))
                                    <div class="invalid-feedback" style="display: block;">
                                        <strong>{{ $errors->first('code') }}</strong>
                                    </div>
                                @endif
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
                                <input type="text" class="form-control" name="compile_code" id="compile_code" placeholder="Digite código de compilação" value="{{ old('compile_code') }}">
                            </div>
                            <div class="form-group">
                                <label for="extension">Extensão dos arquivos na linguagem</label>
                                <input type="text" class="form-control" name="extension" id="extension" placeholder="Digite código de compilação" value="{{ old('extension') }}">
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
                                <input type="text" class="form-control" name="send_code" id="send_code" placeholder="Digite código de envio" value="{{ old('send_code') }}">
                            </div>
                            <div class="form-group">
                                <label for="sent_extension">Nome do arquivo a ser enviado com sua respectiva extensão</label>
                                <input type="text" class="form-control" name="sent_extension" id="sent_extension" placeholder="Digite nome do arquivo" value="{{ old('sent_extension') }}">
                            </div>
                            <div class="form-group">
                                <label for="sending_files">Arquivos de Envio</label>
                                <input type="file" class="form-control" name="sending_files" id="sending_files">
                                <span class="help-block">Envia os arquivos necessários em um único aquivo zip.</span>
                            </div>
                            <div class="form-group">
                                <label for="compiler_file">Nome do Arquivo</label>
                                <input type="text" class="form-control" name="compiler_file" id="compiler_file" placeholder="Digite nome do arquivo" value="{{ old('compiler_file') }}">
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
                                    <textarea type="text" class="form-control" name="header" id="header" placeholder="Cabeçalho" rows="6">
                                    {{ old('header') }}
                                </textarea>

                                    @if ($errors->has('header'))
                                        <div class="invalid-feedback" style="display: block;">
                                            <strong>{{ $errors->first('header') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="footnote">Rodapé</label>
                                    <textarea type="text" class="form-control" name="footnote" id="footnote" placeholder="Rodapé" rows="6">
                                    {{ old('footnote') }}
                                </textarea>

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
                                    <textarea type="text" class="form-control" name="main_function" id="main_function" placeholder="Cabeçalho" rows="10">
                                    {{ old('main_function') }}
                                </textarea>

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
                                    <textarea type="text" class="form-control" name="other_functions" id="other_functions" placeholder="Função na linguagem alvo" rows="6">
                                    {{ old('other_functions') }}
                                </textarea>

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
                                    <label for="declare_string">Declaração do Tipo Texto</label>
                                    <textarea type="text" class="form-control" name="declare_string" id="declare_string" placeholder="Declaração do Tipo Texto" rows="6">
                                    {{ old('declare_string') }}
                                </textarea>

                                    @if ($errors->has('declare_string'))
                                        <div class="invalid-feedback" style="display: block;">
                                            <strong>{{ $errors->first('declare_string') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="footnote">Rodapé</label>
                                    <textarea type="text" class="form-control" name="footnote" id="footnote" placeholder="Rodapé" rows="6">
                                    {{ old('footnote') }}
                                </textarea>

                                    @if ($errors->has('footnote'))
                                        <div class="invalid-feedback" style="display: block;">
                                            <strong>{{ $errors->first('footnote') }}</strong>
                                        </div>
                                    @endif
                                </div>
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
                                    <textarea type="text" class="form-control" name="header" id="header" placeholder="Cabeçalho" rows="6">
                                    {{ old('header') }}
                                </textarea>

                                    @if ($errors->has('header'))
                                        <div class="invalid-feedback" style="display: block;">
                                            <strong>{{ $errors->first('header') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="footnote">Rodapé</label>
                                    <textarea type="text" class="form-control" name="footnote" id="footnote" placeholder="Rodapé" rows="6">
                                    {{ old('footnote') }}
                                </textarea>

                                    @if ($errors->has('footnote'))
                                        <div class="invalid-feedback" style="display: block;">
                                            <strong>{{ $errors->first('footnote') }}</strong>
                                        </div>
                                    @endif
                                </div>
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
                                    <textarea type="text" class="form-control" name="header" id="header" placeholder="Cabeçalho" rows="6">
                                    {{ old('header') }}
                                </textarea>

                                    @if ($errors->has('header'))
                                        <div class="invalid-feedback" style="display: block;">
                                            <strong>{{ $errors->first('header') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="footnote">Rodapé</label>
                                    <textarea type="text" class="form-control" name="footnote" id="footnote" placeholder="Rodapé" rows="6">
                                    {{ old('footnote') }}
                                </textarea>

                                    @if ($errors->has('footnote'))
                                        <div class="invalid-feedback" style="display: block;">
                                            <strong>{{ $errors->first('footnote') }}</strong>
                                        </div>
                                    @endif
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
