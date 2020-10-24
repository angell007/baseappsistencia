<?php

namespace App\Http\Libs\Nomina\Calculos;

use Illuminate\Support\Collection;

/** Clase para calcular las deducciones */
class CalculoDeducciones implements Coleccion
{
    protected $deducciones;
    protected $totalDeducciones;
    protected $deduccionesRegistradas;

    /**
     * Constructor
     *
     * @param Collection $deducciones
     */
    public function __construct(Collection $deducciones)
    {
        $this->deducciones = $deducciones;
        $this->deduccionesRegistradas = $this->deducciones->pluck('valor', 'deduccion.concepto');
        $this->totalDeducciones = 0;
    }

    public function getDeducciones()
    {
        return $this->deducciones;
    }

    /**
     * Retornar las deducciones registradas en el container (array)
     *
     * @return Array
     */
    public function getDeduccionesRegistradas()
    {
        if (collect($this->deduccionesRegistradas)->isEmpty()) {
            return null;
        }
        return $this->deduccionesRegistradas;
    }

    /**
     * Calcular el valor total de las deducciones
     *
     * @return void
     */
    public function calcularTotalDeducciones()
    {
        if ($this->deducciones->isNotEmpty()) {
            $this->totalDeducciones = $this->deducciones->sum('valor');
        }
    }

    /**
     * Getter para el total de las deducciones
     *
     * @return Array
     */
    public function getTotalDeducciones()
    {
        return $this->totalDeducciones;
    }

    /**
     * Aplicar el contract de la interfaz, crear la colección
     *
     * @return Illuminate\Support\Collection
     */
    public function crearColeccion()
    {
        return new Collection([
            'valor_total' => $this->getTotalDeducciones(),
            'deducciones' => $this->getDeduccionesRegistradas()
        ]);
    }
}
