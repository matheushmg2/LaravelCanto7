@extends('layouts.app')
@section('content')
    <style>

        #submit:focus {
            outline: none;
            outline-offset: none;
        }

        .button {
            display: inline-block;
            padding: 6px 12px;
            margin: 20px 8px;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.42857143;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            -ms-touch-action: manipulation;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            background-image: none;
            border: 2px solid transparent;
            border-radius: 5px;
            color: #fff;
            background-color: #3490dc;
            border-color: #3490dc;
        }

        .button_loader {
            background-color: transparent;
            border: 6px dotted #3490dc;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
        }

        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

    </style>
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
        {{ Form::open(['route' => 'music.store', 'method' => 'POST', 'files' => true]) }}
        <div class="card-body">

            @include('admin.music.form.form')
        </div>
        <div class="card-footer">
            <a href="{{ route('music.index') }}" class="btn btn-danger float-right" style="margin-top: 20px;">Cancelar</a>
            <p id="teste" style="position: absolute; margin: 26px 0 0 55px;color: #9f9f9f;"></p>
            <input type="submit" value="Cadastrar" class="button" id="submit">

        </div>
        {{ Form::close() }}
    </div>
@endsection
@section('scripts2')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.js"></script>
    <script>
        $('#submit').click(function() {
            $(this).addClass('button_loader').attr("value", "");
            $('#teste').html("carregando...");
            window.setTimeout(function() {
                $('#submit').removeClass('button_loader').attr("value", "\u2713");
                $('#teste').html("");
                $('#submit').prop('disabled', true);
            }, 1200000);
        });

    </script>
@endsection
