<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Security\LoginController@index')->name('inicio');
Route::get('security/login', 'Security\LoginController@index')->name('login');
Route::post('security/login', 'Security\LoginController@login')->name('login_post');
Route::get('security/logout', 'Security\LoginController@logout')->name('logout');
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth','superadmin']], function () {
    Route::get('/', 'AdminController@index')->name('admin');
    /*RUTAS PERMISOS*/
    Route::get('permission', 'PermissionController@index')->name('permission');
    Route::get('permission/create', 'PermissionController@create')->name('create_perrmission');
    /*RUTAS DEL MENU*/
    Route::get('menu', 'MenuController@index')->name('menu');
    Route::get('menu/create', 'MenuController@create')->name('create_menu');
    Route::post('menu', 'MenuController@store')->name('store_menu');
    Route::get('menu/{id}/edit', 'MenuController@edit')->name('edit_menu');
    Route::put('menu/{id}', 'MenuController@update')->name('update_menu');
    Route::get('menu/{id}/eliminar', 'MenuController@destroy')->name('destroy_menu');
    Route::post('menu/guardar-orden', 'MenuController@guardarOrden')->name('guardar_orden');
    /*RUTAS ROL*/
    Route::get('role', 'RoleController@index')->name('role');
    Route::get('role/create', 'RoleController@create')->name('create_role');
    Route::post('role', 'RoleController@store')->name('store_role');
    Route::get('role/{id}/edit', 'RoleController@edit')->name('edit_role');
    Route::put('role/{id}', 'RoleController@update')->name('update_role');
    Route::delete('role/{id}', 'RoleController@destroy')->name('destroy_role');
    /*RUTAS USUARIOS*/
    Route::get('users', 'UserController@index')->name('usuarios');
    Route::get('user/create', 'UserController@create')->name('create_user');
    Route::post('user', 'UserController@store')->name('store_user');
    Route::get('user/{id}/edit', 'UserController@edit')->name('edit_user');
    Route::put('user/{id}', 'UserController@update')->name('update_user');
    Route::delete('user/{id}', 'UserController@destroy')->name('destroy_user');
    /*RUTAS MENU_ROL*/
    Route::get('menu-role', 'MenuRoleController@index')->name('menu_role');
    Route::post('menu-role', 'MenuRoleController@store')->name('store_menu_role');
    /*RUTAS REGISTROS*/
    Route::get('register', 'RegisterController@index')->name('registros');
    Route::post('register_filter', 'RegisterController@register_filter')->name('register_filter');
    Route::get('register/view_register/{id}', 'RegisterController@show')->name('view_register');
    Route::get('register/registers_map', 'RegisterController@registers_map')->name('registers_map');
    Route::post('register/registers_map_filter', 'RegisterController@registers_map_filter')->name('registers_map_filter');
    /*RUTAS DE ANALITICAS*/
     Route::get('analytics', 'AnalyticController@index')->name('analytics');
    /*RUTAS DE TOTALIDADES*/
    Route::get('total', 'TotalController@index')->name('total');
    Route::post('filter_total', 'TotalController@filter_total')->name('filter_total');
    /*RUTAS DE GRÁFICAS*/
    Route::get('graph', 'GraphController@index')->name('graficas');
    Route::post('graph_filter', 'GraphController@graph_filter')->name('graph_filter');
    /*RUTAS DISPOSITIVOS*/
    Route::get('dispositive', 'DispositiveController@index')->name('dispositives');
    Route::post('dispositives_filter', 'DispositiveController@dispositives_filter')->name('dispositives_filter');
    Route::get('dispositive/create', 'DispositiveController@create')->name('create_dispositive');
    Route::post('dispositive', 'DispositiveController@store')->name('store_dispositive');
    Route::get('dispositive/{id}/edit', 'DispositiveController@edit')->name('edit_dispositive');
    Route::put('dispositive/{id}', 'DispositiveController@update')->name('update_dispositive');
    Route::put('dispositive/{id}/edit', 'DispositiveController@updateObservation')->name('edit_dispositive_observation');
    Route::get('dispositive/{id}/show', 'DispositiveController@show')->name('show_dispositive');
    Route::delete('dispositive/{id}', 'DispositiveController@destroy')->name('destroy_dispositive');
    /*RUTAS USUARIOS ROLES*/
    Route::get('users_roles', 'UserRoleController@index')->name('usuarios_roles');
    Route::get('users_roles/create', 'UserRoleController@create')->name('create_user_role');
    Route::post('users_roles', 'UserRoleController@store')->name('store_user_role');
    Route::get('users_roles/{id}/edit', 'UserRoleController@edit')->name('edit_user_role');
    Route::put('users_roles/{id}', 'UserRoleController@update')->name('update_user_role');
    Route::delete('users_roles/{id}', 'UserRoleController@destroy')->name('destroy_user_role');
    /*RUTAS ASIGNACIONES*/
    Route::get('asignation', 'AsignationController@index')->name('asignation');
    Route::get('asignation/create', 'AsignationController@create')->name('create_asignation');
    Route::post('asignation', 'AsignationController@store')->name('store_asignation');
    Route::get('asignation/{id}/edit', 'AsignationController@edit')->name('edit_asignation');
    Route::put('asignation/{id}', 'AsignationController@update')->name('update_asignation');
    Route::delete('asignation/{id}', 'AsignationController@destroy')->name('destroy_asignation');
    /*RUTAS AJAX MUNICIPIOS Y LOCALIDADES*/
    Route::post('municipiosajax/{id}','DispositiveController@findAjax')->name('findMunicipios');
    Route::post('localidadesajax/{id}','DispositiveController@findLocalidadesAjax')->name('findLocalidades');
    /*RUTAS VALIDACIÓN*/
    Route::get('validation/{id_evento?}', 'ValidationController@validation')->name('validation');
    //Route::get('validation/{id_evento}','ValidationController@findEventAjax')->name('findEventAjax');
    Route::post('validation_filter', 'ValidationController@validation_filter')->name('validation_filter');
    Route::get('view_register_validation/{id}', 'ValidationController@view_register_validation')->name('view_register_validation');
    Route::get('images', 'ValidationController@images')->name('images');
    Route::post('images_filter', 'ValidationController@images_filter')->name('images_filter');
    Route::post('validacion', 'ValidationController@validacion')->name('validacion');
    Route::get('generar_acuse_pdf/{id_evento?}','ValidationController@generar_acuse_pdf')->name('generar_acuse_pdf');
    Route::get('generar_reporte_pdf/{id_evento?}','ValidationController@generar_reporte_pdf')->name('generar_reporte_pdf');
});
