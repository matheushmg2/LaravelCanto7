<style>
    .miniatura {
        max-width: 100px;
        margin: 5px;
    }

</style>
@if ($errors->has('msg'))
@endif

{{ Form::hidden('user_id', auth()->user()->id) }}

<div class="form-group">
    <div class="row">
        <div class="col-md-6">
            {{ Form::label('image', 'Imagem') }}
            <div class="custom-file">
                {!! Form::file('image[]', ['class' => 'custom-file-input', 'id' => 'imgProduto', 'multiple']) !!}
                {{-- , 'accept'=>'image/*' --}}
                {!! Form::label('image', 'Insira a Imagem', ['class' => 'custom-file-label']) !!}
            </div>
        </div>
        <div class="col-md-6">
            {{ Form::label('genero', 'Gênero') }}
            @foreach ($discografias as $item)
                <div class="custom-control custom-radio">
                    <input type="radio" id="{{ $item->id }}" name="discografia_id" class="custom-control-input" value="{{ $item->id }}">
                    <label class="custom-control-label" for="{{ $item->id }}">{{ $item->disco_genero }} | {{ $item->nome_album }} | {{ $item->album }} º</label>
                </div>

            @endforeach

        </div>
    </div>
</div>

<div class="col-lg-6 col-md-6 normal">
    <div class="row">
        <div class="col-sm-12 galeria">
        </div>
    </div>
</div>
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $(function() {
            // Pré-visualização de várias imagens no navegador
            var imagesPreview = function(input, lugarParaInserirVisualizacaoDeImagem) {
                if (input.files) {
                    var filesAmount = input.files.length;
                    if (filesAmount <= 10) {
                        $(lugarParaInserirVisualizacaoDeImagem).empty(); // remove as imagens antigas
                        for (i = 0; i < filesAmount; i++) {
                            var reader = new FileReader();
                            reader.onload = function(event) {
                                $($.parseHTML('<img class="miniatura">')).attr('src', event.target.result)
                                    .appendTo(lugarParaInserirVisualizacaoDeImagem);
                            }
                            reader.readAsDataURL(input.files[i]);
                        }
                    } else {
                        $(lugarParaInserirVisualizacaoDeImagem).empty();
                        $("#imgProduto").val("");
                        Swal.fire({
                            icon: 'warning',
                            title: 'Oops...',
                            text: 'Insira pelo menos 10 imagens.'
                        });
                    }
                }
            };
            $('#imgProduto').on('change', function() {
                imagesPreview(this, 'div.galeria');
            });
        });

    </script>
@endsection
