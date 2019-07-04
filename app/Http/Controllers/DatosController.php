<?php

namespace App\Http\Controllers;

use App\Datos;
use Illuminate\Http\Request;
use App\Http\Requests\DatosStoreRequest;

class DatosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar==''){
            $datos = Datos::orderBy('id', 'desc')->paginate(10);
        }
        else{
            $datos = Datos::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(10);
        }
        return [
            'pagination' => [
                'total'        => $datos->total(),
                'current_page' => $datos->currentPage(),
                'per_page'     => $datos->perPage(),
                'last_page'    => $datos->lastPage(),
                'from'         => $datos->firstItem(),
                'to'           => $datos->lastItem(),
            ],
            'datos' => $datos
        ];
        //dd($datos);
    }

    public function general(Request $request)
    {
        $datos=Datos::orderBy('id','DESC')->paginate(5);
        // dd($datos);
        return view('datos_table',compact('datos'));
    }

    public function edit($id)
    {
        $dato = Datos::find($id);

        //dd($dato);

        return view('form_actualizar', compact('dato'));
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
    public function store(DatosStoreRequest $request)
    {
        if (!$request->ajax()) return redirect('/');
        $datos = new Datos();
        $datos->nom = $request->nom;
        $datos->ap = $request->ap;
        $datos->am = $request->am;
        $datos->condicion = '1';
        $datos->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Datos  $datos
     * @return \Illuminate\Http\Response
     */
    public function show(Datos $datos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Datos  $datos
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Datos  $datos
     * @return \Illuminate\Http\Response
     */
    public function update(DatosStoreRequest $request, Datos $datos)
    {
        if (!$request->ajax()) return redirect('/');
        $datos = Datos::findOrFail($request->id);
        $datos->nom = $request->nom;
        $datos->ap = $request->ap;
        $datos->am = $request->am;
        $datos->condicion = '1';
        $datos->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Datos  $datos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Datos $datos)
    {
        //
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $datos = Datos::findOrFail($request->id);
        $datos->condicion = '0';
        $datos->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $datos = Datos::findOrFail($request->id);
        $datos->condicion = '1';
        $datos->save();
    }

}
