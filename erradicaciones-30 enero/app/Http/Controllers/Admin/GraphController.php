<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Plantio;
use App\Models\Admin\TipoPlantio;
use App\Models\Admin\Presentacion;
use App\Models\Admin\Estado;
use App\Models\Admin\Register;
use App\Models\Admin\Dependencia;
use App\Models\Admin\ValidationDasboard;
use Illuminate\Support\Facades\DB;

class GraphController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data_plantios = Plantio::
            with(['tipoPlantio'])
            ->select('c_i_tplantio', DB::raw('COUNT(c_i_tplantio) as count'))
            ->groupBy('c_i_tplantio')
            ->orderBy('count', 'desc')
            ->get()
            ->toArray();

        $data_presentacion = Plantio::
            with(['presentacion'])
            ->select('c_i_presentacion', DB::raw('COUNT(c_i_presentacion) as count'))
            ->groupBy('c_i_presentacion')
            ->orderBy('count', 'desc')
            ->get()
            ->toArray();

        $data_area = Plantio::
            with(['areaErradicada'])
            ->select('c_v_evento','c_i_tplantio')
            ->get()
            ->toArray();

        $data_institucion_erradica = Plantio::
            with(['institucion_erradica'])
            //->select('c_v_evento','institución_erradica.c_i_dependencia')
            ->get()
            ->toArray();

        $catalogo_estados = Estado::orderBy('ID_ESTADO')->pluck('NOMBRE', 'ID_ESTADO')->toArray();
        $tipos_plantio = TipoPlantio::orderBy('c_i_tplantio')->pluck('d_v_tplantio', 'c_i_tplantio')->toArray();
        $tipos_presentacion = Presentacion::orderBy('c_i_presentacion')->pluck('d_v_presentacion', 'c_i_presentacion')->toArray();
        $tipos_institucion = Dependencia::orderBy('c_i_dependencia')->pluck('d_v_dependencia', 'c_i_dependencia')->toArray();

        return view('admin.graphs.graph', compact('data_plantios','data_presentacion','data_area','tipos_plantio','catalogo_estados','data_institucion_erradica','tipos_institucion'));
    }

    public function graph_filter(Request $request)
    {
        date_default_timezone_set('America/Mexico_City');
        $fecha_inicial = $request['startDate'];
        $fecha_final = $request['endDate'];
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

        if (isset($request['estado_ids'])) {

            if (($today>$fecha_inicial) && ($fecha_inicial <= $fecha_final)) {
                //Busca los ID de los eventos con los estados solicitados y el rango de fechas seleccionados
                //además de condicionarle que seleccione solo los eventos de algún tipo de validación si así fue seleccionado
                $id_eventos = Register::whereIn('c_i_estado', $request['estado_ids'])
                ->where('f_t_registro', '>=', $fecha_inicial)
                ->where('f_t_registro', '<=', $nuevafechafinal);
                if(!empty($request['validacion'])){
                    if($request['validacion']==1){
                        $id_eventos->whereNotIn('c_v_evento',$id_eventos_validados);
                    }else
                    if ($request['validacion']==2) {
                        $id_eventos->whereIn('c_v_evento',$id_eventos_validados);
                    }else
                    if ($request['validacion']==3) {
                        $id_eventos->whereIn('c_v_evento',$id_eventos_validados);
                    }
                }
                $id_eventos = $id_eventos->get('c_v_evento')->toArray();

                $data_plantios = Plantio::
                    with(['tipoPlantio'])
                    ->select('c_i_tplantio', DB::raw('COUNT(c_i_tplantio) as count'))
                    ->groupBy('c_i_tplantio')
                    ->orderBy('c_i_tplantio', 'asc')
                    ->where('f_t_registro', '>=', $fecha_inicial)
                    ->where('f_t_registro', '<=', $nuevafechafinal)
                    ->whereIn('c_v_evento', $id_eventos);
                    if(!empty($request['validacion'])){
                        if($request['validacion']==1){
                            $data_plantios->whereNotIn('c_v_evento',$id_eventos_validados);
                        }else
                        if ($request['validacion']==2) {
                            $data_plantios->whereIn('c_v_evento',$id_eventos_validados);
                        }else
                        if ($request['validacion']==3) {
                            $data_plantios->whereIn('c_v_evento',$id_eventos_validados);
                        }
                    }
                    $data_plantios = $data_plantios->get()->toArray();

                $data_presentacion = Plantio::
                    with(['presentacion'])
                    ->select('c_i_presentacion', DB::raw('COUNT(c_i_presentacion) as count'))
                    ->groupBy('c_i_presentacion')
                    ->orderBy('c_i_presentacion', 'asc')
                    ->where('f_t_registro', '>=', $fecha_inicial)
                    ->where('f_t_registro', '<=', $nuevafechafinal)
                    ->whereIn('c_v_evento', $id_eventos);
                    if(!empty($request['validacion'])){
                        if($request['validacion']==1){
                            $data_presentacion->whereNotIn('c_v_evento',$id_eventos_validados);
                        }else
                        if ($request['validacion']==2) {
                            $data_presentacion->whereIn('c_v_evento',$id_eventos_validados);
                        }else
                        if ($request['validacion']==3) {
                            $data_presentacion->whereIn('c_v_evento',$id_eventos_validados);
                        }
                    }
                    $data_presentacion = $data_presentacion->get()->toArray();

                $data_area = Plantio::
                    with(['areaErradicada'])
                    ->select('c_v_evento','c_i_tplantio')
                    ->where('f_t_registro', '>=', $fecha_inicial)
                    ->where('f_t_registro', '<=', $nuevafechafinal)
                    ->whereIn('c_v_evento', $id_eventos);
                    if(!empty($request['validacion'])){
                        if($request['validacion']==1){
                            $data_area->whereNotIn('c_v_evento',$id_eventos_validados);
                        }else
                        if ($request['validacion']==2) {
                            $data_area->whereIn('c_v_evento',$id_eventos_validados);
                        }else
                        if ($request['validacion']==3) {
                            $data_area->whereIn('c_v_evento',$id_eventos_validados);
                        }
                    }
                    $data_area = $data_area->get()->toArray();

                $data_institucion_erradica = Plantio::
                    with(['institucion_erradica'])
                    ->where('f_t_registro', '>=', $fecha_inicial)
                    ->where('f_t_registro', '<=', $nuevafechafinal)
                    ->whereIn('c_v_evento', $id_eventos);
                    if(!empty($request['validacion'])){
                        if($request['validacion']==1){
                            $data_institucion_erradica->whereNotIn('c_v_evento',$id_eventos_validados);
                        }else
                        if ($request['validacion']==2) {
                            $data_institucion_erradica->whereIn('c_v_evento',$id_eventos_validados);
                        }else
                        if ($request['validacion']==3) {
                            $data_institucion_erradica->whereIn('c_v_evento',$id_eventos_validados);
                        }
                    }
                    $data_institucion_erradica = $data_institucion_erradica->get()->toArray();
            }else{
                $id_eventos = Register::whereIn('c_i_estado', $request['estado_ids']);
                if(!empty($request['validacion'])){
                    if($request['validacion']==1){
                        $id_eventos->whereNotIn('c_v_evento',$id_eventos_validados);
                    }else
                    if ($request['validacion']==2) {
                        $id_eventos->whereIn('c_v_evento',$id_eventos_validados);
                    }else
                    if ($request['validacion']==3) {
                        $id_eventos->whereIn('c_v_evento',$id_eventos_validados);
                    }
                }
                $id_eventos = $id_eventos->get('c_v_evento')->toArray();

                $data_plantios = Plantio::
                    with(['tipoPlantio'])
                    ->select('c_i_tplantio', DB::raw('COUNT(c_i_tplantio) as count'))
                    ->groupBy('c_i_tplantio')
                    ->orderBy('c_i_tplantio', 'asc')
                    ->whereIn('c_v_evento', $id_eventos);
                    if(!empty($request['validacion'])){
                        if($request['validacion']==1){
                            $data_plantios->whereNotIn('c_v_evento',$id_eventos_validados);
                        }else
                        if ($request['validacion']==2) {
                            $data_plantios->whereIn('c_v_evento',$id_eventos_validados);
                        }else
                        if ($request['validacion']==3) {
                            $data_plantios->whereIn('c_v_evento',$id_eventos_validados);
                        }
                    }
                    $data_plantios = $data_plantios->get()->toArray();

                $data_presentacion = Plantio::
                    with(['presentacion'])
                    ->select('c_i_presentacion', DB::raw('COUNT(c_i_presentacion) as count'))
                    ->groupBy('c_i_presentacion')
                    ->orderBy('c_i_presentacion', 'asc')
                    ->whereIn('c_v_evento', $id_eventos);
                    if(!empty($request['validacion'])){
                        if($request['validacion']==1){
                            $data_presentacion->whereNotIn('c_v_evento',$id_eventos_validados);
                        }else
                        if ($request['validacion']==2) {
                            $data_presentacion->whereIn('c_v_evento',$id_eventos_validados);
                        }else
                        if ($request['validacion']==3) {
                            $data_presentacion->whereIn('c_v_evento',$id_eventos_validados);
                        }
                    }
                    $data_presentacion = $data_presentacion->get()->toArray();

                $data_area = Plantio::
                    with(['areaErradicada'])
                    ->select('c_v_evento','c_i_tplantio')
                    ->whereIn('c_v_evento', $id_eventos);
                    if(!empty($request['validacion'])){
                        if($request['validacion']==1){
                            $data_area->whereNotIn('c_v_evento',$id_eventos_validados);
                        }else
                        if ($request['validacion']==2) {
                            $data_area->whereIn('c_v_evento',$id_eventos_validados);
                        }else
                        if ($request['validacion']==3) {
                            $data_area->whereIn('c_v_evento',$id_eventos_validados);
                        }
                    }
                    $data_area = $data_area->get()->toArray();

                $data_institucion_erradica = Plantio::
                    with(['institucion_erradica'])
                    ->whereIn('c_v_evento', $id_eventos);
                    if(!empty($request['validacion'])){
                        if($request['validacion']==1){
                            $data_institucion_erradica->whereNotIn('c_v_evento',$id_eventos_validados);
                        }else
                        if ($request['validacion']==2) {
                            $data_institucion_erradica->whereIn('c_v_evento',$id_eventos_validados);
                        }else
                        if ($request['validacion']==3) {
                            $data_institucion_erradica->whereIn('c_v_evento',$id_eventos_validados);
                        }
                    }
                    $data_institucion_erradica = $data_institucion_erradica->get()->toArray();
            }

        }else{
            if (($today>$fecha_inicial) && ($fecha_inicial <= $fecha_final)) {
                $data_plantios = Plantio::
                    with(['tipoPlantio'])
                    ->select('c_i_tplantio', DB::raw('COUNT(c_i_tplantio) as count'))
                    ->groupBy('c_i_tplantio')
                    ->orderBy('c_i_tplantio', 'asc')
                    ->where('f_t_registro', '>=', $fecha_inicial)
                    ->where('f_t_registro', '<=', $nuevafechafinal);
                    if(!empty($request['validacion'])){
                        if($request['validacion']==1){
                            $data_plantios->whereNotIn('c_v_evento',$id_eventos_validados);
                        }else
                        if ($request['validacion']==2) {
                            $data_plantios->whereIn('c_v_evento',$id_eventos_validados);
                        }else
                        if ($request['validacion']==3) {
                            $data_plantios->whereIn('c_v_evento',$id_eventos_validados);
                        }
                    }
                    $data_plantios = $data_plantios->get()->toArray();

                $data_presentacion = Plantio::
                    with(['presentacion'])
                    ->select('c_i_presentacion', DB::raw('COUNT(c_i_presentacion) as count'))
                    ->groupBy('c_i_presentacion')
                    ->orderBy('c_i_presentacion', 'asc')
                    ->where('f_t_registro', '>=', $fecha_inicial)
                    ->where('f_t_registro', '<=', $nuevafechafinal);
                    if(!empty($request['validacion'])){
                        if($request['validacion']==1){
                            $data_presentacion->whereNotIn('c_v_evento',$id_eventos_validados);
                        }else
                        if ($request['validacion']==2) {
                            $data_presentacion->whereIn('c_v_evento',$id_eventos_validados);
                        }else
                        if ($request['validacion']==3) {
                            $data_presentacion->whereIn('c_v_evento',$id_eventos_validados);
                        }
                    }
                    $data_presentacion = $data_presentacion->get()->toArray();

                $data_area = Plantio::
                    with(['areaErradicada'])
                    ->select('c_v_evento','c_i_tplantio')
                    ->where('f_t_registro', '>=', $fecha_inicial)
                    ->where('f_t_registro', '<=', $nuevafechafinal);
                    if(!empty($request['validacion'])){
                        if($request['validacion']==1){
                            $data_area->whereNotIn('c_v_evento',$id_eventos_validados);
                        }else
                        if ($request['validacion']==2) {
                            $data_area->whereIn('c_v_evento',$id_eventos_validados);
                        }else
                        if ($request['validacion']==3) {
                            $data_area->whereIn('c_v_evento',$id_eventos_validados);
                        }
                    }
                    $data_area = $data_area->get()->toArray();

                $data_institucion_erradica = Plantio::
                    with(['institucion_erradica'])
                    ->where('f_t_registro', '>=', $fecha_inicial)
                    ->where('f_t_registro', '<=', $nuevafechafinal);
                    if(!empty($request['validacion'])){
                        if($request['validacion']==1){
                            $data_institucion_erradica->whereNotIn('c_v_evento',$id_eventos_validados);
                        }else
                        if ($request['validacion']==2) {
                            $data_institucion_erradica->whereIn('c_v_evento',$id_eventos_validados);
                        }else
                        if ($request['validacion']==3) {
                            $data_institucion_erradica->whereIn('c_v_evento',$id_eventos_validados);
                        }
                    }
                    $data_institucion_erradica = $data_institucion_erradica->get()->toArray();

            }else{
                $data_plantios = Plantio::
                    with(['tipoPlantio'])
                    ->select('c_i_tplantio', DB::raw('COUNT(c_i_tplantio) as count'))
                    ->groupBy('c_i_tplantio')
                    ->orderBy('c_i_tplantio', 'asc');
                    if(!empty($request['validacion'])){
                        if($request['validacion']==1){
                            $data_plantios->whereNotIn('c_v_evento',$id_eventos_validados);
                        }else
                        if ($request['validacion']==2) {
                            $data_plantios->whereIn('c_v_evento',$id_eventos_validados);
                        }else
                        if ($request['validacion']==3) {
                            $data_plantios->whereIn('c_v_evento',$id_eventos_validados);
                        }
                    }

                    $data_plantios = $data_plantios->get()->toArray();

                $data_presentacion = Plantio::
                    with(['presentacion'])
                    ->select('c_i_presentacion', DB::raw('COUNT(c_i_presentacion) as count'))
                    ->groupBy('c_i_presentacion')
                    ->orderBy('c_i_presentacion', 'asc');
                    if(!empty($request['validacion'])){
                        if($request['validacion']==1){
                            $data_presentacion->whereNotIn('c_v_evento',$id_eventos_validados);
                        }else
                        if ($request['validacion']==2) {
                            $data_presentacion->whereIn('c_v_evento',$id_eventos_validados);
                        }else
                        if ($request['validacion']==3) {
                            $data_presentacion->whereIn('c_v_evento',$id_eventos_validados);
                        }
                    }

                    $data_presentacion = $data_presentacion->get()->toArray();

                $data_area = Plantio::
                    with(['areaErradicada'])
                    ->select('c_v_evento','c_i_tplantio');
                    if(!empty($request['validacion'])){
                        if($request['validacion']==1){
                            $data_area->whereNotIn('c_v_evento',$id_eventos_validados);
                        }else
                        if ($request['validacion']==2) {
                            $data_area->whereIn('c_v_evento',$id_eventos_validados);
                        }else
                        if ($request['validacion']==3) {
                            $data_area->whereIn('c_v_evento',$id_eventos_validados);
                        }
                    }

                    $data_area = $data_area->get()->toArray();

                $data_institucion_erradica = Plantio::
                    with(['institucion_erradica']);
                    if(!empty($request['validacion'])){
                        if($request['validacion']==1){
                            $data_institucion_erradica->whereNotIn('c_v_evento',$id_eventos_validados);
                        }else
                        if ($request['validacion']==2) {
                            $data_institucion_erradica->whereIn('c_v_evento',$id_eventos_validados);
                        }else
                        if ($request['validacion']==3) {
                            $data_institucion_erradica->whereIn('c_v_evento',$id_eventos_validados);
                        }
                    }
                }
        }

        $catalogo_estados = Estado::orderBy('ID_ESTADO')->pluck('NOMBRE', 'ID_ESTADO')->toArray();
        $tipos_plantio = TipoPlantio::orderBy('c_i_tplantio')->pluck('d_v_tplantio', 'c_i_tplantio')->toArray();
        $tipos_presentacion = Presentacion::orderBy('c_i_presentacion')->pluck('d_v_presentacion', 'c_i_presentacion')->toArray();
        $tipos_institucion = Dependencia::orderBy('c_i_dependencia')->pluck('d_v_dependencia', 'c_i_dependencia')->toArray();

        return view('admin.graphs.graph', compact('data_plantios','data_presentacion','data_area','tipos_plantio','tipos_presentacion','catalogo_estados','data_institucion_erradica','tipos_institucion'));
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
}
