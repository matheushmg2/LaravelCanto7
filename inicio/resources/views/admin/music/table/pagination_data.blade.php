@foreach ($musics as $music)
    <tr>
        <th scope="row" class="text-center">{{ $music->galerias_id }}</th>
        <td class="responsivo text-center">{{ $music->genero }} </td>
        <td class="responsivo">{{ $music->nome_arquivos }} </td>
        <td >
            <audio id='audio' preload='auto' tabindex='0' controls>
                <source src='{{ $music->url }}'>
            </audio>
        </td>
        <td width='10px'>
            <a href="{{ route('music.edit', $music->galerias_id) }}" class="btn" style="color: #fff; background-color: #17a2b8; border-color: #17a2b8; box-shadow: none;">
                <i class="fas fa-edit"></i><p class="mb-0 responsivo responsivo2">Editar</p>
            </a>
        </td>
        <td width='10px'>
            {{ Form::open(['route' => ['music.destroy', $music->galerias_id], 'method' => 'DELETE']) }}
            <button class="btn btn-danger">
                <i class="fas fa-trash-alt"></i><p class="mb-0 responsivo responsivo2">Deletar</p>
            </button>
            {{ Form::close() }}
        </td>
    </tr>
@endforeach
<tr style="background: transparent;">
    <td colspan="5">
        {{ $musics->links() }}
    </td>
</tr>
