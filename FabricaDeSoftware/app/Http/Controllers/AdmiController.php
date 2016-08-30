<?php

namespace Fabrica\Http\Controllers;

use Illuminate\Http\Request;

use Fabrica\Http\Requests;
use Fabrica\Usuario;
use Fabrica\tipo;
use Fabrica\Area;
use Fabrica\Investigacion;

class AdmiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vista=view("Admi.principal");
        return $vista;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function mostrarTiposUsuario(){
        $vista=view('Usuario.tiposUsuarios');
        return $vista;
    }
    public function verFormulario(){
        $tipos=tipo::All();
        $areas=Area::all();
        $modo="registrar";
        $vista=view('Usuario.crear',['tipos'=>$tipos,
                                        'areas'=>$areas,
                                        'modo'=>$modo]);
        return $vista;
    }
    public function verFormularioInvestigacion(){
        $areas=Area::select('id','nombre')->get();
        $vista=view('Investigacion.nuevainvestigacion',["areas"=>$areas]);
        return $vista;
    }
    public function listar($personal){
        $usuarios=Usuario::join('personal','usuario.id','=','personal.usuario_id')
            ->join('tipo','tipo.id','=','personal.tipo_id')
            ->select('usuario.id', 'usuario.nombre as Nombre',
                'usuario.correo as Correo',
                'usuario.carrera as Carrera',
                'usuario.cargo as Cargo',
                'usuario.foto')
            ->where('nombre_tipo','=',$personal)
            ->get();
        $vista=view("Usuario.lista",['usuarios'=>$usuarios]);
        return $vista;
    }
    public function listarInvestigaciones(){
        $investigaciones=Investigacion::All();
        $vista=view('Investigacion.lista',['investigaciones'=>$investigaciones]);
        return $vista;
    }
    public function verGalerias(){
        $vista=view('Multimedia.galeria');
        return $vista;
    }
    public function verFormularioGaleria($form){
        $vista=view('Multimedia.formulario');
        return $vista;
    }
}
