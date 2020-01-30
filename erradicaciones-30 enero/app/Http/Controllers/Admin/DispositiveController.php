<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Dispositive;
use App\Models\Admin\Estado;
use App\Models\Admin\Municipio;
use App\Models\Admin\Localidad;
use App\Models\Admin\Asignation;
use App\Models\Admin\Dependencia;

class DispositiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = Dispositive::with(['asignacion','dependencia','eventos','municipio','localidad'])->orderBy('id','desc')->get();
        return view('admin.dispositive.index', compact('datas'));
    }

    public function dispositives_filter(Request $request)
    {
        //$datas = Dispositive::with(['asignacion','dependencia','eventos','municipio','localidad'])->where('f_t_captura', '>=', $fecha_inicial)->where('f_t_captura', '<=', $nuevafechafinal)->orderBy('id')->get()->toArray();
        //return view('admin.dispositive.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $catalogo_estados = Estado::orderBy('ID_ESTADO')->pluck('NOMBRE', 'ID_ESTADO');
        $catalogo_asignacion = Asignation::orderBy('id')->pluck('descripcion', 'id');
        $catalogo_dependencia = Dependencia::orderBy('c_i_dependencia')->pluck('d_v_dependencia', 'c_i_dependencia');

        return view('admin.dispositive.create',compact('catalogo_estados','catalogo_asignacion','catalogo_dependencia'));
    }

    public function findAjax(Request $request, $id)
    {
        if ($request->ajax()) {
            $catalogo_municipio = Municipio::where('ID_ESTADO', '=', $id)
            ->orderBy('NOMBRE')
            ->pluck('NOMBRE', 'ID_MUNICIPIO');
            return response()->json($catalogo_municipio);
        } else {
            return response()->json(['mensaje' => 'ng']);
        }
    }

    public function findLocalidadesAjax(Request $request, $id)
    {
        if ($request->ajax()) {
            $catalogo_localidad = Localidad::where('ID_MUNICIPIO', '=', $id)
            ->orderBy('NOMBRE')
            ->pluck('NOMBRE', 'ID_LOCALIDAD');
            return response()->json($catalogo_localidad);
        } else {
            return response()->json(['mensaje' => 'ng']);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Dispositive::create($request->all());
        return redirect('admin/dispositive')->with('mensaje', 'Dispositivo creado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $data = Dispositive::with(['asignacion','dependencia','entidad','municipio','localidad','eventos','eventos.estado','eventos.municipio','eventos.localidad'])->findOrFail($id)->toArray();
        return view('admin.dispositive.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Dispositive::findOrFail($id); //Arroja 404 y no un null
        $catalogo_estados = Estado::orderBy('ID_ESTADO')->pluck('NOMBRE', 'ID_ESTADO');
        $catalogo_asignacion = Asignation::orderBy('id')->pluck('descripcion', 'id');
        $catalogo_dependencia = Dependencia::orderBy('c_i_dependencia')->pluck('d_v_dependencia', 'c_i_dependencia');

        return view('admin.dispositive.edit',compact('data','catalogo_estados','catalogo_asignacion','catalogo_dependencia'));

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
        Dispositive::findOrFail($id)->update($request->all());
        return redirect('admin/dispositive/'.$id.'/show')->with('mensaje', 'Dispositivo actializada con éxito');
    }

    public function updateObservation(Request $request, $id)
    {
        Dispositive::findOrFail($id)->update($request->all());
        return redirect('admin/dispositive/'.$id.'/show')->with('mensaje', 'Observación actializada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            if (Dispositive::destroy($id)) {
                return response()->json(['mensaje' => 'ok']);
            } else {
                return response()->json(['mensaje' => 'ng']);
            }
        } else {
            abort(404);
        }
    }
}
