<?php

namespace App\Http\Libs\Nomina\Facades;

use App\Models\Funcionario;
use App\Models\Empresa;

use App\Http\Libs\Nomina\Calculos\CalculoSeguridad;
use App\Http\Libs\Nomina\PeriodoPago;

class NominaSeguridad extends PeriodoPago
{
    /**
     * Funcionario al cual se le calcula el salario
     *
     * @var  App\Funcionario
     */
    protected static $funcionario;

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
     * Facade NominaRetenciones
     *
     * @var NominaRetenciones
     */
    protected $facadeRetenciones;

    /**
     * Facade NominaNovedades
     *
     * @var NominaNovedades
     */
    protected $facadeNovedades;

    /**
     * Instancia CalculoSeguridad
     *
     * @var CalculoSeguridad
     */
    protected $calculoSeguridad;

    /**
     * Settea la propiedad funcionario filtrando al funcionario que se pase por el parámetro $id,
     * retorna una nueva instancia de la clase 
     *
     * @param integer $id
     * @return NominaSalario
     */
    public static function seguridadFuncionarioWithId($id)
    {
        self::$funcionario = Funcionario::findOrFail($id);
        return new self;
    }

    public function fromTo($fechaInicio, $fechaFin)
    {
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;

        $this->facadeRetenciones = NominaRetenciones::retencionesFuncionarioWithId(self::$funcionario->id)
            ->fromTo($this->fechaInicio, $this->fechaFin)
            ->calculate();

        $this->facadeNovedades = NominaNovedades::novedadesFuncionarioWithId(self::$funcionario->id)
            ->fromTo($this->fechaInicio, $this->fechaFin)
            ->calculate();

        return $this;
    }

    public function calculate()
    {
        $salarioMinimo = Empresa::first()['salario_base'];

        $this->calculoSeguridad = new CalculoSeguridad(
            $this->facadeRetenciones['IBC_seguridad'],
            $this->facadeRetenciones['retenciones']['Salario'],
            self::$funcionario->salario,
            $this->facadeRetenciones['retenciones']['Horas extras'],
            $this->facadeRetenciones['retenciones']['Ingresos'],
            $this->facadeNovedades['novedades_totales']['Vacaciones'] ?? 0
        );

        $this->calculoSeguridad->calcularIbcRiesgos($salarioMinimo)->calcularIbcParafiscales();

        $this->calculoSeguridad->calcularPension()->calcularSalud(Empresa::first()['ley_1607'], $salarioMinimo)
            ->calcularRiesgos(self::$funcionario);

        $this->calculoSeguridad
            ->calcularSena(Empresa::first()['ley_1607'], $salarioMinimo)
            ->calcularIcbf(Empresa::first()['ley_1607'], $salarioMinimo)
            ->calcularCajaCompensacion();

        $this->calculoSeguridad
            ->calcularTotalSeguridadSocial()
            ->calcularTotalParafiscales();

        $this->calculoSeguridad->calcularTotal();

        return $this->calculoSeguridad->crearColeccion();
    }
}
