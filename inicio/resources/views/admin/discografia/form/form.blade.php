@if ($errors->has('msg'))
@endif
{{ Form::hidden('user_id', auth()->user()->id) }}
<div class="form-row">
    <div class="col">
        <div class="form-group">
            {{ Form::label('discografica_genero_id', 'Gênero') }}
            <select name="discografica_genero_id" class="form-control">
                @foreach ($discos_genero as $item)
                    <option value="{{ $item->id }}">{{ $item->disco_genero }}</option>

                @endforeach

            </select>
            {{-- Form::select('discografica_genero_id',$discos_genero,null,['class'=>'form-control']) --}}
        </div>
    </div>
    <div class="col">
        <div class="form-group ml-3">
            <label for="nome_album">Nome Album</label>
            <input type="text" class="form-control" id="nome_album" placeholder="Digite o Nome album" name="nome_album">
        </div>
    </div>
    <div class="col">
        <div class="form-group ml-5">
            <label for="album">Album</label>
            <br>
            @for ($i = 1; $i < 11; $i++)
                <div class="form-group form-check-inline col-md-3">
                    <input class="form-check-input" type="radio" name="album" id="inlineRadio{{ $i }}"
                        value="{{ $i }}">
                    <label class="form-check-label" for="inlineRadio{{ $i }}">{{ $i }}</label>
                </div>
            @endfor
        </div>
    </div>
</div>
