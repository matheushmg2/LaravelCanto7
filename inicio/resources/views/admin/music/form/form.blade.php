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
            {{ Form::label('image', 'Músicas') }}
            <div class="custom-file">
                {!! Form::file('image[]', ['class' => 'custom-file-input imgProduto', 'id' => 'imgProduto', 'multiple']) !!} {{-- , 'accept'=>'image/*' --}}
                {!! Form::label('image', 'Insira a músicas', ['class' => 'custom-file-label']) !!}
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
        <ul id="nome" class="nav navbar-nav">

        </ul>
    </div>
</div>
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    $(".imgProduto").change(function() {
            readURL(this);
            $('#imgProduto').on("click", function() {
                $('#nome').html('');
            });
        });

        function readURL(input) {
            console.log(input.files.length);
            if (input.files.length <= 20) {
                if (input.files && input.files[0]) {
                    for (let i = 0; i < input.files.length; i++){
                        console.log(input.files[i].name);
                        $('#nome').append("<li>" +input.files[i].name + "</li>");
                    }
                }else{
                    $('#nome').html('');
                }
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Insira pelo menos 20 músicas.'
                });
            }
        }
</script>
@endsection
