
@extends('layouts.app')
@section('content')
@if (session('info'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('info') }}
    <button class="close" type="button" data-dismiss="alert" aria-label="close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Discografia - {{ Auth::user()->name }}</h3>
    </div>
    <div class="card-body table-responsive p-0">

        <a type="button" href="{{ route('discografia.create') }}" class="m-2 float-right btn btn-outline-success">
            <h5 style="margin: 0;">Criar <i class="fas fa-plus"></i></h5>
        </a>
        <table class="table table-head-fixed">
            <thead>
                <th scope='col'>ID</th>
                <th>Gênero</th>
                <th>Nome Album</th>
                <th>Album</th>
                <th colspan="2">&nbsp;</th>
            </thead>
            <tbody>
                @foreach($discos as $disco)
                    <tr>
                        <td scope='row'>{{ $disco->id }}</td>
                        <td>{{ $disco->disco_genero }} </td>
                        <td>{{ $disco->nome_album }} </td>
                        <td>{{ $disco->album}} º</td>
                        <td width='10px'>
                            <a href="{{ route('discografia.edit',$disco->id) }}" class="btn btn-info">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                        </td>
                        <td width='10px'>
                            {{ Form::open(['route'=>['discografia.destroy',$disco->id],'method'=>'DELETE']) }}
                            <button class="btn btn-danger">
                                <i class="fas fa-trash-alt"></i> Deletar
                            </button>
                            {{ Form::close() }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $discos->render() }}
    </div>
    <div class="card-footer">
        FOOTER
    </div>
</div>
@endsection


