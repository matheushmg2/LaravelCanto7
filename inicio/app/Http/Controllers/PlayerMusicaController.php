<?php

namespace App\Http\Controllers;

use App\Discografia;
use App\Http\TratarCaracteres;
use App\Player_musica;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlayerMusicaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $musics = Player_musica::where('user_id', auth()->user()->id)->first();
        //$jaExiste20Img = DB::select('select COUNT(*) cont from galerias where imageble_id = ?', [auth()->user()->id]);

        if($musics){

            $musics = Player_musica::
                    select('galerias.id AS galerias_id', 'users.name AS nome_user', 'discografica_generos.disco_genero AS genero', 'galerias.url', 'galerias.nome_arquivos')->
                    join('galerias', 'galerias.imageble_id', '=', 'player_musicas.id')->
                    join('users', 'users.id', '=', 'player_musicas.user_id')->
                    join('discografias', 'discografias.id', '=', 'player_musicas.discografia_id')->
                    join('discografica_generos', 'discografica_generos.id', '=', 'discografias.discografica_genero_id')->
                    where('player_musicas.user_id', auth()->user()->id)->
                    where('galerias.tipo', 'music')->
                    orderBy('player_musicas.user_id', 'DESC')->paginate(4);
                    //dd($musics);
            return view('admin.music.index', compact('musics'));
        } else {
            return $this->create();
        }
    }
/*  */
    public function search_page(Request $request)
    {
        if($request->ajax()){
            $query = $request->get('query');
            $query = str_replace(" ", "%", $query);
            $musics = Player_musica::
                    select('galerias.id AS galerias_id', 'users.name AS nome_user', 'discografica_generos.disco_genero AS genero', 'galerias.url', 'galerias.nome_arquivos')->
                    join('galerias', 'galerias.imageble_id', '=', 'player_musicas.id')->
                    join('users', 'users.id', '=', 'player_musicas.user_id')->
                    join('discografias', 'discografias.id', '=', 'player_musicas.discografia_id')->
                    join('discografica_generos', 'discografica_generos.id', '=', 'discografias.discografica_genero_id')->
                    where('galerias.tipo', 'music')->
                    when($query, function ($onde, $query) {
                        $onde->where('galerias.nome_arquivos', 'LIKE', '%'.$query.'%')->
                        orWhere('discografica_generos.disco_genero', 'LIKE', '%'.$query."%")->
                        where('galerias.tipo', 'music');
                    })->

                    //where('discografica_generos.disco_genero', 'LIKE', '%'.$query."%")->
                    //orwhere('discografica_generos.disco_genero', 'LIKE', '%'.$query."%")->

                    where('player_musicas.user_id', auth()->user()->id)->paginate(4);

                    return view('admin.music.table.pagination_data', compact('musics'))->render();
        }


                    //orderBy('player_musicas.user_id', 'DESC')->get();
        //$datas = DB::select("SELECT galerias.id AS galerias_id, users.name AS nome_user, discografias.genero, galerias.url, galerias.nome_arquivos, player_musicas.user_id FROM player_musicas INNER JOIN galerias on galerias.imageble_id = player_musicas.id INNER JOIN users on users.id = player_musicas.user_id INNER JOIN discografias on discografias.id = player_musicas.discografia_id WHERE galerias.nome_arquivos LIKE '%$request->search%' OR discografias.genero LIKE '%$request->search%' AND player_musicas.user_id = ".auth()->user()->id);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $discografias = DB::select('SELECT discografias.id, discografica_generos.disco_genero, discografias.album, discografias.nome_album
        FROM discografias
        INNER JOIN discografica_generos ON discografica_generos.id = discografias.discografica_genero_id
        WHERE discografias.id
        NOT IN (SELECT player_musicas.discografia_id FROM player_musicas)
        AND discografias.user_id = '. auth()->user()->id);

        //dd($discografias);



        return view('admin.music.create', compact('discografias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->file('image'));
        $request->validate([
            'user_id' => 'required',
            'discografia_id' => 'required'
        ]);
        $tc = new TratarCaracteres();
        $urlImages = [];

        if($request->file('image')){ // Criptografando a Image
            $extensoes = array(".mp3");
            foreach ($request->file('image') as $image) {
                if (!in_array(strtolower(strrchr($image->getClientOriginalName(), ".")), $extensoes)) {
                    $msg = array(
                        "msg" => "Extensão Inválida!!! - Somente .mp3 será possível ser salva."
                    );
                    return redirect()->back()->withErrors( $msg )->withInput();
                }

                $numero = time().$tc->nomeSlug($image->getClientOriginalName());

                $rotaDeFuga = public_path().'/images/play_music';
                $image->move($rotaDeFuga, $numero);
                //$urlImages[]['url'] = '/images/play_music/'.$numero;
                $urlImages[] = [
                    'url' => '/images/play_music/'.$numero,
                    'nome_arquivos' => ucwords(strtolower(str_replace($extensoes, "" , $image->getClientOriginalName() ))),
                    'tipo' => 'music'
                ];
            }
        } else {
            $msg = array(
                "msg" => "Impossivel cadastrar 0(zero) músicas."
            );
            return redirect()->back()->withErrors( $msg )->withInput();
        }

        $music = new Player_musica();
        $music->user_id = $request->user_id;
        $music->discografia_id = $request->discografia_id;
        $music->nome_musica = $request->user_id;

        //dd($urlImages);
        $music->save();
        $music->image()->createMany($urlImages);
        return redirect()->route('music.index')->with('info', "Cadastrado Corretamente");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Player_musica  $player_musica
     * @return \Illuminate\Http\Response
     */
    public function show(Player_musica $player_musica)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Player_musica  $player_musica
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $galerias = Player_musica::where('id', $id)->firstOrFail();

        return view('admin.galerias.edit', compact('galerias'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Player_musica  $player_musica
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Player_musica $player_musica)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Player_musica  $player_musica
     * @return \Illuminate\Http\Response
     */
    public function destroy(Player_musica $player_musica)
    {
        //
    }
}
