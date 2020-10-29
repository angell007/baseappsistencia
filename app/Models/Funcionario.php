<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    protected $guarded = ['id'];
    protected $table = 'funcionario';

    protected $casts = [
        'subsidio_transporte' => 'boolean',
        'liquidado' => 'boolean'
    ];
    protected $hidden = ['created_at', 'updated_at'];


    /**
     * Un funcionario puede tener varios contactos de emergencia
     *
     * @return void
     */
    public function contactosEmergencia()
    {
        return $this->hasOne(FuncionarioContactoEmergencia::class);
    }

    /**
     * Un funcionario puede tener varias experiencias laborales
     *
     * @return void
     */
    public function experienciasLaborales()
    {
        return $this->hasMany(FuncionarioExperienciaLaboral::class);
    }

    /**
     * Un funcionario puede tener varios movimientos
     *
     * @return void
     */
    public function movimientos()
    {
        return $this->hasMany(FuncionarioMovimiento::class);
    }

    /**
     * Un funcionario puede tener varias referencias personales
     *
     * @return void
     */
    public function referenciasPersonales()
    {
        return $this->hasMany(FuncionarioReferenciaPersonal::class);
    }

    /**
     * Un funcionario puede tener varios documentos relacionados
     *
     * @return void
     */
    public function documentos()
    {
        return $this->hasMany(FuncionarioDocumento::class);
    }

    /**
     * Un funcionario puede tener varios horarios (1,2,3,4,5 ó 6 a la semana)
     *
     * @return void
     */
    public function horariosTurnoRotativo()
    {
        return $this->hasMany(HorarioTurnoRotativo::class);
    }
    /**
     * Un funcionario puede tener varios horarios (1,2,3,4,5 ó 6 a la semana)
     *
     * @return void
     */
    public function horariosTurnoFijo()
    {
        return $this->hasMany(HorarioTurnoFijo::class);
    }

    /**
     * Un funcionario puede tener varios diarios fijos (dias de un turno fijo) (1,2,3,4,5 ó 6 a la semana)
     *
     * @return void
     */
    public function diariosTurnoFijo()
    {
        return $this->hasMany(DiarioTurnoFijo::class);
    }

    public function diariosTurnoRotativo()
    {
        return $this->hasMany(DiarioTurnoRotativo::class);
    }

    /**
     * Un funcionario puede presentar más de una novedad
     *
     * @return void
     */
    public function novedades()
    {
        return $this->hasMany(Novedad::class);
    }

    /**
     * Un funcionario puede presentar más de una llegada tarde
     *
     * @return void
     */
    public function llegadasTarde()
    {
        return $this->hasMany(LlegadaTarde::class);
    }

    public function horas_extras()
    {
        return $this->hasMany(ReporteExtras::class);
    }

    public function ingresosPrestacionales()
    {
        return $this->hasMany(IngresoPrestacional::class);
    }

    public function ingresosNoPrestacionales()
    {
        return $this->hasMany(IngresoNoPrestacional::class, 'funcionario_id');
    }

    public function deducciones()
    {
        return $this->hasMany(Deduccion::class);
    }

    /**
     * Un funcionario pertenece a un turno
     *
     * @return void
     */
    public function turnoRotativo()
    {
        return $this->belongsTo(TurnoRotativo::class);
    }
    /**
     * Un funcionario pertenece a un turno
     *
     * @return void
     */
    public function turnoFijo()
    {
        return $this->belongsTo(TurnoFijo::class);
    }

    /**
     * Un funcionario pertenece a una dependencia
     *
     * @return void
     */
    public function dependencia()
    {
        return $this->belongsTo(Dependencia::class);
    }

    /**
     * Un funcionario tiene un cargo
     *
     * @return void
     */

    public function cargo()
    {
        return $this->belongsTo(Cargo::class);
    }

    /**
     * Un funcionario pertenece una Eps
     *
     * @return void
     */

    public function eps()
    {
        return $this->belongsTo(Eps::class);
    }

    /**
     * Un funcionario pertenece a un fondo de cesantias
     *
     * @return void
     */

    public function cesantias()
    {
        return $this->belongsTo(Cesantia::class);
    }


    /**
     * Un funcionario pertenece a un fondo de pensiones
     *
     * @return void
     */

    public function pensiones()
    {
        return $this->belongsTo(Pension::class);
    }

    /**
     * Un funcionario pertenece a una caja de compensaciones
     *
     * @return void
     */

    public function cajaCompensacion()
    {
        return $this->belongsTo(CajaCompensacion::class);
    }

    /**
     * Un funcionario tiene un tipo de contrato vigente en la empresa
     *
     * @return void
     */

    public function contrato()
    {
        return $this->belongsTo(TipoContrato::class, 'tipo_contrato_id');
    }


    public function getRouteKeyName()
    {
        return 'identidad';
    }
}
