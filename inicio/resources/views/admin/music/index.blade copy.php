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
    <div class="card" >
        <div class="card-header" >
            <h3 class="card-title">Galerias - {{ Auth::user()->name }}</h3>
            <div class="col-md-4">
                <input class="typeahead form-control" type="text">
            </div>


            @if ($jaExiste20Img[0]->cont < 20)
                <a type="button" href="{{ route('music.edit', Auth::user()->id) }}"
                    class="float-right btn btn-outline-success" style="margin-top: -34px;">
                    <h5 style="margin: 0;">Editar <i class="fas fa-plus"></i></h5>
                </a>
            @endif

        </div>
        <div class="card-body table-responsive p-0" >
            <table class="table table-head-fixed" >
                <thead>
                    <th scope='col'>ID Galeria</th>
                    <th>Cantor</th>
                    <th>Discografia - Gênero</th>
                    <th>Nome da Música</th>
                    <th>Música</th>
                    <th>Ações</th>
                    <th colspan="2">&nbsp;</th>
                </thead>
                <tbody>
                    @foreach ($musics as $music)
                        <tr>
                            <td scope='row'>{{ $music->galerias_id }}</td>
                            <td>{{ $music->nome_user }} </td>
                            <td>{{ $music->genero }} </td>
                            <td>{{ $music->nome_arquivos }} </td>
                            <td>
                                <audio id='audio' preload='auto' tabindex='0' controls=''>
                                    <source src='{{ $music->url }}'>
                                </audio>
                            </td>
                            <td width='10px'>
                                <a href="{{ route('music.edit', $music->galerias_id) }}" class="btn btn-info">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                            </td>
                            <td width='10px'>
                                {{ Form::open(['route' => ['music.destroy', $music->galerias_id], 'method' => 'DELETE']) }}
                                <button class="btn btn-danger">
                                    <i class="fas fa-trash-alt"></i> Deletar
                                </button>
                                {{ Form::close() }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="float-right mr-3">
                {{ $musics->render() }}
            </div>

        </div>

        <div class="card-footer">
            FOOTER
        </div>

    </div>
@endsection

@section('scripts2')
    <script>
        $(document).ready(function() {

            $(document).on('click', '.pagination a', function(event) {

                var page = $(this).attr('href').split('page=')[1];
                console.log(page);
                fetch_data(page);
                event.preventDefault();
            });

            function fetch_data(page) {
                $.ajax({
                    url: "?page=" + page,
                    success: function(data) {
                        $('#table_data').html(data);
                    }
                });
            }

        });

    </script>
    <script>

        var path = "{{ url('music/search') }}";

        $('input.typeahead').typeahead({

            source:  function (query, process) {

            return $.get(path, { query: query }, function (data) {

                    return process(data);

                });

            }

        });

    </script>
@endsection
