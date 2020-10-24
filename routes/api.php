<?php

//Rutas para la parte de registro e ingreso de usuarios de aplicación

use App\Http\Controllers\AdministrativoController;
use App\Http\Controllers\ArlController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BancosController;
use App\Http\Controllers\CajasCompensacionController;
use App\Http\Controllers\CargosController;
use App\Http\Controllers\CentroCostosController;
use App\Http\Controllers\CesantiasController;
use App\Http\Controllers\DeduccionesController;
use App\Http\Controllers\DependenciasController;
use App\Http\Controllers\DiariosController;
use App\Http\Controllers\EmpresaConfiguracionController;
use App\Http\Controllers\EmpresasController;
use App\Http\Controllers\EncuestaController;
use App\Http\Controllers\EpsController;
use App\Http\Controllers\FuncionariosContactoEmergenciaController;
use App\Http\Controllers\FuncionariosController;
use App\Http\Controllers\FuncionariosDocumentosController;
use App\Http\Controllers\FuncionariosExperienciaLaboralController;
use App\Http\Controllers\FuncionariosReferenciasController;
use App\Http\Controllers\HistorialPagosController;
use App\Http\Controllers\HorarioTurnosFijosController;
use App\Http\Controllers\HorarioTurnosRotativosController;
use App\Http\Controllers\HorasExtrasController;
use App\Http\Controllers\IndicadoresController;
use App\Http\Controllers\IngresosNPController;
use App\Http\Controllers\IngresosPController;
use App\Http\Controllers\JefesController;
use App\Http\Controllers\LiquidacionesController;
use App\Http\Controllers\LlegadasTardeController;
use App\Http\Controllers\NovedadesController;
use App\Http\Controllers\PagosNominaController;
use App\Http\Controllers\ParametrizacionController;
use App\Http\Controllers\ParametrosNominaController;
use App\Http\Controllers\PensionesController;
use App\Http\Controllers\ProvisionesController;
use App\Http\Controllers\ReporteHorariosController;
use App\Http\Controllers\TableroController;
use App\Http\Controllers\TiposContratosController;
use App\Http\Controllers\TurnosController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByPath;



Route::prefix('auth')->group(function () {

    // Loguear al usuario
    Route::post('login', [AuthController::class, 'login']);

    // Refrescar el JWT Token
    Route::get('refresh', [AuthController::class, 'refresh']);

    Route::get('me', [AuthController::class, 'me'])->middleware('auth:api');

    // Rutas privadas, requieren autenticáción previa
    Route::middleware('auth:api')->group(function () {
        //Obtener información del usuario
        Route::get('user', [AuthController::class, 'user']);
        // Logout del usuario de la aplicación
        Route::post('logout', [AuthController::class, 'logout']);
    });
});

