@extends('layouts.app')

@section('content')
    <div class="container-fluid animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-code-branch"></i>
                        Últimas versões
                    </div>
                    <div class="card-body">
                        @foreach($releases as $os => $release)
                            <div class="h3">{{ $os . ' - ' . $release->version }}</div>
                            <p>Lançada em {{ $release->released_at->format('d/m/Y') }}</p>
                            <p>{{ $release->release_notes }}</p>
                            @if (!$loop->last)
                                <hr>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-code-branch"></i>
                        Nova versão
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('s_botics_releases.store') }}">
                            {{ csrf_field() }}
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="os">Sistema Operacional</label>
                                    <select id="os" name="os" class="form-control{{ $errors->has('os') ? ' is-invalid' : '' }}">
                                        <option value="">Selecione uma opção</option>
                                        <option value="windows">Windows</option>
                                        <option value="osx">OSx</option>
                                        <option value="linux">Linux</option>
                                    </select>

                                    @if ($errors->has('os'))
                                        <div class="invalid-feedback" style="display: block;">
                                            <strong>{{ $errors->first('os') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="version">Versão</label>
                                    <input type="text" class="form-control{{ $errors->has('version') ? ' is-invalid' : '' }}"
                                           name="version" id="version" placeholder="v1.0.0-alpha"
                                           value="{{ old('version') }}">

                                    @if ($errors->has('version'))
                                        <div class="invalid-feedback" style="display: block;">
                                            <strong>{{ $errors->first('version') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="released_at">Lançamento</label>
                                    <input type="text" class="form-control{{ $errors->has('released_at') ? ' is-invalid' : '' }}"
                                           name="released_at" id="released_at"
                                           placeholder="{{ today()->format('d/m/Y') }}"
                                           value="{{ old('released_at') }}">

                                    @if ($errors->has('released_at'))
                                        <div class="invalid-feedback" style="display: block;">
                                            <strong>{{ $errors->first('released_at') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="release_notes">Notas de Lançamento</label>
                                <textarea type="text" class="form-control{{ $errors->has('release_notes') ? ' is-invalid' : '' }}"
                                          name="release_notes" id="release_notes">
                                        {{ old('release_notes') }}
                                    </textarea>

                                @if ($errors->has('release_notes'))
                                    <div class="invalid-feedback" style="display: block;">
                                        <strong>{{ $errors->first('release_notes') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary px-4">Criar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
