@extends('layouts.app')

@section('content')
    <div class="container-fluid animated fadeIn">
        <classrooms-index></classrooms-index>
    </div>
    <notifications group="classroom" position="bottom right" ></notifications>
@endsection
