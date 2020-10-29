<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Funcionario;
use App\Models\FuncionarioDocumento;

class FuncionariosDocumentosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store($identidad)
    {
        $funcionario = Funcionario::where('identidad',$identidad)->firstOrFail();


        if (request('file')->isvalid()) {

            $documento = request('file');
            $nombre = $documento->getClientOriginalName();
            $datos = $documento->storeAs('documentos', $nombre,'public');

        }

        $funcionarioDocumento = new FuncionarioDocumento();
        $funcionarioDocumento->nombre_documento = $datos;

        $funcionarioDocumento->funcionario_id = $funcionario->id;

        $funcionarioDocumento->save();
            
        return response()->json(['message' => 'Documento subido y creado correctamente'], 200);
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
