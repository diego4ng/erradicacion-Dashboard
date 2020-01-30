<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
class PermisoAdministrador
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->permiso())
            return $next($request);
        return redirect('/security/login')->with('mensaje-error', 'No tiene permisos para entrar aquí, contacte al administrador.');

    }

    private function permiso()
    {
        foreach (session()->get('menus') as $key => $value) {
            if ($value['url']==Route::current()->uri()) {
                return true;
            }else
                if(!empty($value['submenu'])){
                    foreach ($value['submenu'] as $key2 => $value2) {
                        if ($value2['url']==Route::current()->uri()) {
                            return true;
                        }
                    }
                }else{
                //  if (
                //      (Route::current()->uri() == 'admin/register_filter') ||
                //      (Route::current()->uri() == 'admin/filter_total') ||
                //      (Route::current()->uri() == 'admin/graph_filter') ||
                //      (Route::current()->uri() == 'admin/dispositives_filter') ||
                //      (Route::current()->uri() == 'admin/register/registers_map_filter') ||
                //      (Route::current()->uri() == 'admin/register/view_register/{id}') ||
                //      (Route::current()->uri() == 'admin/dispositive/{id}/edit') ||
                //      (Route::current()->uri() == 'admin/dispositive/{id}/show')
                //      ) {
                    return true;
                }
            //}
        }
        //return false;
    }
}
