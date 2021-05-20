<?php

namespace App\Http\Controllers;

use App\Discografia;
use App\Discografica_generos;
use App\Galeria;
use App\Http\TratarCaracteres;
use App\ImagensGalerias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImagensGaleriasController extends Controller
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
        //$products = ;
        if (ImagensGalerias::find(auth()->user()->id)) {
            $disco = DB::select("SELECT disco.id, dg.disco_genero, disco.album
                        FROM imagens_galerias img
                        INNER JOIN discografias disco on disco.id = img.discografia_id
                        INNER JOIN users on users.id = img.user_id
                        INNER JOIN discografica_generos dg on dg.id = disco.discografica_genero_id
                        WHERE img.user_id = " . auth()->user()->id);

            $products = DB::select("SELECT galerias.id, galerias.url, discografica_generos.disco_genero, discografias.album, galerias.nome_arquivos
                        FROM imagens_galerias
                        INNER JOIN galerias on galerias.imageble_id = imagens_galerias.id
                        INNER JOIN discografias on discografias.id = imagens_galerias.discografia_id
                        INNER JOIN discografica_generos on discografica_generos.id = discografias.discografica_genero_id
                        WHERE galerias.tipo = 'image'
                        AND imagens_galerias.user_id = " . auth()->user()->id);

            //$products = ImagensGalerias::where('user_id', auth()->user()->id)->get();
            //dd($products);
            return view('admin.galerias.index', compact('products', "disco"));
        } else {
            return $this->create();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$discografias = Discografia::all()->where('user_id', auth()->user()->id);
        $discografias = DB::select('SELECT discografias.id, discografica_generos.disco_genero, discografias.album, discografias.nome_album
        FROM discografias
        INNER JOIN discografica_generos ON discografica_generos.id = discografias.discografica_genero_id
        WHERE discografias.id
        NOT IN (SELECT imagens_galerias.discografia_id FROM imagens_galerias)
        AND discografias.user_id = ' . auth()->user()->id);

        // SELECT * FROM discografica_generos WHERE discografica_generos.id NOT IN ( SELECT discografias.discografica_genero_id FROM discografias)

        if(empty($discografias)){
            $discografiaController = new DiscografiaController();
            return $discografiaController->create();
        }



        //$discografias = Discografia::select('discografias.id', 'discografica_generos.disco_genero')->join('discografica_generos', 'discografica_generos.id', '=', 'discografias.discografica_genero_id')->where('discografias.user_id', auth()->user()->id);
        return view('admin.galerias.create', compact('discografias'));
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
            'user_id' => 'required',
            'discografia_id' => 'required'
        ]);
        //dd($request);
        $tc = new TratarCaracteres();
        $urlImages = [];
        if ($request->hasFile('image')) { // Criptografando a Image
            $extensoes = array(".png", ".jpg");
            foreach ($request->file('image') as $image) {
                if (!in_array(strtolower(strrchr($image->getClientOriginalName(), ".")), $extensoes)) {
                    $msg = array(
                        "msg" => "Extensão Inválida!!! - Somente .jpg ou .png será possível ser salva."
                    );
                    return redirect()->back()->withErrors($msg)->withInput();
                }
                $numero = time() . $tc->nomeSlug($image->getClientOriginalName());

                $rotaDeFuga = public_path() . '/images/galeria';
                $image->move($rotaDeFuga, $numero);
                $urlImages[] = [
                    'url' => '/images/galeria/' . $numero,
                    'nome_arquivos' => $request->discografia_id,
                    'tipo' => 'image'
                ];
            }
        } else {
            dd($request->hasFile('image'));
            $msg = array(
                "msg" => "Impossivel cadastrar 0(zero) imagem."
            );
            return redirect()->back()->withErrors($msg)->withInput();
        }
        $img = new ImagensGalerias();
        $img->user_id = $request->user_id;
        $img->discografia_id = $request->discografia_id;

        $img->save();
        $img->image()->createMany($urlImages);
        return redirect()->route('galerias.index')->with('info', "Cadastrado Corretamente");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ImagensGalerias  $imagensGalerias
     * @return \Illuminate\Http\Response
     */
    public function show(ImagensGalerias $imagensGalerias)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ImagensGalerias  $imagensGalerias
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $galerias = ImagensGalerias::where('id', $id)->firstOrFail();

        return view('admin.galerias.edit', compact('galerias'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ImagensGalerias  $imagensGalerias
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required'
        ]);
        $tc = new TratarCaracteres();
        $urlImages = [];
        if ($request->hasFile('image')) { // Criptografando a Image
            $extensoes = array(".png", ".jpg");

            foreach ($request->file('image') as $image) {
                if (!in_array(strtolower(strrchr($image->getClientOriginalName(), ".")), $extensoes)) {
                    $msg = array(
                        "msg" => "Extensão Inválida!!! - Somente .jpg ou .png será possível ser salva."
                    );
                    return redirect()->back()->withErrors($msg)->withInput();
                }
                $numero = time() . $tc->nomeSlug($image->getClientOriginalName());

                $rotaDeFuga = public_path() . '/images/galeria';
                $image->move($rotaDeFuga, $numero);
                $urlImages[]['url'] = '/images/galeria/' . $numero;
            }
        } else {
            $msg = array(
                "msg" => "Impossivel cadastrar 0(zero) imagem."
            );
            return redirect()->back()->withErrors($msg)->withInput();
        }
        $img = ImagensGalerias::findOrFail($id);
        $img->user_id = $request->user_id;

        $img->save();
        if ($request->hasFile('image')) {
            $img->image()->createMany($urlImages);
        }
        return redirect()->route('galerias.index')->with('info', "Cadastrado Corretamente");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ImagensGalerias  $imagensGalerias
     * @return \Illuminate\Http\Response
     */
    public function destroy(ImagensGalerias $imagensGalerias)
    {
        //
    }
}
