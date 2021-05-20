@extends('layouts.app')
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul style="list-style: none;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Galeria - {{ Auth::user()->name }}</h3>
        </div>
        {{ Form::open(['route' => 'galerias.store', 'method' => 'POST', 'files' => true]) }}
        <div class="card-body">

            @include('admin.galerias.form.form')
        </div>
        <div class="card-footer">
            <a href="{{ route('galerias.index') }}" class="btn btn-danger float-right">Cancelar</a>
            <input type="submit" value="Cadastrar" class="btn btn-primary">
        </div>
        {{ Form::close() }}
    </div>
@endsection
