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
            'nit' => $data['nit'],
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
            'password' => Hash::make($data['password']),
            'acceso_app' => 1,
            'acceso_web' => 1,
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
            /********************************************************** */
            'eps_id' => 1,
            'cesantias_id' => 1,
            'pensiones_id' => 1,
            'caja_compensacion_id' => 1,
            'tipo_contrato_id' => 1,
            'nomina_riesgos_arl_id' => 1,
            'jefe_id' => 1,
            'dependencia_id' => 1,
            'cargo_id' => 1,
            'estado_civil' => 'Soltero(a)',
            'salario' => 1,
            'tipo_turno' => 'Fijo',
            /********************************************************** */
            'talla_pantalon' => '36',
            'talla_botas' => '44',
            'talla_camisa' => '44',
        ]);
        return $funcionario;
    }
}
