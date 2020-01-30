<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Register;
use App\Models\Admin\Novedades;
use App\Models\Admin\Estado;
use App\Models\Admin\Aseguramientos;
use App\Models\Admin\Validation;
use App\Models\Admin\ValidationDasboard;
use PDF;

class ValidationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function validation($id_evento = null)
    {
        session()->forget('filtrado'); //Sirve para mostrar un tipo de paginado diferente

        if($id_evento <> null){
            $evento = Register::with(['plantios','estado','municipio','localidad','dependencia','dispositivos','plantios.tipoPlantio','plantios.presentacion','caracteristicas.metodoErradicacion','caracteristicas.manejoCultural','caracteristicas.metodoSiembra','caracteristicas.clima','caracteristicas.terreno','caracteristicas.mimetizacion','caracteristicas.riego','caracteristicas.accesibilidad','caracteristicas.terrestre','coordenada_central','metadatos','metadatos.tipo_imagen','plantios.etapa','plantios.color_flor','identificacion','identificacion.dependencia','identificacion.region_militar','identificacion.armas','identificacion.unidad','validaciones','validacion_dashboard','validacion_dashboard.usuario_validador','coordenadas'])
            ->where([
                ['o_eventos.c_v_evento', '=', $id_evento],
                ['o_eventos.s_v_status','=', 'A']
            ])
            ->get()
            ->toArray();
        }else{
            $evento = null;
        }

        $datas = Register::with(['plantios','estado','municipio','localidad','dependencia','plantios.tipoPlantio','plantios.presentacion','caracteristicas.metodoErradicacion','caracteristicas.manejoCultural','coordenada_central','validaciones','validacion_dashboard','validacion_dashboard.usuario_validador','metadatos'])
        ->orderBy('f_t_captura','ASC')
        ->where([
            ['o_eventos.s_v_status','=', 'A']
        ])
        ->paginate(3);

        $total_eventos = Register::count();
        $total_validados = ValidationDasboard::count();
        $total_faltantes = $total_eventos - $total_validados;

        $catalogo_novedades = Novedades::orderBy('c_i_novedad')->pluck('d_v_novedad', 'c_i_novedad')->toArray();
        $catalogo_estados = Estado::orderBy('ID_ESTADO')->pluck('NOMBRE', 'ID_ESTADO');
        $catalogo_aseguramientos = Aseguramientos::orderBy('c_i_aseguramiento')->pluck('d_v_aseguramiento', 'c_i_aseguramiento');
        return view('admin.validation.validation', compact('datas','catalogo_novedades','catalogo_aseguramientos','catalogo_estados','evento','total_faltantes'));
    }

    public function findEventAjax(Request $request, $id_evento)
    {
        if ($request->ajax()) {
            $evento = Register::with(['plantios','estado','municipio','localidad','dependencia','plantios.tipoPlantio','plantios.presentacion','caracteristicas.metodoErradicacion','caracteristicas.manejoCultural','coordenada_central'])
            ->where('o_eventos.c_v_evento', '=', $id_evento)
            ->orderBy('f_t_captura','ASC')
            ->paginate(3);

            return response()->json($evento);
        } else {
            return response()->json(['mensaje' => 'ng']);
        }
    }

    public function validation_filter(Request $request)
    {
        date_default_timezone_set('America/Mexico_City');
        session(['filtrado' => 1]); //Sirve para mostrar un tipo de paginado diferente
        $fecha_inicial = $request['startDate'];
        $fecha_final = $request['endDate'];
        $fecha = date($fecha_final);
        $nuevafecha = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
        $nuevafechafinal = date ( 'Y-m-j' , $nuevafecha );
        $catalogo_estados = Estado::orderBy('ID_ESTADO')->pluck('NOMBRE', 'ID_ESTADO')->toArray();
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
                //dd('1');
                $datas = Register::with(['estado','municipio','localidad','dependencia','plantios.tipoPlantio','plantios.presentacion','caracteristicas.metodoErradicacion','caracteristicas.manejoCultural','coordenada_central','plantios','validacion_dashboard','metadatos'])
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
                }else{
                    dd($request);
                }
                $datas = $datas->get();

            } else {
                //dd('2');
                $datas = Register::with(['estado','municipio','localidad','dependencia','plantios.tipoPlantio','plantios.presentacion','caracteristicas.metodoErradicacion','caracteristicas.manejoCultural','coordenada_central','plantios','validacion_dashboard','metadatos'])
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
                // dd('3');
                //dd($today);
                $datas = Register::with(['estado','municipio','localidad','dependencia','plantios.tipoPlantio','plantios.presentacion','caracteristicas.metodoErradicacion','caracteristicas.manejoCultural','coordenada_central','plantios','validacion_dashboard','metadatos'])
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
                //dd('4');
                $datas = Register::with(['estado','municipio','localidad','dependencia','plantios.tipoPlantio','plantios.presentacion','caracteristicas.metodoErradicacion','caracteristicas.manejoCultural','coordenada_central','plantios','validacion_dashboard','metadatos']);
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

        $evento = null;
        $total_eventos = Register::count();
        $total_validados = ValidationDasboard::count();
        $total_faltantes = $total_eventos - $total_validados;
        $catalogo_novedades = Novedades::orderBy('c_i_novedad')->pluck('d_v_novedad', 'c_i_novedad')->toArray();
        $catalogo_aseguramientos = Aseguramientos::orderBy('c_i_aseguramiento')->pluck('d_v_aseguramiento', 'c_i_aseguramiento')->toArray();
        return view('admin.validation.validation', compact('datas','catalogo_novedades','catalogo_aseguramientos','catalogo_estados','evento','total_faltantes'));
    }

    public function validacion(Request $request){

        //dd($request->request);
        $request->request->remove('_token');
        $request->request->add(['id_usuario_validador'=>auth()->user()->id]);
        $data = $request->only('id_evento','observaciones_validador','total_puntos','total_datos','imei','seguridad','transmision','integridad','suficiencia','diferencia_dias','georeferencia','evidencia');
        $data['id_usuario_validador'] = auth()->user()->id;

        //dd($data);
        if($data['total_puntos']<90){
            $data['estatus_validacion'] = 3;
        }else{
            $data['estatus_validacion'] = 2;
        }

        ValidationDasboard::create($data);
        return redirect('admin/validation')->with('mensaje', 'Validación guardada con éxito');

    }

    public function generar_acuse_pdf($id_evento = null)
    {
        if($id_evento <> null){
            $data = Register::with(['plantios','estado','municipio','localidad','dependencia','dispositivos','plantios.tipoPlantio','plantios.presentacion','caracteristicas.metodoErradicacion','caracteristicas.manejoCultural','caracteristicas.metodoSiembra','caracteristicas.clima','caracteristicas.terreno','caracteristicas.mimetizacion','caracteristicas.riego','caracteristicas.accesibilidad','caracteristicas.terrestre','coordenada_central','metadatos','plantios.etapa','plantios.color_flor','identificacion','identificacion.dependencia','identificacion.region_militar','identificacion.armas','identificacion.unidad','validaciones','validacion_dashboard','coordenadas'])
            ->where([
                ['o_eventos.c_v_evento', '=', $id_evento],
                ['o_eventos.s_v_status','=', 'A']
            ])
            ->get()
            ->toArray();


            $pdf = PDF::loadView('admin.validation.generar_acuse_pdf', compact('data'));
            return $pdf->download('Acuse de recibo '.$id_evento.'.pdf');

            //return view('admin.validation.generar_acuse_pdf', compact('data'));

        }else{
            $pdf = PDF::loadView('admin.validation.generar_acuse_pdf');
            return $pdf->download('Acuse de recibo '.$id_evento.'.pdf');
        }
    }

    public function generar_reporte_pdf($id_evento = null){

        if($id_evento <> null){
            $data = Register::with(['plantios','estado','municipio','localidad','dependencia','dispositivos','plantios.tipoPlantio','plantios.presentacion','caracteristicas.metodoErradicacion','caracteristicas.manejoCultural','caracteristicas.metodoSiembra','caracteristicas.clima','caracteristicas.terreno','caracteristicas.mimetizacion','caracteristicas.riego','caracteristicas.accesibilidad','caracteristicas.terrestre','coordenada_central','metadatos','plantios.etapa','plantios.color_flor','identificacion','identificacion.dependencia','identificacion.region_militar','identificacion.armas','identificacion.unidad','validaciones','validacion_dashboard','validacion_dashboard.usuario_validador','coordenadas'])
            ->where([
                ['o_eventos.c_v_evento', '=', $id_evento],
                ['o_eventos.s_v_status','=', 'A']
            ])
            ->get()
            ->toArray();

            $pdf = PDF::loadView('admin.validation.generar_reporte_pdf', compact('data'));
            return $pdf->download('Reporte de validación '.$id_evento.'.pdf');

        }else{
            $pdf = PDF::loadView('admin.validation.generar_reporte_pdf');
            return $pdf->download('Reporte de validación '.$id_evento.'.pdf');
        }
    }

    public function images(){
        session()->forget('filtrado'); //Sirve para mostrar un tipo de paginado diferente
        $datas = Register::with(['plantios','estado','municipio','localidad','dependencia','plantios.tipoPlantio','plantios.presentacion','caracteristicas.metodoErradicacion','caracteristicas.manejoCultural','coordenada_central','metadatos'])->orderBy('f_t_captura','ASC')->paginate(3);
        $catalogo_novedades = Novedades::orderBy('c_i_novedad')->pluck('d_v_novedad', 'c_i_novedad')->toArray();
        $catalogo_estados = Estado::orderBy('ID_ESTADO')->pluck('NOMBRE', 'ID_ESTADO');
        $catalogo_aseguramientos = Aseguramientos::orderBy('c_i_aseguramiento')->pluck('d_v_aseguramiento', 'c_i_aseguramiento');
        return view('admin.validation.images', compact('datas','catalogo_novedades','catalogo_aseguramientos','catalogo_estados'));
    }

    public function images_filter(Request $request)
    {
        date_default_timezone_set('America/Mexico_City');
        session(['filtrado' => 1]); //Sirve para mostrar un tipo de paginado diferente
        $fecha_inicial = $request['startDate'];
        $fecha_final = $request['endDate'];
        $fecha = date($fecha_final);
        $nuevafecha = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
        $nuevafechafinal = date ( 'Y-m-j' , $nuevafecha );
        $catalogo_estados = Estado::orderBy('ID_ESTADO')->pluck('NOMBRE', 'ID_ESTADO')->toArray();
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
                $datas = Register::with(['estado','municipio','localidad','dependencia','plantios.tipoPlantio','plantios.presentacion','caracteristicas.metodoErradicacion','caracteristicas.manejoCultural','coordenada_central','plantios','metadatos'])
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
                $datas = Register::with(['estado','municipio','localidad','dependencia','plantios.tipoPlantio','plantios.presentacion','caracteristicas.metodoErradicacion','caracteristicas.manejoCultural','coordenada_central','plantios','metadatos'])
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
                $datas = Register::with(['estado','municipio','localidad','dependencia','plantios.tipoPlantio','plantios.presentacion','caracteristicas.metodoErradicacion','caracteristicas.manejoCultural','coordenada_central','plantios','metadatos'])
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
                $datas = Register::with(['estado','municipio','localidad','dependencia','plantios.tipoPlantio','plantios.presentacion','caracteristicas.metodoErradicacion','caracteristicas.manejoCultural','coordenada_central','plantios','metadatos']);
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

        $catalogo_novedades = Novedades::orderBy('c_i_novedad')->pluck('d_v_novedad', 'c_i_novedad')->toArray();
        $catalogo_aseguramientos = Aseguramientos::orderBy('c_i_aseguramiento')->pluck('d_v_aseguramiento', 'c_i_aseguramiento')->toArray();
        return view('admin.validation.images', compact('datas','catalogo_novedades','catalogo_aseguramientos','catalogo_estados'));
    }

    public function view_register_validation($id)
    {
        $datas = Register::with(['plantios','estado','municipio','localidad','dependencia','plantios.tipoPlantio','plantios.presentacion','caracteristicas.metodoErradicacion','caracteristicas.manejoCultural','coordenada_central'])->where('c_v_evento',$id)->get()->toArray();
        $catalogo_novedades = Novedades::orderBy('c_i_novedad')->pluck('d_v_novedad', 'c_i_novedad')->toArray();
        return view('admin.validation.view_register', compact('datas','catalogo_novedades'));
    }
}
