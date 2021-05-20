<?php

namespace App\Http\Controllers;

use App\Agenda;
use Illuminate\Http\Request;

class AgendaController extends Controller
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
        $agendas = Agenda::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->paginate(10);
        return view('admin.agenda.index', compact('agendas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.agenda.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        $request->validate([
            'user_id' => 'required',
            'data' => 'required',
            'hora' => 'required',
            'estado' => 'required',
            'cidade' => 'required',
            'cep' => 'required',
            'rua' => 'required',
            'bairro' => 'required',
            'ibge' => 'required'
        ]);




        $agenda = new Agenda();
        $agenda->user_id = $request->user_id;
        $agenda->data = $request->data;
        $agenda->hora = $request->hora;
        $agenda->estado = $request->estado;
        $agenda->cidade = $request->cidade;
        $agenda->cep = $request->cep;
        $agenda->rua = $request->rua;
        $agenda->bairro = $request->bairro;
        $agenda->ibge = $request->ibge;
        $agenda->save();
        return redirect()->route('agenda.index')->with('info', "Cadastrado Corretamente");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Agenda  $agenda
     * @return \Illuminate\Http\Response
     */
    public function show(Agenda $agenda)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Agenda  $agenda
     * @return \Illuminate\Http\Response
     */
    public function edit(Agenda $agenda)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Agenda  $agenda
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Agenda $agenda)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Agenda  $agenda
     * @return \Illuminate\Http\Response
     */
    public function destroy(Agenda $agenda)
    {
        //
    }
}
