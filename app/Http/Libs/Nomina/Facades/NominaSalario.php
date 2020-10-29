<?php
namespace App\Http\Libs\Nomina\Facades;

use App\Models\Funcionario;
use App\Models\Empresa;
use App\Models\Novedad;

use App\Http\Libs\Nomina\Calculos\CalculoSalario;
use App\Http\Libs\Nomina\Calculos\CalculoNovedades;
use App\Http\Libs\Nomina\PeriodoPago;

class NominaSalario extends PeriodoPago
{
    /**
     * Funcionario al cual se le calcula el salario
     *
     * @var  App\Funcionario
     */
    protected static $funcionario;

    /**
     * Instancia de la clase CalculoSalario
     *
     * @var App\Http\Libs\Nomina\Calculos\CalculoSalario;
     */
    protected $calculoSalario;

    /**
     * Instancia de la clase CalculoNovedades
     *
     * @var App\Http\Libs\Nomina\Calculos\CalculoNovedades;
     */
    protected $calculoNovedades;

    /**
     * Fecha de inicio del periodo de pago
     *
     * @var string
     */
    protected $fechaInicio;

    /**
     * Fecha de fin del periodo de pago
     *
     * @var string
     */
    protected $fechaFin;

    /**
     * Settea la propiedad funcionario filtrando al funcionario que se pase por el parámetro $id,
     * retorna una nueva instancia de la clase
     *
     * @param integer $id
     * @return NominaSalario
     */
    public static function salarioFuncionarioWithId($id)
    {
        self::$funcionario = Funcionario::findOrFail($id);
        return new self;
    }

    public function fromTo($fechaInicio, $fechaFin)
    {
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;

        $this->verifiyNovedadesFromTo($this->fechaInicio, $this->fechaFin);

        $this->calculoSalario = new CalculoSalario(
            self::$funcionario->salario,
            $this->calculoNovedades->getDias(),
            $this->fechaInicio,
            $this->fechaFin
        );

        return $this;
    }

    public function verifiyNovedadesFromTo($fechaInicio, $fechaFin)
    {
        $this->calculoNovedades = new CalculoNovedades(
            self::$funcionario->salario,
            $fechaInicio,
            $fechaFin
        );

        $this->calculoNovedades->existenVacaciones(
            Novedad::vacaciones(self::$funcionario, $fechaInicio)
        );

        $this->calculoNovedades->existenNovedades(
            Novedad::novedades(self::$funcionario, $fechaFin)->get()
        );
    }

    public function calculate()
    {
        $this->calculoSalario->verificarFechasContrato(self::$funcionario->fecha_ingreso, self::$funcionario->fecha_retiro);

        $this->calculoSalario->valorSubsidioTransporte = Empresa::first(['auxilio_transporte'])['auxilio_transporte'];

        $this->calculoSalario->calcularDiasTrabajados()->calcularSalarioDiasTrabajados();

        $this->calculoSalario->calcularTransporteDiasTrabajados(self::$funcionario->subsidio_transporte);

        return $this->calculoSalario->crearColeccion();
    }
}
