<?php

namespace App\Http\Controllers;

use App\Discografia;
use App\Discografica_generos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiscografiaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discos = Discografia::select("discografias.id AS id", "discografias.user_id", "discografica_generos.disco_genero", "discografias.nome_album" ,"discografias.album")->
        join('discografica_generos', 'discografica_generos.id', '=', 'discografias.discografica_genero_id')->
        where('discografias.user_id', auth()->user()->id)->paginate(10);
        //dd($discos);
        return view('admin.discografia.index', compact('discos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($msg = null)
    {
        $discos_genero = Discografica_generos::all(); //DB::select('select * from discografica_generos');
        //dd($discos_genero);
        return view('admin.discografia.create', compact('discos_genero'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|numeric',
            'discografica_genero_id' => 'required|numeric',
            'nome_album' => 'required|max:125',
            'album' => 'required|numeric'
        ]);

        $albumExistente =
        DB::select('SELECT discografica_generos.id, discografica_generos.disco_genero FROM discografias INNER JOIN discografica_generos ON discografica_generos.id = discografias.discografica_genero_id WHERE discografias.album = ? AND discografica_generos.id = ? ', [$request->album, $request->discografica_genero_id]);

        if($albumExistente){
            $msg = array(
                "msg" => "Album Já existente."
            );
            return redirect()->back()->withErrors( $msg )->withInput();
        }

        if($request->user_id != auth()->user()->id) {
            $msg = array(
                "msg" => "Usuário Inválido."
            );
            return redirect()->back()->withErrors( $msg )->withInput();
        }

        $disco = new Discografia();
        $disco->user_id = $request->user_id;
        $disco->discografica_genero_id = $request->discografica_genero_id;
        $disco->nome_album = ucwords(strtolower($request->nome_album));
        $disco->album = $request->album;
        $disco->save();
        return redirect()->route('discografia.index')->with('info', "Cadastrado Corretamente");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Discografia  $discografia
     * @return \Illuminate\Http\Response
     */
    public function show(Discografia $discografia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Discografia  $discografia
     * @return \Illuminate\Http\Response
     */
    public function edit(Discografia $discografia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Discografia  $discografia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Discografia $discografia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Discografia  $discografia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Discografia $discografia)
    {
        //
    }
}
