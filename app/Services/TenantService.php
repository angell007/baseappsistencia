<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\Funcionario;
use App\Models\Tenant;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TenantService
{
    public function createCliente($data, $ruta)
    {
        /** Creo el Cliente dentro de mi base de datos para controlar todo acerca de él */
        $ruta =  md5(Str::camel($data['empresa'])); // Esta es la ruta cifrada y nombre de la base de datos tambien
        $cliente = Cliente::create([
            'nombre' => $data['empresa'],
            'documento' => $data['nit'],
            'dv' => $data['dv'],
            'correo_registrado' => $data['usuario'],
            'pais_id' => $data['pais'],
            'tipo_negocio' => $data['tipo_negocio'],
            'valor_contrato' => $data['valor_contrato'],
            'fecha_creacion' => date("Y-m-d H:m:s"),
            'fecha_renovacion' => date("Y-m-d H:m:s"),
            'fecha_vencimiento' => date("2200-m-d H:m:s"),
            'tipo_pago' => $data['tipo_pago'],
            'ruta' => $ruta,
        ]);
        return $cliente;
    }

    public function createAdmin($data)
    {
        /** Creo el usuario que va a realizar login desde mi BD principal*/
        $admin = Admin::create([
            'usuario' => $data['usuario'],
            'password' => Hash::make($data['password'])
        ]);

        return $admin;
    }

    public function createTenant($ruta)
    {
        /** Creo el TENANT donde se alojará la información del Cliente */
        $tenant = Tenant::create(['id' => $ruta]);
        $tenant->domains()->create(['domain' => $ruta]);
    }

    public function createEmpresa($data)
    {
        /** Guardo datos inciales de empresa */
        Empresa::create([
            'razon_social' => $data['empresa'],
            'tipo_documento' => $data['tipo_documento'],
            'numero_documento' => $data['nit'],
            'dv' => $data['dv'],
            'email_contacto' => $data['usuario']
        ]);
    }
    public function createFuncionario($data)
    {
        /** Guardo datos iniciales de funcionarios */
        $funcionario =   Funcionario::create([
            'nombres' => $data['nombres'],
            'apellidos' => $data['apellidos'],
            'identidad' => $data['cedula'],
            'email' => $data['usuario'],
            'fecha_retiro' => date("2200-m-d H:m:s"),
        ]);

        // $funcionario->submenus()->attach();

        return $funcionario;
        
    }
}
