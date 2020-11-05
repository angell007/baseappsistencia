<?php

namespace Database\Seeders;

use App\Models\Banco;
use Illuminate\Database\Seeder;


class BancoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Banco::create([
            'nombre' => 'Bancolombia',
            'nit' => '890903938',
            'editable' => false
        ]);
        Banco::create([
            'nombre' => 'Banco de Bogotá',
            'nit' => '860002964',
            'editable' => false

        ]);
        Banco::create([
            'nombre' => 'Banco Popular',
            'nit' => '860007738',
            'editable' => false

        ]);
        Banco::create([
            'nombre' => 'Banco CorpBanca',
            'nit' => '890903937',
            'editable' => false

        ]);
        Banco::create([
            'nombre' => 'Citibank',
            'nit' => '860051135',
            'editable' => false

        ]);
        Banco::create([
            'nombre' => 'Banco GNB Sudameris',
            'nit' => '860050750',
            'editable' => false

        ]);
        Banco::create([
            'nombre' => 'BBVA Colombia',
            'nit' => '860003020',
            'editable' => false

        ]);
        Banco::create([
            'nombre' => 'Banco de Occidente',
            'nit' => '890300279',
            'editable' => false

        ]);
        Banco::create([
            'nombre' => 'Banco Caja Social',
            'nit' => '860007335',
            'editable' => false

        ]);
        Banco::create([
            'nombre' => 'Davivienda',
            'nit' => '860034313',
            'editable' => false

        ]);
        Banco::create([
            'nombre' => 'Banco Colpatria',
            'nit' => '860034594',
            'editable' => false

        ]);
        Banco::create([
            'nombre' => 'Banagrario',
            'nit' => '800037800',
            'editable' => false

        ]);
        Banco::create([
            'nombre' => 'AV Villas',
            'nit' => '860035827'
        ]);
        Banco::create([
            'nombre' => 'Procredit',
            'nit' => '900200960',
            'editable' => false

        ]);
        Banco::create([
            'nombre' => 'Bancamía',
            'nit' => '900215071',
            'editable' => false

        ]);
        Banco::create([
            'nombre' => 'Banco W',
            'nit' => '900378212',
            'editable' => false

        ]);
        Banco::create([
            'nombre' => 'Bancoomeva',
            'nit' => '900406150',
            'editable' => false

        ]);
        Banco::create([
            'nombre' => 'Finandina',
            'nit' => '860051894',
            'editable' => false

        ]);
        Banco::create([
            'nombre' => 'Banco Falabella',
            'nit' => '900047981',
            'editable' => false

        ]);
        Banco::create([
            'nombre' => 'Banco Pichincha',
            'nit' => '890200756',
            'editable' => false

        ]);
        Banco::create([
            'nombre' => 'Coopcentral',
            'nit' => '890203088',
            'editable' => false

        ]);
        Banco::create([
            'nombre' => ' Banco Santander',
            'nit' => '900628110',
            'editable' => false

        ]);
        Banco::create([
            'nombre' => 'Banco Mundo Mujer',
            'nit' => '900768933',
            'editable' => false

        ]);
        Banco::create([
            'nombre' => 'MultiBank',
            'nit' => '860024414',
            'editable' => false

        ]);
        Banco::create([
            'nombre' => 'Bancompartir',
            'nit' => '860025971',
            'editable' => false

        ]);
        Banco::create([
            'nombre' => 'Banco Serfinanza',
            'nit' => '860043186',
            'editable' => false

        ]);
        Banco::create([
            'nombre' => 'Corficolombiana',
            'nit' => '890300653',
            'editable' => false

        ]);
        Banco::create([
            'nombre' => 'Coltefinanciera',
            'nit' => '890927034',
            'editable' => false

        ]);
        Banco::create([
            'nombre' => 'Credifinaciera',
            'nit' => '900168231',
            'editable' => false

        ]);
    }
}
