<?php

namespace Database\Seeders;


use App\Models\ContablePrestacionSocial;
use Illuminate\Database\Seeder;

class ContablePrestacionSocialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        ContablePrestacionSocial::create([
            'concepto' => 'Cesantías',
            'cuenta_contable' => '0530',
            'contrapartida' => '251010',
            'estado' => true,
            'editable' => false
        ]);
        ContablePrestacionSocial::create([
            'concepto' => 'Intereses a las Cesantías',
            'cuenta_contable' => '0533',
            'contrapartida' => '2515',
            'estado' => true,
            'editable' => false
        ]);
        ContablePrestacionSocial::create([
            'concepto' => 'Prima de Servicios',
            'cuenta_contable' => '0536',
            'contrapartida' => '2520',
            'estado' => true,
            'editable' => false
        ]);
    }
}
