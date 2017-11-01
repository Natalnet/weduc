@extends('layouts.app')

@section('content')
<div class="container-fluid animated fadeIn">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4>
                        <i class="fa fa-users"></i> Usuários
                        {{-- <a href="{{ route('roles.index') }}" class="btn btn-default pull-right">Roles</a> --}}
                        {{-- <a href="{{ route('permissions.index') }}" class="btn btn-default pull-right">Permissions</a> --}}
                    </h4>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">

                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>E-mail</th>
                                    {{-- <th>Date/Time Added</th> --}}
                                    <th>Função</th>
                                    <th>Opções</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($users as $user)
                                <tr>

                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    {{-- <td>{{ $user->created_at->format('F d, Y h:ia') }}</td> --}}
                                    <td>{{  $user->roles()->pluck('name')->implode(' ') }}</td>{{-- Retrieve array of roles associated to a user and convert to string --}}
                                    <td>
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-outline-info btn-sm pull-left" style="margin-right: 3px;">Editar</a>

                                    <form action="{{ route('users.destroy', ['user' => $user->id]) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button class="btn btn-outline-danger btn-sm" type="submit">Inativar</button>
                                    </form>

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>

                    {{-- <a href="{{ route('users.create') }}" class="btn btn-success">Add User</a> --}}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
