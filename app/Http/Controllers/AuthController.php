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
        $this->middleware('auth:api', ['except' => ['login']]);
        // $this->middleware('token');
    }

    public function login(Request $request)
    {

        $credentials = $request->only('usuario', 'password');

        try {
            if (!$token = auth()->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }

        $user = Admin::with("cliente")->find(auth()->user()->id);

        if (!$user->acceso_web) {

            auth()->logout();
            return response()->json([
                'status' => 'No tienes permisos para acceder',
            ], 401);
        }

        $ruta = $user["cliente"]["ruta"];
        Config::set("database.connections.Tenantcy.database", 'tenant' . $ruta);
        $funcionario =  DB::connection('Tenantcy')->table('Funcionario')->where('id', $user['funcionario_id'])->get(["nombres", "apellidos", "identidad", "image"]);
        $empresa =  DB::connection('Tenantcy')->table('empresa')->where('id', 1)->get(["razon_social", "imagen"]);

        return response()->json(['status' => 'success', 'token' => $this->respondWithToken($token), 'ruta' => $ruta, 'User' => $funcionario[0], 'Empresa' => $empresa[0]], 200)->header('Authorization', $token)
            ->withCookie(
                'token',
                $token,
                config('jwt.ttl'),
                '/'
            );
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
        auth()->logout();
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


    /**
     * Refrescar el token por uno nuevo
     *
     * @return token
     */

    public function me()
    {
        return response()->json(auth()->user());
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


    protected function respondWithToken($token)
    {
        auth()->factory()->getTTL() * 60;

        return $token;
        // return response()->json([
        //     'access_token' => $token,
        //     'token_type' => 'bearer',
        //     'expires_in' => auth()->factory()->getTTL() * 60
        // ]);
    }
}
