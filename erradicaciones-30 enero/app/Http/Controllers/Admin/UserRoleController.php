<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\UserRole;
use App\Models\Admin\Role;
use Illuminate\Foundation\Auth\User;

class UserRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = UserRole::orderBy('id')->with(['role','usuario'])->get()->toArray();
        return view('admin.user_role.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $usuarios_asignados = UserRole::get('user_id')->toArray();
        $roles = Role::orderBy('id')->pluck('name', 'id')->toArray();
        $usuarios = User::whereNotIn('id', $usuarios_asignados)->orderBy('id')->pluck('name', 'id')->toArray();
        return view('admin.user_role.create',compact('roles','usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        UserRole::create($request->all());
        return redirect('admin/users_roles')->with('mensaje', 'Rol asignado a usuario con éxito');
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
        $data = UserRole::findOrFail($id); //Arroja 404 y no un null
        $roles = Role::orderBy('id')->pluck('name', 'id')->toArray();
        $usuarios = User::orderBy('id')->pluck('name', 'id')->toArray();
        return view('admin.user_role.edit',compact('roles','usuarios','data'));
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
        UserRole::findOrFail($id)->update($request->all());
        return redirect('admin/users_roles')->with('mensaje', 'El rol del usuario ha sido actualizado con éxito');
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
            if (UserRole::destroy($id)) {
                return response()->json(['mensaje' => 'ok']);
            } else {
                return response()->json(['mensaje' => 'ng']);
            }
        } else {
            abort(404);
        }
    }
}
