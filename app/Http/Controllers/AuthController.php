<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Admin;
use App\Models\Empresa;
use App\Models\Funcionario;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    /**
     * Login usuario y retornar el token
     * @return token
     */
    public function __construct()
    {
        DB::getDefaultConnection();
    }

    public function login(Request $request)
    {

        $credenciales = $request->only('usuario', 'password');
        try {

            if (!$token = auth()->attempt($credenciales)) {
                return response()->json(['error' => 'invalid credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }

        $user = Admin::with("cliente")->find(Auth::user()->id);


        $ruta = $user["cliente"]["ruta"];

        Config::set("database.connections.Tenantcy.database", 'tenant' . $ruta);
        $funcionario =  DB::connection('Tenantcy')->table('Funcionario')->where('id', $user['funcionario_id'])->get(["nombres","apellidos","identidad", "image"]);
        $empresa =  DB::connection('Tenantcy')->table('empresa')->where('id', 1)->get(["razon_social", "imagen"]);

        return response()->json(['status' => 'success', 'token' => $token, 'ruta' => $ruta, 'User' => $funcionario[0], 'Empresa' => $empresa[0]], 200)->header('Authorization', $token);
    }

    public function register()
    {
        $validador = Validator::make(request()->all(), [
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validador->fails()) {
            return response()->json($validador->errors()->toJson(), 400);
        }

        $usuario = Admin::create([
            'nombres' => request('nombres'),
            'apellidos' => request('apellidos'),
            'apellidos' => request('apellidos'),
            'password' => bcrypt(request('password')),
        ]);

        $usuario->save();

        $token = $this->guard()->login($usuario);

        return response()->json(['message' => 'User created successfully', 'token' => $token], 201);
    }

    /**
     * Logout usuario
     *
     * @return void
     */
    public function logout()
    {

        $this->guard()->logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Logged out Successfully.'
        ], 200);
    }

    /**
     * Obtener el usuario autenticado
     *
     * @return Admin
     */
    public function user()
    {
        try {
            if (!$user = Admin::find(Auth::user()->id)) {
                return response()->json(['error' => 'user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['error' => 'Token expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['error' => 'Token invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['erro' => 'Token absent'], $e->getStatusCode());
        }

        return response()->json([
            'status' => 'success',
            'user' => $user
        ]);
    }

    /**
     * Refrescar el token por uno nuevo
     *
     * @return token
     */
    public function me(Request $request)
    {
        // BearerToken token....
        dd($request->user());
        // return response()->json($this->guard()->user(), 200);
    }

    public function refresh()
    {
        if ($token = $this->guard()->refresh()) {
            return response()
                ->json(['status' => 'successs'], 200)
                ->header('Authorization', $token);
        }
        return response()->json(['error' => 'refresh_token_error'], 401);
    }

    /**
     * Retornar el guard
     *
     * @return Guard
     */
    private function guard()
    {
        return Auth::guard();
    }
}
