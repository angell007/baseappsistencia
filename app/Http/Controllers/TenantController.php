<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Models\Empresa;
use App\Models\Funcionario;
use App\Models\Cliente;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\DatabaseConnection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TenantController extends Controller
{
    public function __construct()
    {
        DB::getDefaultConnection();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return 'response';
        //     Config::set("database.connections.Tenantcy.database", 'backup');
        //     $admin = new Admin();
        //     $admin->setConnection('Tenantcy');
        //     DB::reconnect('Tenantcy');
        //     $admin1 = $admin->find(1);
        //     // {"tenancy_db_name": "tenantDanilo007"}
        //     return response()->json(['data' =>   $admin1, 'conection' => Config::get("database.connections.mysql"), 'cnt' => DB::connection()->getDatabaseName()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        DB::beginTransaction();
        try {
 
            /** Creo el Cliente dentro de mi base de datos para controlar todo acerca de él */
            $ruta =  md5(Str::camel(request()->get('empresa'))); // Esta es la ruta cifrada y nombre de la base de datos tambien
            $cliente = Cliente::create([
                'nombre' => request()->get('empresa'),
                'documento' => request()->get('nit'),
                'dv' => request()->get('dv'),
                'correo_registrado' => request()->get('usuario'),
                'pais_id' => request()->get('pais'),
                'tipo_negocio' => request()->get('tipo_negocio'),
                'valor_contrato' => request()->get('valor_contrato'),
                'fecha_creacion' => date("Y-m-d H:m:s"),
                'fecha_renovacion' => date("Y-m-d H:m:s"),
                'fecha_vencimiento' => date("2200-m-d H:m:s"),
                'tipo_pago' => request()->get('tipo_pago'),
                'estado' => request()->get('estado'),
                'ruta' => $ruta,
            ]);

            /** Creo el usuario que va a realizar login desde mi BD principal*/
            $admin = Admin::create([
                'usuario' => request()->get('usuario'),
                'password' => Hash::make(request()->get('password')),
                'cliente_id' => $cliente["id"]
            ]);
            /** Creo el TENANT donde se alojará la información del Cliente */    
            $tenant = Tenant::create(['id' => $ruta]);
            $tenant->domains()->create(['domain' =>$ruta]);

            /** Me cambio de conexión para agregar los datos también a la base de datos del Cliente */
            Config::set("database.connections.Tenantcy.database", 'tenant' . $ruta);
            $empresa = new Empresa();
            $empresa->setConnection('Tenantcy');
            DB::reconnect('Tenantcy');


            $empresa->create([
                  'razon_social' => request()->get('empresa'),
                  'tipo_documento' => request()->get('tipo_documento'),
                  'numero_documento' => request()->get('nit'),
                  'dv' => request()->get('dv'),
                  'email_contacto' => request()->get('usuario'),
            ]);
            
            /*
            $func= new Funcionario();
            $func->setConnection('Tenantcy');
            

            //return response()->json(request()->all());

            $funcionario = $func->create(request()->all());
            */
            $funcionario='';

            DB::commit();
            return response()->json(['data' =>   $funcionario, 'cnt' => DB::connection()->getDatabaseName()]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
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
