@extends('layouts.app')
@section('css')
    <style>
   .table td,
        .table th {
            border: none;
        }
        .card {
            width: 100%;
        }

        .card-body {
            padding: 0;
        }
        tbody tr td nav ul.pagination{
            float: right;
            margin: 1rem -5rem -1rem 0rem;
        }

        nav {
            /*float: right;
            margin: 1rem -5rem -1rem 0rem;*/
        }

        @media (max-width: 575.98px) {
            .responsivo {
                display: none;
            }
            tbody tr td nav ul.pagination {
                float: left;
                /*margin: 1rem -5rem -1rem 0rem;*/
            }
        }

        @media (max-width: 767.98px) {
            .responsivo {
                display: none;
            }
            tbody tr td nav ul.pagination {
                float: left;
                /*margin: 1rem -5rem -1rem 0rem;*/
            }
        }

        @media (max-width: 991.98px) {
            .responsivo2 {
                display: none;
            }
            .btn, audio{
                margin-top: 17px;
            }
            tbody tr td nav ul.pagination {
                float: left;
                /*margin: 1rem -5rem -1rem 0rem;*/
            }
        }

        audio {
            width: 225px;
            box-shadow: 5px 5px 20px rgba(0, 0, 0, 0.4);
            border-radius: 90px;
            transform: scale(1.05);
            margin-right: 20px;
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
        <div class="card-header">
            <h3 class="card-title">Músicas - {{ Auth::user()->name }}</h3>

            <div style="width: 50%;">
                <input type="text" name="serach" id="serach" class="form-control" placeholder="Nome da Música">
            </div>


            {{-- @if ($jaExiste20Img[0]->cont < 20) --}}
            <a type="button" href="{{ route('music.create') }}"
                class="float-right btn btn-outline-success" style="margin-top: -80px;">
                <h5 style="margin: 0;">Criar <i class="fas fa-plus"></i></h5>
            </a>
            {{-- @endif --}}

        </div>
        <div class="card-body">
            <table class="table table-sm table-hover table-striped">
                <thead class="thead-dark">
                    <tr class="text-center">
                        <th scope="col" >Galeria ID</th>
                        <th scope="col" class="responsivo">Discografia Gênero</th>
                        <th scope="col" class="responsivo" style="padding-bottom: 14px;">Nome da Música</th>
                        <th scope="col" style="padding-bottom: 14px;">Música</th>
                        <th scope="col" colspan="2" style="padding-bottom: 14px;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @include('admin.music.table.pagination_data')
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            FOOTER
        </div>

    </div>
@endsection

@section('scripts2')

    <script>

    </script>
    <script>

        function search_page(page, query) {
            $.ajax({
                url: "music/search_page?page=" + page + "&query=" +
                    query,
                success: function(data) {
                    //console.log(data);
                    $('tbody').html('');
                    $('tbody').html(data);
                }
            });
        }

        $(document).on('keyup', '#serach', function() {
            var query = $('#serach').val();

            var page = 1; //$('#hidden_page').val();
            search_page(page, query);
        });

        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];

            var query = $('#serach').val();
            $('li').removeClass('active');
            $(this).parent().addClass('active');
            //console.log(page);
            search_page(page, query);
        });

    </script>

@endsection
