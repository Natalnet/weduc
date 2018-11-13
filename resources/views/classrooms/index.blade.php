@extends('layouts.app')

@section('content')
    <div class="container-fluid animated fadeIn">
        <router-view></router-view>
    </div>
    <notifications group="classroom" position="bottom right" ></notifications>
@endsection
