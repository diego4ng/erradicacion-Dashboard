<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Register;
use App\Models\Admin\Novedades;
use App\Models\Admin\Estado;
use App\Models\Admin\Aseguramientos;
use App\Models\Admin\ValidationDasboard;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        session()->forget('filtrado'); //Sirve para mostrar un tipo de paginado diferente
        $datas = Register::with(['plantios','estado','municipio','localidad','dependencia','plantios.tipoPlantio','plantios.presentacion','caracteristicas.metodoErradicacion','caracteristicas.manejoCultural','coordenada_central','validacion_dashboard','validacion_dashboard.usuario_validador'])->orderBy('f_t_captura','ASC')->paginate();
        $catalogo_novedades = Novedades::orderBy('c_i_novedad')->pluck('d_v_novedad', 'c_i_novedad')->toArray();
        $catalogo_estados = Estado::orderBy('ID_ESTADO')->pluck('NOMBRE', 'ID_ESTADO');
        $catalogo_aseguramientos = Aseguramientos::orderBy('c_i_aseguramiento')->pluck('d_v_aseguramiento', 'c_i_aseguramiento');
        return view('admin.register.index', compact('datas','catalogo_novedades','catalogo_aseguramientos','catalogo_estados'));
    }

    public function register_filter(Request $request)
    {
        date_default_timezone_set('America/Mexico_City');
        session(['filtrado' => 1]); //Sirve para mostrar un tipo de paginado diferente
        $fecha_inicial = $request['startDate'];
        $fecha_final = $request['endDate'];
        $catalogo_estados = Estado::orderBy('ID_ESTADO')->pluck('NOMBRE', 'ID_ESTADO')->toArray();
        $fecha = date($fecha_final);
        $nuevafecha = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
        $nuevafechafinal = date ( 'Y-m-j' , $nuevafecha );
        $today = date('Y-m-d');

        if(!empty($request['validacion'])){
            if($request['validacion']==1){
                $id_eventos_validados = ValidationDasboard::pluck('id_evento','id')->toArray();
            }else
            if ($request['validacion']==2) {
                $id_eventos_validados = ValidationDasboard::where('estatus_validacion', 2)
                ->pluck('id_evento', 'id')
                ->toArray();
            }else{
                $id_eventos_validados = ValidationDasboard::where('estatus_validacion', 3)
                ->pluck('id_evento', 'id')
                ->toArray();
            }
        }

        if (!empty($request['estado_ids'])) {

            if (($today>$fecha_inicial) && ($fecha_inicial <= $fecha_final)) {

                $datas = Register::with(['estado','municipio','localidad','dependencia','plantios.tipoPlantio','plantios.presentacion','caracteristicas.metodoErradicacion','caracteristicas.manejoCultural','coordenada_central','plantios','validacion_dashboard'])
                ->whereIn('c_i_estado', $request['estado_ids'])
                ->where('f_t_registro', '>=', $fecha_inicial)
                ->where('f_t_registro', '<=', $nuevafechafinal);
                if(!empty($request['validacion'])){
                    if($request['validacion']==1){
                        $datas->whereNotIn('c_v_evento',$id_eventos_validados);
                    }else
                    if ($request['validacion']==2) {
                        $datas->whereIn('c_v_evento',$id_eventos_validados);
                    }else
                    if ($request['validacion']==3) {
                        $datas->whereIn('c_v_evento',$id_eventos_validados);
                    }
                }

                $datas = $datas->get();

            } else {

                $datas = Register::with(['estado','municipio','localidad','dependencia','plantios.tipoPlantio','plantios.presentacion','caracteristicas.metodoErradicacion','caracteristicas.manejoCultural','coordenada_central','plantios','validacion_dashboard'])
                ->whereIn('c_i_estado', $request['estado_ids']);
                if(!empty($request['validacion'])){
                    if($request['validacion']==1){
                        $datas->whereNotIn('c_v_evento',$id_eventos_validados);
                    }else
                    if ($request['validacion']==2) {
                        $datas->whereIn('c_v_evento',$id_eventos_validados);
                    }else
                    if ($request['validacion']==3) {
                        $datas->whereIn('c_v_evento',$id_eventos_validados);
                    }
                }

                $datas = $datas->get();
            }

        } else
        if (($today>$fecha_inicial) && ($fecha_inicial <= $fecha_final)) {

            $datas = Register::with(['estado','municipio','localidad','dependencia','plantios.tipoPlantio','plantios.presentacion','caracteristicas.metodoErradicacion','caracteristicas.manejoCultural','coordenada_central','plantios','validacion_dashboard'])
            ->where('f_t_registro', '>=', $fecha_inicial)
            ->where('f_t_registro', '<=', $nuevafechafinal);
            if(!empty($request['validacion'])){
                if($request['validacion']==1){
                    $datas->whereNotIn('c_v_evento',$id_eventos_validados);
                }else
                if ($request['validacion']==2) {
                    $datas->whereIn('c_v_evento',$id_eventos_validados);
                }else
                if ($request['validacion']==3) {
                    $datas->whereIn('c_v_evento',$id_eventos_validados);
                }
            }

            $datas = $datas->get();
        } else {

            $datas = Register::with(['estado','municipio','localidad','dependencia','plantios.tipoPlantio','plantios.presentacion','caracteristicas.metodoErradicacion','caracteristicas.manejoCultural','coordenada_central','plantios','validacion_dashboard']);
            if(!empty($request['validacion'])){
                if($request['validacion']==1){
                    $datas->whereNotIn('c_v_evento',$id_eventos_validados);
                }else
                if ($request['validacion']==2) {
                    $datas->whereIn('c_v_evento',$id_eventos_validados);
                }else
                if ($request['validacion']==3) {
                    $datas->whereIn('c_v_evento',$id_eventos_validados);
                }
            }

            $datas = $datas->get();
        }

        $catalogo_novedades = Novedades::orderBy('c_i_novedad')->pluck('d_v_novedad', 'c_i_novedad')->toArray();
        $catalogo_aseguramientos = Aseguramientos::orderBy('c_i_aseguramiento')->pluck('d_v_aseguramiento', 'c_i_aseguramiento')->toArray();
        return view('admin.register.index', compact('datas','catalogo_novedades','catalogo_aseguramientos','catalogo_estados'));
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
        $datas = Register::with(['plantios','estado','municipio','localidad','dependencia','plantios.tipoPlantio','plantios.presentacion','caracteristicas.metodoErradicacion','caracteristicas.manejoCultural','coordenada_central'])->where('c_v_evento',$id)->get()->toArray();
        $catalogo_novedades = Novedades::orderBy('c_i_novedad')->pluck('d_v_novedad', 'c_i_novedad')->toArray();
        return view('admin.register.show', compact('datas','catalogo_novedades'));
    }

    public function registers_map()
    {
        session()->forget('filtrado');
        $datas = Register::with(['plantios','estado','municipio','localidad','dependencia','plantios.tipoPlantio','plantios.presentacion','caracteristicas.metodoErradicacion','caracteristicas.manejoCultural','coordenada_central','coordenadas'])->orderBy('f_t_captura','ASC')->paginate();
        $catalogo_estados = Estado::orderBy('ID_ESTADO')->pluck('NOMBRE', 'ID_ESTADO')->toArray();
        return view('admin.register.registers_map', compact('datas','catalogo_estados'));
    }

    public function registers_map_filter(Request $request)
    {
        date_default_timezone_set('America/Mexico_City');
        session(['filtrado' => 1]);
        $fecha_inicial = $request['startDate'];
        $fecha_final = $request['endDate'];
        $fecha = date($fecha_final);
        $nuevafecha = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
        $nuevafechafinal = date ( 'Y-m-j' , $nuevafecha );
        $today = date('Y-m-d');
        $catalogo_estados = Estado::orderBy('ID_ESTADO')->pluck('NOMBRE', 'ID_ESTADO')->toArray();

        if(!empty($request['validacion'])){
            if($request['validacion']==1){
                $id_eventos_validados = ValidationDasboard::pluck('id_evento','id')->toArray();
            }else
            if ($request['validacion']==2) {
                $id_eventos_validados = ValidationDasboard::where('estatus_validacion', 2)
                ->pluck('id_evento', 'id')
                ->toArray();
            }else{
                $id_eventos_validados = ValidationDasboard::where('estatus_validacion', 3)
                ->pluck('id_evento', 'id')
                ->toArray();
            }
        }

        if (isset($request['estado_ids'])) {

            if (($today>$fecha_inicial) && ($fecha_inicial <= $fecha_final)) {
                $datas = Register::with(['estado','municipio','localidad','dependencia','plantios.tipoPlantio','plantios.presentacion','caracteristicas.metodoErradicacion','caracteristicas.manejoCultural','coordenada_central','plantios','coordenadas'])
                ->whereIn('c_i_estado', $request['estado_ids'])
                ->where('f_t_registro', '>=', $fecha_inicial)
                ->where('f_t_registro', '<=', $nuevafechafinal);
                if(!empty($request['validacion'])){
                    if($request['validacion']==1){
                        $datas->whereNotIn('c_v_evento',$id_eventos_validados);
                    }else
                    if ($request['validacion']==2) {
                        $datas->whereIn('c_v_evento',$id_eventos_validados);
                    }else
                    if ($request['validacion']==3) {
                        $datas->whereIn('c_v_evento',$id_eventos_validados);
                    }
                }

                $datas = $datas->get();
            } else {
                $datas = Register::with(['estado','municipio','localidad','dependencia','plantios.tipoPlantio','plantios.presentacion','caracteristicas.metodoErradicacion','caracteristicas.manejoCultural','coordenada_central','plantios','coordenadas'])
                ->whereIn('c_i_estado', $request['estado_ids']);
                if(!empty($request['validacion'])){
                    if($request['validacion']==1){
                        $datas->whereNotIn('c_v_evento',$id_eventos_validados);
                    }else
                    if ($request['validacion']==2) {
                        $datas->whereIn('c_v_evento',$id_eventos_validados);
                    }else
                    if ($request['validacion']==3) {
                        $datas->whereIn('c_v_evento',$id_eventos_validados);
                    }
                }

                $datas = $datas->get();
            }

        } else {

            if (($today>$fecha_inicial) && ($fecha_inicial <= $fecha_final)) {
                $datas = Register::with(['estado','municipio','localidad','dependencia','plantios.tipoPlantio','plantios.presentacion','caracteristicas.metodoErradicacion','caracteristicas.manejoCultural','coordenada_central','plantios','coordenadas'])
                ->where('f_t_registro', '>=', $fecha_inicial)
                ->where('f_t_registro', '<=', $nuevafechafinal);
                if(!empty($request['validacion'])){
                    if($request['validacion']==1){
                        $datas->whereNotIn('c_v_evento',$id_eventos_validados);
                    }else
                    if ($request['validacion']==2) {
                        $datas->whereIn('c_v_evento',$id_eventos_validados);
                    }else
                    if ($request['validacion']==3) {
                        $datas->whereIn('c_v_evento',$id_eventos_validados);
                    }
                }

                $datas = $datas->get();
            } else {
                $datas = Register::with(['estado','municipio','localidad','dependencia','plantios.tipoPlantio','plantios.presentacion','caracteristicas.metodoErradicacion','caracteristicas.manejoCultural','coordenada_central','plantios','coordenadas']);
                if(!empty($request['validacion'])){
                    if($request['validacion']==1){
                        $datas->whereNotIn('c_v_evento',$id_eventos_validados);
                    }else
                    if ($request['validacion']==2) {
                        $datas->whereIn('c_v_evento',$id_eventos_validados);
                    }else
                    if ($request['validacion']==3) {
                        $datas->whereIn('c_v_evento',$id_eventos_validados);
                    }
                }

                $datas = $datas->get();
            }

        }

        return view('admin.register.registers_map', compact('datas','catalogo_estados'));
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
