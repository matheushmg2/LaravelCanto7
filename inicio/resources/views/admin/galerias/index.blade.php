@extends('layouts.app')
@section('css')
    <style>
        .card {
            width: 100%;
            margin-bottom: 15px;
        }

        .card-header {
            margin-left: -40px;
            background: transparent;
            border: none;
        }

        .card-header button {
            margin: -12px 0px -12px 20px;
            padding: 8px 0;
            border: 1px solid rgb(255, 255, 255);

        }

        .card-header button:active,
        .card-header button:focus,
        .card-header button.active {
            background-image: none;
            outline: 0;
            -webkit-box-shadow: none;
            box-shadow: none;
        }

        .card-header button:not(.collapsed) {
            -webkit-box-shadow: 0px 0px 22px 2px #333;
            box-shadow: 0px 0px 22px 2px #333;
        }


        .card-header button.collapsed:after {
            font-family: "Font Awesome 5 Free";
            font-size: 17px;
            color: #000;
            position: relative;
            content: "\f067";
            font-weight: 900;
            float: right;
            margin-top: -25px;
            margin-right: 20px;
        }

        .card-header button:not(.collapsed):after {
            font-family: "Font Awesome 5 Free";
            font-size: 17px;
            color: #000;
            position: relative;
            content: "\f068";
            font-weight: 900;
            float: right;
            margin-top: -25px;
            margin-right: 20px;
        }

        .primeiro {
            margin: 30px 0 -20px 0;
        }

    </style>
@endsection
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
        <div class="card-header text-center" style="margin-bottom: -11px;">
            <h3 class="card-title" style="margin-left: 38px;">Galerias - {{ Auth::user()->name }}</h3>
            <a type="button" href="{{ route('galerias.create') }}"
                class="float-right btn btn-outline-success" style="margin-top: -45px;">
                <h5 style="margin: 0;">Criar <i class="fas fa-plus"></i></h5>
            </a>
        </div>
    </div>
    <div id="accordion">
        @foreach ($disco as $item)
            <p>{{--  --}}</p>

            <div class="card">
                <div class="card-header" id="heading{{ $item->id }}">
                    <button class="btn btn-tool collapsed btn-block text-center" data-toggle="collapse"
                        data-target="#collapse{{ $item->id }}" aria-expanded="false" aria-controls="collapse{{ $item->id }}">
                        <h3 class="mb-0">Galerias - Gênero: {{ $item->disco_genero }} - Album: {{ $item->album }} º</h3>
                    </button>
                </div>

                <div id="collapse{{ $item->id }}" class="collapse" aria-labelledby="heading{{ $item->id }}" data-parent="#accordion">
                    <div class="card-body primeiro">
                        <a type="button" href="{{ route('galerias.edit', Auth::user()->id) }}"
                            class="float-right btn btn-outline-success" style="margin-top: -34px;">
                            <h5 style="margin: 0;">Editar <i class="fas fa-plus"></i></h5>
                        </a>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <div class="card-body" id="apiproduct">
                            <div class="row justify-content-center">
                                @foreach ($products as $images)
                                    @if ($images->nome_arquivos == $item->id)
                                        <div class="col-sm-3" id="idimagem-{{ $images->id }}">
                                            <div class="row" style="margin-right: -10px; margin-left: -10px; margin-bottom: 10px;">
                                                <a href="{{ $images->url }}" data-toggle="lightbox"
                                                    data-title="ID {{ $images->id }}" data-gallery="example-gallery"
                                                    data-footer="Percente ao Produto: {{ $images->disco_genero }}">
                                                    <img src="{{ $images->url }}" alt="" class="img-fluid mb-2"
                                                        style="width: 300px; height: 175px;">
                                                </a>
                                                <a class="text-acima" href="{{ $images->url }}"
                                                    v-on:click.prevent='eliminarimagem({{ $images->id }})'>
                                                    <i class="fas fa-trash-alt" style="color: rgba(109, 34, 34, 0.801); border: 1px solid black; border-radius: 50%; padding: 0.5rem; font-size: 1.25rem"></i>
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('scripts2')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.js"></script>
    <script>
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });

    </script>
@endsection
