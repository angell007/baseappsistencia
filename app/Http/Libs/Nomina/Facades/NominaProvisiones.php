<?php

namespace App\Http\Libs\Nomina\Facades;

use App\Models\Funcionario;
use App\Models\Novedad;

use App\Http\Libs\Nomina\Calculos\CalculoProvisiones;
use App\Http\Libs\Nomina\PeriodoPago;

class NominaProvisiones extends PeriodoPago
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
     * Facade NominaSalario
     *
     * @var NominaSalario
     */
    protected $facadeSalario;

    /**
     * Facade NominaExtras
     *
     * @var NominaExtras
     */
    protected $facadeExtras;

    /**
     * Facade NominaNovedades
     *
     * @var NominaNovedades
     */
    protected $facadeNovedades;

    /**
     * Facade NominaRetenciones
     *
     * @var NominaRetenciones
     */
    protected $facadeRetenciones;

    /**
     * Instancia de la clase Calculo Provisiones
     *
     * @var CalculoProvisiones
     */
    protected $calculoProvisiones;


    /**
     * Settea la propiedad funcionario filtrando al funcionario que se pase por el parámetro $id,
     * retorna una nueva instancia de la clase 
     *
     * @param integer $id
     * @return NominaSalario
     */
    public static function provisionesFuncionarioWithId($id)
    {
        self::$funcionario = Funcionario::findOrFail($id);
        return new self;
    }

    public function fromTo($fechaInicio, $fechaFin)
    {
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;

        $this->facadeExtras = NominaExtras::extrasFuncionarioWithId(self::$funcionario->id)->fromTo($this->fechaInicio, $this->fechaFin);

        $this->facadeSalario = NominaSalario::salarioFuncionarioWithId(self::$funcionario->id)->fromTo($this->fechaInicio, $this->fechaFin)->calculate();

        $this->facadeNovedades = NominaNovedades::novedadesFuncionarioWithId(self::$funcionario->id)->fromTo($this->fechaInicio, $this->fechaFin)->calculate();

        $this->facadeRetenciones = NominaRetenciones::retencionesFuncionarioWithId(self::$funcionario->id)->fromTo($this->fechaInicio, $this->fechaFin)->calculate();

        return $this;
    }


    public function calculate()
    {
        $this->calculoProvisiones = new CalculoProvisiones(
            $this->facadeSalario['salario'],
            $this->facadeExtras['valor_total'],
            $this->facadeNovedades['novedades_totales'],
            $this->facadeRetenciones['retenciones']['Ingresos'],
            $this->facadeExtras['horas_extras_totales']['rn'],
            $this->facadeSalario['auxilio_transporte'],
        );

        $this->calculoProvisiones->calcularDiasPeriodo($this->fechaInicio, $this->fechaFin);
        $this->calculoProvisiones->calcularBase()->calcularBaseVacaciones();

        $this->calculoProvisiones->calcularDiasBaseVac(
            $this->facadeNovedades['novedades']
        );

        $this->calculoProvisiones->calcularDiasHabiles(
            Novedad::vacaciones(self::$funcionario, $this->fechaInicio)
        );

        $this->calculoProvisiones->calcularVacacionesPeriodo();

        $this->calculoProvisiones
            ->calcularCesantias()
            ->calcularInteresesCesantias()
            ->calcularVacaciones();

        $this->calculoProvisiones->calcularTotalProvisiones();

        return $this->calculoProvisiones->crearColeccion();
    }


    public function getProvisiones($id, $fechaInicio, $fechaFin)
    {

        $funcionario = Funcionario::findOrFail($id);

        $calculoProvisiones = new CalculoProvisiones(
            $this->getSalario($id, $fechaInicio, $fechaFin)['salario'],
            $this->getExtrasTotales($id, $fechaInicio, $fechaFin)['valor_total'],
            $this->getNovedades($id, $fechaInicio, $fechaFin)['novedades_totales'],
            $this->getRetenciones($id, $fechaInicio, $fechaFin)['retenciones']['Ingresos'],
            $this->getExtrasTotales($id, $fechaInicio, $fechaFin)['horas_extras_totales']['rn'],
            $this->getSalario($id, $fechaInicio, $fechaFin)['auxilio_transporte']
        );
        $calculoProvisiones->calcularDiasPeriodo($fechaInicio, $fechaFin);
        $calculoProvisiones->calcularBase()->calcularBaseVacaciones();
        $calculoProvisiones->calcularDiasBaseVac($this->getNovedades($id, $fechaInicio, $fechaFin)['novedades']);
        $calculoProvisiones->calcularDiasHabiles(Novedad::vacaciones($funcionario, $fechaInicio));
        $calculoProvisiones->calcularVacacionesPeriodo();
        $calculoProvisiones->calcularCesantias()->calcularInteresesCesantias()->calcularVacaciones();
        $calculoProvisiones->calcularTotalProvisiones();

        return $calculoProvisiones->crearColeccion();
    }
}
