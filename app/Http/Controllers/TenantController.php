<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\DatabaseConnection;
use Illuminate\Support\Facades\Config;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // DB::reconnect('mysql');
        // $admin = new Admin();
        // $admin->setConnection('mysql');
        // $admin1 = $admin->find(1);
        // return response()->json(['data' =>   $admin1, 'conection' => Config::get("database.connections.mysql"), 'cnt' => DB::connection()->getDatabaseName()]);

        Config::set("database.connections.mysql.database", 'corvus');
        DB::reconnect('mysql');
        $admin = new Admin();
        $admin->setConnection('mysql');
        $admin1 = $admin->find(1);
        return response()->json(DB::connection()->getDatabaseName());

        // return response()->json(['data' =>   $admin1, 'conection' => Config::get("database.connections.mysql"), 'cnt' => DB::connection()->getDatabaseName()]);

        // DB::purge('Tenantcy');
        // Config::set("database.connections.mysql.database", 'corvus');
        // DB::reconnect('mysql');


        // Config::set('database.connections.mysql', array(
        //     'driver'    => 'mysql',
        //     'host'      => 'localhost',
        //     'database'  => 'corvus',
        //     'username'  => 'local',
        //     'password'  => '123',
        //     'charset'   => 'utf8',
        //     'collation' => 'utf8_general_ci',
        //     'prefix'    => '',
        // ));

        // Config::get('database.default');
        // return DB::getDatabaseName();
        // $admin = new Admin();
        // $admin->setConnection('mysql');
        // $admin1 = $admin->find(1);
        // return $admin1;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        DB::beginTransaction();
        try {
            $tenant = Tenant::create(request()->get('id'));
            $tenant->domains()->create(['domain' => request()->get('domain')]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
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