Route::group([
    'prefix' => '/{tenant}',
    'middleware' => [InitializeTenancyByPath::class],
], function () {

    /** Rutas de Control de Asistencia */
    Route::post('/asistencia/validar', [AsistenciaController::class, 'validar']);

    /** Rutas del Módulo General (empresa) */
    Route::get('/general/empresa/datos', [EmpresasController::class, 'getDatos'])->middleware('auth:api');
    Route::get('/general/empresa/global', [EmpresasController::class, 'getGlobal']);
    Route::post('/general/empresa/crear', [EmpresasController::class, 'store']);
    Route::get('/general/empresa/mostrar', [EmpresasController::class, 'show']);
    Route::patch('/general/empresa/{id}/editar', [EmpresasController::class, 'update']);
    Route::delete('/general/empresa/{id}/eliminar', [EmpresasController::class, 'destroy']);

    /** Rutas del módulo de ARL */
    Route::get('arl/datos', [ArlController::class, 'index']);

    /** Ruta para obtener los bancos */
    Route::get('bancos/datos', [BancosController::class, 'index']);

    /** Rutas del Módulo de Configuracion de pagos de la empresa */
    Route::get('general/empresa/configuracion', [EmpresaConfiguracionController::class, 'index'])->middleware('auth:api');
    Route::get('/general/empresa/configuracion/{id}', [EmpresaConfiguracionController::class, 'show']);
    Route::post('/general/empresa/configuracion/crear', [EmpresaConfiguracionController::class, 'store']);
    Route::put('/general/empresa/configuracion/{id}/editar', [EmpresaConfiguracionController::class, 'update']);

    /** Rutas del Módulo de Centros de Costos */
    Route::get('/centros_costos/datos', [CentroCostosController::class, 'getDatos']);
    Route::get('/centros_costos/dependencias/datos', [CentroCostosController::class, 'getDatosWithDependencias']);
    Route::post('/centros_costos/crear', [CentroCostosController::class, 'store']);
    Route::get('/centros_costos/{id}/mostrar', [CentroCostosController::class, 'show']);
    Route::put('/centros_costos/{id}/editar', [CentroCostosController::class, 'update']);
    Route::delete('/centros_costos/{id}/eliminar', [CentroCostosController::class, 'destroy']);

    /** Rutas del módulo de Dependencias */
    Route::get('/dependencias/datos', [DependenciasController::class, 'getDatos']);
    Route::get('/dependencias/cargos/datos', [DependenciasController::class, 'getDatosWithCargos']);
    Route::post('/dependencias/crear', [DependenciasController::class, 'store']);
    Route::get('/dependencias/{id}/mostrar', [DependenciasController::class, 'show']);
    Route::put('/dependencias/{id}/editar', [DependenciasController::class, 'update']);
    Route::delete('/dependencias/{id}/eliminar', [DependenciasController::class, 'destroy']);

    /** Rutas del módulo de Cargos */
    Route::get('/cargos/datos', [CargosController::class, 'getDatos']);
    Route::post('/cargos/crear', [CargosController::class, 'store']);
    Route::get('/cargos/{id}/mostrar', [CargosController::class, 'show']);
    Route::put('/cargos/{id}/editar', [CargosController::class, 'update']);
    Route::delete('/cargos/{id}/eliminar', [CargosController::class, 'destroy']);

    /** Rutas del módulo de Turnos */
    Route::get('turnos/rotativos/datos', [TurnosController::class, 'getDatosTurnosRotativos']);
    Route::get('turnos/fijos/datos', [TurnosController::class, 'getDatosTurnosFijos']);
    Route::post('turnos/rotativo/crear', [TurnosController::class, 'storeTurnoRotativo']);
    Route::post('turnos/fijo/crear', [TurnosController::class, 'storeTurnoFijo']);
    Route::put('turnos/{id}/rotativo/editar', [TurnosController::class, 'updateTurnoRotativo']);
    Route::put('turnos/{id}/fijo/editar', [TurnosController::class, 'updateTurnoFijo']);
    Route::delete('turnos/{id}/rotativo/eliminar', [TurnosController::class, 'destroyTurnoRotativo']);
    Route::delete('turnos/{id}/fijo/eliminar', [TurnosController::class, 'destroyTurnoFijo']);

    /** Rutas del módulo de Eps */
    Route::get('/eps/datos', [EpsController::class, 'getDatos']);
    Route::post('/eps/crear', [EpsController::class, 'store']);
    Route::get('/eps/{id}/mostrar', [EpsController::class, 'show']);
    Route::put('/eps/{id}/editar', [EpsController::class, 'update']);
    Route::delete('/eps/{id}/eliminar', [EpsController::class, 'destroy']);

    /** Rutas del módulo de Cesantías */
    Route::get('/cesantias/datos', [CesantiasController::class, 'getDatos']);
    Route::post('/cesantias/crear', [CesantiasController::class, 'store']);
    Route::get('/cesantias/{id}/mostrar', [CesantiasController::class, 'show']);
    Route::put('/cesantias/{id}/editar', [CesantiasController::class, 'update']);
    Route::delete('/cesantias/{id}/eliminar', [CesantiasController::class, 'destroy']);

    /** Rutas del módulo de Pensiones */
    Route::get('/pensiones/datos', [PensionesController::class, 'getDatos']);
    Route::post('/pensiones/crear', [PensionesController::class, 'store']);
    Route::get('/pensiones/{id}/mostrar', [PensionesController::class, 'show']);
    Route::put('/pensiones/{id}/editar', [PensionesController::class, 'update']);
    Route::delete('/pensiones/{id}/eliminar', [PensionesController::class, 'destroy']);

    /** Rutas del módulo de Cajas de Compensación */
    Route::get('/compensaciones/datos', [CajasCompensacionController::class, 'getDatos']);
    Route::post('/compensaciones/crear', [CajasCompensacionController::class, 'store']);
    Route::get('/compensaciones/{id}/mostrar', [CajasCompensacionController::class, 'show']);
    Route::put('/compensaciones/{id}/editar', [CajasCompensacionController::class, 'update']);
    Route::delete('/compensaciones/{id}/eliminar', [CajasCompensacionController::class, 'destroy']);

    /** Rutas del módulo de Tipos de Contrato */
    Route::get('/contratos/datos', [TiposContratosController::class, 'getDatos']);
    Route::post('/contratos/crear', [TiposContratosController::class, 'store']);
    Route::get('/contratos/{id}/mostrar', [TiposContratosController::class, 'show']);
    Route::put('/contratos/{id}/editar', [TiposContratosController::class, 'update']);
    Route::delete('/contratos/{id}/eliminar', [TiposContratosController::class, 'destroy']);

    /** Rutas del módulo de Funcionarios */
    Route::get('funcionarios/datos', [FuncionariosController::class, 'getDatos']);
    Route::post('funcionarios/crear', [FuncionariosController::class, 'store']);
    Route::get('funcionarios/{identidad}/mostrar', [FuncionariosController::class, 'show']);
    Route::post('funcionarios/{id}/editar', [FuncionariosController::class, 'update']);
    Route::delete('funcionarios/{id}/eliminar', [FuncionariosController::class, 'destroy']);

    /** Rutas del módulo de Contactos de Emergencia de Funcionarios */
    Route::post('/funcionarios/{identidad}/contacto/crear', [FuncionariosContactoEmergenciaController::class, 'store']);
    Route::get('/funcionarios/{id}/contacto/mostrar', [FuncionariosContactoEmergenciaController::class, 'show']);
    Route::put('/funcionarios/{id}/contacto/{contactoId}/editar', [FuncionariosContactoEmergenciaController::class, 'update']);
    Route::delete('/funcionarios/{id}/contacto/eliminar', [FuncionariosContactoEmergenciaController::class, 'destroy']);


    /** Rutas del módulo de Experiencia Laboral para Funcionarios */
    Route::post('/funcionarios/{identidad}/experiencia/crear', [FuncionariosExperienciaLaboralController::class, 'store']);
    Route::get('/funcionarios/{id}/experiencia/mostrar', [FuncionariosExperienciaLaboralController::class, 'show']);
    Route::put('/funcionarios/{id}/experiencia/editar', [FuncionariosExperienciaLaboralController::class, 'edit']);
    Route::delete('/funcionarios/{id}/experiencia/eliminar', [FuncionariosExperienciaLaboralController::class, 'destroy']);

    /** Rutas del módulo de Referencias personales para Funcionarios */
    Route::post('/funcionarios/{identidad}/referencia/crear', [FuncionariosReferenciasController::class, 'store']);
    Route::get('/funcionarios/{id}/referencia/mostrar', [FuncionariosReferenciasController::class, 'show']);
    Route::put('/funcionarios/{id}/referencia/editar', [FuncionariosReferenciasController::class, 'edit']);
    Route::delete('/funcionarios/{id}/referencia/eliminar', [FuncionariosReferenciasController::class, 'destroy']);

    /** Rutas del módulo de documentos para Funcionarios */
    Route::post('/funcionarios/{identidad}/documento/crear', [FuncionariosDocumentosController::class, 'store']);

    /** Rutas para obetener, crear, eliminar jefes */
    Route::get('/jefes', [JefesController::class, 'index']);

    /** Rutas del Módulo de parametrización de la empresa */
    /** Salario y subsidio de transporte */
    Route::get('/parametrizacion/salario_subsidio/datos', [ParametrizacionController::class, 'salarioSubsidioDatos']);
    Route::put('/parametrizacion/salario_subsidio/{id}/editar', [ParametrizacionController::class, 'updateSalarioSubsidio']);
    /** Salario y subsidio de transporte */

    /** Ingresos */
    Route::get('/parametrizacion/ingresos_constitutivos/datos', [ParametrizacionController::class, 'ingresosConstitutivosDatos']);
    Route::get('/parametrizacion/ingresos_no_constitutivos/datos', [ParametrizacionController::class, 'ingresosNoConstitutivosDatos']);
    Route::post('/parametrizacion/ingresos/crear', [ParametrizacionController::class, 'storeIngresos']);
    Route::put('/parametrizacion/ingresos/{id}/editar', [ParametrizacionController::class, 'updateIngresos']);
    /** Ingresos */

    /** Licencias e incapacidades */
    Route::get('/parametrizacion/licencias_incapacidades/datos', [ParametrizacionController::class, 'licenciasIncapacidadesDatos']);
    Route::put('/parametrizacion/licencias_incapacidades/{id}/editar', [ParametrizacionController::class, 'updateLicenciasIncapacidades']);
    /** Licencias e incapacidades */

    /** Deducciones */
    Route::get('/parametrizacion/deducciones/datos', [ParametrizacionController::class, 'deduccionesDatos']);
    Route::post('/parametrizacion/deducciones/crear', [ParametrizacionController::class, 'storeDeducciones']);
    Route::put('/parametrizacion/deducciones/{id}/editar', [ParametrizacionController::class, 'updateDeducciones']);
    /** Deducciones */

    /** Prestaciones sociales */
    Route::get(
        '/parametrizacion/prestaciones_sociales/datos',
        [ParametrizacionController::class, 'prestacionesSocialesDatos']
    );
    Route::post(
        '/parametrizacion/prestaciones_sociales/crear',
        [ParametrizacionController::class, 'storePrestacionesSociales']
    );
    Route::put(
        '/parametrizacion/prestaciones_sociales/{id}/editar',
        [ParametrizacionController::class, 'updatePrestacionesSociales']
    );
    /** Prestaciones sociales */

    /** Seguridad social */
    Route::get('/parametrizacion/seguridad_social/datos', [ParametrizacionController::class, 'seguridadSocialDatos']);
    Route::post('/parametrizacion/seguridad_social/crear', [ParametrizacionController::class, 'storeSeguridadSocial']);
    Route::put('/parametrizacion/seguridad_social/{id}/editar', [ParametrizacionController::class, 'updateSeguridadSocial']);
    /** Seguridad social */

    /** Liquidación */
    Route::get('/parametrizacion/liquidacion/datos', [ParametrizacionController::class, 'liquidacionDatos']);
    Route::put('/parametrizacion/liquidacion/{id}/editar', [ParametrizacionController::class, 'updateLiquidacion']);
    /** Liquidación */

    /** Bancos Caja */
    Route::get('/parametrizacion/bancos_caja/datos', [ParametrizacionController::class, 'bancosCajaDatos']);
    Route::put('/parametrizacion/bancos_caja/{id}/editar', [ParametrizacionController::class, 'updateBancosCaja']);
    /** Bancos Caja */

    /** Parametrización nomina */
    Route::get('parametrizacion/nomina/extras', [ParametrosNominaController::class, 'horasExtrasDatos']);
    Route::get('parametrizacion/nomina/extras/porcentajes', [ParametrosNominaController::class, 'horasExtrasPorcentajes']);
    Route::put('parametrizacion/nomina/extras/{id}/editar', [ParametrosNominaController::class, 'updateHorasExtras']);
    Route::get('parametrizacion/nomina/ssocial_funcionario', [ParametrosNominaController::class, 'sSocialFuncionarioDatos']);
    Route::put('parametrizacion/nomina/ssocial_funcionario/{id}/editar', [ParametrosNominaController::class, 'updateSSocialFuncionario']);
    Route::get('parametrizacion/nomina/ssocial_empresa', [ParametrosNominaController::class, 'sSocialEmpresaDatos']);
    Route::put('parametrizacion/nomina/ssocial_empresa/{id}/editar', [ParametrosNominaController::class, 'updateSSocialEmpresa']);
    Route::get('parametrizacion/nomina/riesgos', [ParametrosNominaController::class, 'riesgosArlDatos']);
    Route::put('parametrizacion/nomina/riesgos/{id}/editar', [ParametrosNominaController::class, 'updateRiesgosArl']);
    Route::get('parametrizacion/nomina/parafiscales', [ParametrosNominaController::class, 'parafiscalesDatos']);
    Route::put('parametrizacion/nomina/parafiscales/{id}/editar', [ParametrosNominaController::class, 'updateParafiscales']);
    Route::get('parametrizacion/nomina/incapacidades', [ParametrosNominaController::class, 'incapacidadesDatos']);
    Route::put('parametrizacion/nomina/incapacidades/{id}/editar', [ParametrosNominaController::class, 'updateIncapacidades']);
    Route::get('parametrizacion/nomina/ssocial_empresa/porcentajes/{id}', [ParametrosNominaController::class, 'porcentajesSeguridadRiesgos']);
    /** Parametrización nomina */


    /** Rutas del módulo de asignación de turnos */
    Route::get('/horarios/datos', [HorarioTurnosRotativosController::class, 'getDatos']);
    Route::get('/horarios/datos/generales/{semana}', [HorarioTurnosRotativosController::class, 'getDatosGenerales']);
    Route::post('/horario/turno_rotativo/crear', [HorarioTurnosRotativosController::class, 'store']);
    Route::put('/horarios/{id}/editar', [HorarioTurnosRotativosController::class, 'update']);

    /** Rutas para el guardado de datos de la tabla horario_turno_fijo */
    Route::post('/horario/turno_fijo/crear', [HorarioTurnosFijosController::class, 'store']);
    Route::put('/horario/turno_fijo/{id}/editar', [HorarioTurnosFijosController::class, 'update']);
    Route::get('/horario/turno_fijo/datos/{turno}', [HorarioTurnosFijosController::class, 'getDatos']);

    /** Rutas del módulo de reporte de horarios */
    Route::get('/reporte/horarios/{fechaInicio}/{fechaFin}/turno_rotativo', [ReporteHorariosController::class, 'getDatosTurnoRotativo'])->where([
        'fechaInicio' => '[0-9]{4}-[0-9]{2}-[0-9]{2}',
        'fechaFin'    => '[0-9]{4}-[0-9]{2}-[0-9]{2}',
    ]);
    Route::get('/reporte/horarios/{fechaInicio}/{fechaFin}/turno_fijo', [ReporteHorariosController::class, 'getDatosTurnoFijo'])->where([
        'fechaInicio' => '[0-9]{4}-[0-9]{2}-[0-9]{2}',
        'fechaFin'    => '[0-9]{4}-[0-9]{2}-[0-9]{2}',
    ]);
    Route::get('reporte/horarios/funcionarios/turno_fijo', [ReporteHorariosController::class, 'getReporteFuncionariosTurnoFijo']);
    Route::get('reporte/horarios/funcionarios/turno_rotativo', [ReporteHorariosController::class, 'getReporteFuncionariosTurnoRotativo']);

    /** Rutas del módulo de novedades */
    Route::get('/novedades/datos/{fechaInicio}/{fechaFin}', [NovedadesController::class, 'getDatos'])->where([
        'fechaInicio' => '[0-9]{4}-[0-9]{2}-[0-9]{2}',
        'fechaFin'    => '[0-9]{4}-[0-9]{2}-[0-9]{2}',
    ]);
    Route::get('/novedades/funcionarios', [NovedadesController::class, 'getFuncionarios']);
    Route::get('/novedades/nombres_novedades', [NovedadesController::class, 'getNovedades']);
    Route::post('/novedades/crear', [NovedadesController::class, 'store']);
    Route::put('/novedades/{id}/editar', [NovedadesController::class, 'update']);
    Route::delete('/novedades/{id}/eliminar', [NovedadesController::class, 'destroy']);

    /** Rutas del módulo de llegadas tarde */
    Route::get('/llegadas_tarde/datos/{fechaInicio}/{fechaFin}', [LlegadasTardeController::class, 'getDatos'])->where([
        'fechaInicio' => '[0-9]{4}-[0-9]{2}-[0-9]{2}',
        'fechaFin'    => '[0-9]{4}-[0-9]{2}-[0-9]{2}',
    ]);
    Route::get('/llegadas_tarde/fecha/{fechaInicio}/{fechaFin}', [LlegadasTardeController::class, 'llegadasPorFecha'])->where([
        'fechaInicio' => '[0-9]{4}-[0-9]{2}-[0-9]{2}',
        'fechaFin'    => '[0-9]{4}-[0-9]{2}-[0-9]{2}',
    ]);

    Route::get('/llegadas_tarde/reporte/{fechaInicio}/{fechaFin}', [LlegadasTardeController::class, 'reporteLlegadas'])->where([
        'fechaInicio' => '[0-9]{4}-[0-9]{2}-[0-9]{2}',
        'fechaFin'    => '[0-9]{4}-[0-9]{2}-[0-9]{2}',
    ]);

    Route::get('/llegadas_tarde/reporte_pdf/{fechaInicio}/{fechaFin}', [LlegadasTardeController::class, 'reporteLlegadasPdf'])->where([
        'fechaInicio' => '[0-9]{4}-[0-9]{2}-[0-9]{2}',
        'fechaFin'    => '[0-9]{4}-[0-9]{2}-[0-9]{2}',
    ]);

    /** Rutas del módulo de validación de horas extras */
    Route::get('/horas_extras/turno_rotativo/{fechaInicio}/{fechaFin}', [HorasExtrasController::class, 'getDatosTurnoRotativo'])->where([
        'fechaInicio' => '[0-9]{4}-[0-9]{2}-[0-9]{2}',
        'fechaFin'    => '[0-9]{4}-[0-9]{2}-[0-9]{2}',
    ]);
    Route::get('/horas_extras/turno_fijo/{fechaInicio}/{fechaFin}', [HorasExtrasController::class, 'getDatosTurnoFijo'])->where([
        'fechaInicio' => '[0-9]{4}-[0-9]{2}-[0-9]{2}',
        'fechaFin'    => '[0-9]{4}-[0-9]{2}-[0-9]{2}',
    ]);
    Route::post('/horas_extras/crear', [HorasExtrasController::class, 'store']);
    Route::put('/horas_extras/{id}/actualizar', [HorasExtrasController::class, 'update']);
    Route::get('/horas_extras/datos/validados/{funcionario}/{fecha}', [HorasExtrasController::class, 'getDatosValidados'])->where([
        'fecha' => '[0-9]{4}-[0-9]{2}-[0-9]{2}',
    ]);

    /** Rutas para actualizar tabla de diarios */
    Route::put('/diarios/turno_rotativo/{id}/actualizar', [DiariosController::class, 'updateDiarioTurnoRotativo']);
    Route::put('/diarios/turno_fijo/{id}/actualizar', [DiariosController::class, 'updateDiarioTurnoFijo']);

    /** Rutas para el módulo Nómina */
    Route::post('nomina/pago/nomina', [PagosNominaController::class, 'store']);
    Route::delete('nomina/pago/{id}/eliminar', [PagosNominaController::class, 'destroy']);

    Route::get('nomina/pago/funcionarios/{identidad}', [PagosNominaController::class, 'getFuncionario']);
    Route::get('nomina/colilla/funcionarios/{id}/{fechaInicio}/{fechaFin}', [PagosNominaController::class, 'getColillaFuncionario']);
    Route::get('nomina/pago/ingresos_prestacionales', [PagosNominaController::class, 'getIngresosPrestacionales']);
    Route::get('nomina/pago/ingresos_no_prestacionales', [PagosNominaController::class, 'getIngresosNoPrestacionales']);
    Route::get('nomina/pago/funcionarios/{inicio?}/{fin?}', [PagosNominaController::class, 'getPagoFuncionarios']);
    Route::get('nomina/pago/{inicio?}/{fin?}', [PagosNominaController::class, 'getPagoNomina']);

    Route::get('nomina/extras/funcionarios/{id}/{fechaInicio}/{fechaFin}', [PagosNominaController::class, 'getExtrasTotales']);
    Route::get('nomina/novedades/funcionarios/{id}/{fechaInicio}/{fechaFin}', [PagosNominaController::class, 'getNovedades']);
    Route::get('nomina/ingresos/funcionarios/{id}/{fechaInicio}/{fechaFin}', [PagosNominaController::class, 'getIngresos']);
    Route::get('nomina/salario/funcionarios/{id}/{fechaInicio}/{fechaFin}', [PagosNominaController::class, 'getSalario']);
    Route::get('nomina/retenciones/funcionarios/{id}/{fechaInicio}/{fechaFin}', [PagosNominaController::class, 'getRetenciones']);
    Route::get('nomina/seguridad/funcionarios/{id}/{fechaInicio}/{fechaFin}', [PagosNominaController::class, 'getSeguridad']);
    Route::get('nomina/provisiones/funcionarios/{id}/{fechaInicio}/{fechaFin}', [PagosNominaController::class, 'getProvisiones']);
    Route::get('nomina/deducciones/funcionarios/{id}/{fechaInicio}/{fechaFin}', [PagosNominaController::class, 'getDeducciones']);
    Route::get('nomina/pago-neto/funcionarios/{id}/{fechaInicio}/{fechaFin}', [PagosNominaController::class, 'getPagoNeto']);

    /** Historial de pagos de nómina y funcionarios */
    Route::get('nomina/historial_pagos/nomina', [HistorialPagosController::class, 'getPagosNomina']);

    Route::get('nomina/provisiones/meses', [ProvisionesController::class, 'getMesesProvisiones']);
    Route::get('nomina/provisiones/{mes?}', [ProvisionesController::class, 'getProvisiones']);

    /** Liquidacion Funcionarios */
    Route::get('nomina/liquidaciones/funcionarios/{id}/mostrar/{fechaFin?}', [LiquidacionesController::class, 'get']);

    Route::post('nomina/liquidaciones/{id}/vacaciones_actuales', [LiquidacionesController::class, 'getWithVacacionesActuales']);

    Route::post('nomina/liquidaciones/{id}/salario_base', [LiquidacionesController::class, 'getWithSalarioBase']);

    Route::post('nomina/liquidaciones/{id}/bases', [LiquidacionesController::class, 'getWithBases']);
    Route::post('nomina/liquidaciones/{id}/ingresos', [LiquidacionesController::class, 'getWithIngresos']);
    Route::post('nomina/liquidaciones/previsualizacion', [LiquidacionesController::class, 'getPdfLiquidacion']);


    /** Rutas para crear y actualizar ingresos prestacionales */
    Route::post('/ingresos_prestacionales/crear', [IngresosPController::class, 'store']);
    Route::get('/ingresos_prestacionales/funcionarios/{id}', [IngresosPController::class, 'showFuncionario']);
    Route::delete('/ingresos_prestacionales/{id}/eliminar', [IngresosPController::class, 'destroy']);

    /** Rutas para crear y actualizar ingresos no prestacionales - similares pero se crean aparte ya que si cambia la estructura de alguna de las tablas, no se vería afectado, se puede optar por reutilizar un controlador para ambas si así se prefiere */
    Route::post('/ingresos_no_prestacionales/crear', [IngresosNPController::class, 'store']);
    Route::get('/ingresos_no_prestacionales/funcionarios/{id}', [IngresosNPController::class, 'showFuncionario']);
    Route::delete('/ingresos_no_prestacionales/{id}/eliminar', [IngresosNPController::class, 'destroy']);

    /** Rutas para obtener, crear y actualizar deducciones */
    Route::get('/deducciones', [DeduccionesController::class, 'index']);
    Route::post('/deducciones/crear', [DeduccionesController::class, 'store']);
    Route::get('/deducciones/funcionarios/{id}', [DeduccionesController::class, 'showFuncionario']);
    Route::delete('/deducciones/{id}/eliminar', [DeduccionesController::class, 'destroy']);


    /** Rutas indicadores */
    Route::get('indicadores/novedades/{fechaInicio}/{fechaFin}', [IndicadoresController::class, 'getNovedadesByCentros'])->where([
        'fechaInicio' => '[0-9]{4}-[0-9]{2}-[0-9]{2}',
        'fechaFin' => '[0-9]{4}-[0-9]{2}-[0-9]{2}',
    ]);
    Route::get('indicadores/novedades/{fechaInicio}/{fechaFin}/top', [IndicadoresController::class, 'getTopfuncionarios'])->where([
        'fechaInicio' => '[0-9]{4}-[0-9]{2}-[0-9]{2}',
        'fechaFin' => '[0-9]{4}-[0-9]{2}-[0-9]{2}',
    ]);
    Route::get('indicadores/novedades/{fechaInicio}/{fechaFin}/dependencias', [IndicadoresController::class, 'getNovedadesByDependencias'])->where([
        'fechaInicio' => '[0-9]{4}-[0-9]{2}-[0-9]{2}',
        'fechaFin' => '[0-9]{4}-[0-9]{2}-[0-9]{2}',
    ]);
    Route::get('indicadores/novedades/{fechaInicio}/{fechaFin}/tipo', [IndicadoresController::class, 'getNovedadesByTipo'])->where([
        'fechaInicio' => '[0-9]{4}-[0-9]{2}-[0-9]{2}',
        'fechaFin' => '[0-9]{4}-[0-9]{2}-[0-9]{2}',
    ]);

    Route::get('indicadores/tiempo/{fechaInicio}/{fechaFin}', [IndicadoresController::class, 'getLlegadasTardeByCentros'])->where([
        'fechaInicio' => '[0-9]{4}-[0-9]{2}-[0-9]{2}',
        'fechaFin' => '[0-9]{4}-[0-9]{2}-[0-9]{2}',
    ]);

    Route::get('indicadores/tiempo/{fechaInicio}/{fechaFin}/top_llegadas', [IndicadoresController::class, 'getTopFuncionariosByLlegadas'])->where([
        'fechaInicio' => '[0-9]{4}-[0-9]{2}-[0-9]{2}',
        'fechaFin' => '[0-9]{4}-[0-9]{2}-[0-9]{2}',
    ]);
    Route::get('indicadores/tiempo/{fechaInicio}/{fechaFin}/top_tiempo', [IndicadoresController::class, 'getTopFuncionariosByTiempo'])->where([
        'fechaInicio' => '[0-9]{4}-[0-9]{2}-[0-9]{2}',
        'fechaFin' => '[0-9]{4}-[0-9]{2}-[0-9]{2}',
    ]);

    Route::get('indicadores/tiempo/{fechaInicio}/{fechaFin}/dependencias', [IndicadoresController::class, 'getLlegadasByDependencias'])->where([
        'fechaInicio' => '[0-9]{4}-[0-9]{2}-[0-9]{2}',
        'fechaFin' => '[0-9]{4}-[0-9]{2}-[0-9]{2}',
    ]);

    /** Rutas Tablero principal */
    Route::get('tablero/llegadas_tarde/top', [TableroController::class, 'getTopFuncionariosByLlegadas']);
    Route::get('tablero/llegadas_tarde', [TableroController::class, 'getLlegadasByFecha']);
    Route::get('tablero/funcionarios/birthday', [TableroController::class, 'getBirthdayFuncionarios']);
    Route::get('tablero/funcionarios/contratos', [TableroController::class, 'getVencimientoContratos']);
    Route::get('tablero/indicadores', [TableroController::class, 'getIndicadores']);


    /** Rutas Administrativo */

    Route::get('administrativo/clientes', [AdministrativoController::class, 'getClientes']);
    Route::get('administrativo/graficaClientes', [AdministrativoController::class, 'getGraficaClientes']);
    Route::get('administrativo/tickets', [AdministrativoController::class, 'getTickets']);
    Route::get('administrativo/ticket/{id}', [AdministrativoController::class, 'getDetalleTicket']);
    Route::get('administrativo/mensajesticket/{id}', [AdministrativoController::class, 'getMensajesTicket']);


    /** */

    Route::get('encuestas/datos', [EncuestaController::class, 'getEncuestas']);
    Route::post('/encuestas/crear', [EncuestaController::class, 'store']);
    Route::delete('/encuestas/{id}/eliminar', [EncuestaController::class, 'destroy']);
    Route::post('/encuestas/responder', [EncuestaController::class, 'responder']);
    Route::get('encuestas/{id}/mostrar', [EncuestaController::class, 'getDatosEncuesta']);
    Route::get('encuestas/{id}/{fun}/{fecha}/validar', [EncuestaController::class, 'validarEncuesta']);
    Route::get('encuestas/respuestas/{id}/{inicio}/{fin}', [EncuestaController::class, 'getRespuestas']);
    Route::get('encuestas/indicadores/{id}/{inicio}/{fin}', [EncuestaController::class, 'getIndicadores']);

    /** Error 404 global para el backend */
    Route::fallback(function () {
        return response()->json([
            'message' => 'Página no encontrada. Si el error persiste, contacte a soporte@geneticapp.co'
        ], 404);
    });
});
