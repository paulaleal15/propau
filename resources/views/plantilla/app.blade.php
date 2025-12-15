@extends('web.app')

@section('contenido')
<div class="container px-4 px-lg-5 my-5">
    @yield('contenido-admin')
</div>
@endsection

@section('titulo', 'Admin - ' . config('app.name'))
