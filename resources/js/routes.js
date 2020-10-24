import CargoPrincipal from './components/cargos/CargoPrincipal'
import CCompensacionPrincipal from './components/compensaciones/CCompensacionPrincipal'
import CentroCostosPrincipal from './components/centro_costos/CentroCostosPrincipal'
import CesantiasPrincipal from './components/cesantias/CesantiasPrincipal'
import DatosConfiguracion from './components/general/actualizacion/DatosConfiguracion'
import DatosExperiencia from './components/funcionarios/detalles/formularios/DatosExperiencia'
import DependenciaPrincipal from './components/dependencias/DependenciaPrincipal'
import DetallesFuncionario from './components/funcionarios/detalles/DetallesFuncionario'
import EmpresaFormulario from './components/general/registro/EmpresaFormulario'
import EpsPrincipal from './components/eps/EpsPrincipal'
import FormatosPrincipal from './components/formatos/FormatosPrincipal'
import FuncionariosPrincipal from './components/funcionarios/FuncionariosPrincipal'
import General from './components/general/General'
import HistorialPagos from './components/nomina/HistorialPagos'
import HorarioPrincipal from './components/horarios/HorarioPrincipal'
import HorasExtrasPrincipal from './components/horas_extras/HorasExtrasPrincipal'
import IndicadoresNovedades from './components/indicadores/IndicadoresNovedades'
import IndicadoresTiempo from './components/indicadores/IndicadoresTiempo'
import LlegadasTarde from './components/llegadas_tarde/LlegadasTarde'
import LiquidacionPrincipal from './components/nomina/liquidacion/LiquidacionPrincipal'
import Login from './components/Login'
import NominaFuncionario from './components/nomina/pago_nomina/calculos/NominaFuncionario'
import NovedadesPrincipal from './components/novedades/NovedadesPrincipal'
import PagoNomina from './components/nomina/pago_nomina/PagoNomina'
import Parametrizacion from './components/parametrizacion/Parametrizacion'
import PensionesPrincipal from './components/pensiones/PensionesPrincipal'
import ProvisionesPrincipal from './components/nomina/provisiones/ProvisionesPrincipal'
import RegistroFuncionario from './components/funcionarios/registro/RegistroFuncionario'
import ReporteHorarios from './components/reporte_horarios/ReporteHorarios'
import TableroPrincipal from './components/tableros/TableroPrincipal'
import TipoContratoPrincipal from './components/tipo_contratos/TipoContratoPrincipal'
import TurnoPrincipal from './components/turnos/TurnoPrincipal'
import TurnoFijoFormulario from './components/turnos/TurnoFijoFormulario'
import Asistencia from './components/asistencia/Asistencia'
import Clientes from './components/administrativo/clientes/Clientes'
import Soporte from './components/administrativo/soporte/Soporte'
import DetalleSoporte from './components/administrativo/soporte/DetalleSoporte'

import EncuestasPrincipal from './components/encuestas/EncuestasPrincipal'
import EncuestaFormulario from './components/encuestas/EncuestaFormulario'
import AplicarEncuesta from './components/encuestas/AplicarEncuesta'
import EncuestaVer from './components/encuestas/EncuestaVer'

export default {
  mode: 'history',
  routes: [
    {
      path: '/',
      redirect: '/login',
    },
    {
      path: '/login',
      component: Login,
      name: 'Login',
    },
    {
      path: '/tablero',
      component: TableroPrincipal,
      name: 'TableroPrincipal',
    },
    {
      path: '/cargos',
      component: CargoPrincipal,
      name: 'CargoPrincipal',
    },
    {
      path: '/dependencias',
      component: DependenciaPrincipal,
      name: 'DependenciaPrincipal',
    },
    { path: '/centros_costos', component: CentroCostosPrincipal },
    {
      path: '/turnos',
      component: TurnoPrincipal,
      name: 'TurnoPrincipal',
    },
    {
      path: '/turnos/fijos',
      component: TurnoFijoFormulario,
      props: true,
      name: 'TurnoFijoFormulario',
    },
    {
      path: '/contratos',
      component: TipoContratoPrincipal,
      name: 'TipoContratoPrincipal',
    },
    { path: '/eps', component: EpsPrincipal, name: 'EpsPrincipal' },
    {
      path: '/cesantias',
      component: CesantiasPrincipal,
      name: 'CesantiasPrincipal',
    },
    {
      path: '/pensiones',
      component: PensionesPrincipal,
      name: 'PensionesPrincipal',
    },
    {
      path: '/compensaciones',
      component: CCompensacionPrincipal,
      name: 'CCompensacionPrincipal',
    },
    {
      path: '/formatos',
      component: FormatosPrincipal,
      name: 'FormatosPrincipal',
    },
    {
      path: '/funcionarios',
      component: FuncionariosPrincipal,
      name: 'FuncionariosPrincipal',
    },
    {
      path: '/funcionarios/registro',
      component: RegistroFuncionario,
      name: 'RegistroFuncionario',
    },
    {
      path: '/funcionarios/detalles/:id',
      component: DetallesFuncionario,
      name: 'DetallesFuncionario',
    },
    {
      path: '/funcionarios/:id/experiencia/:experienciaId/editar',
      component: DatosExperiencia,
      name: 'DatosExperiencia',
    },
    {
      path: '/general/empresa',
      component: General,
      name: 'General',
    },
    {
      path: '/general/empresa/registro',
      component: EmpresaFormulario,
      name: 'EmpresaFormulario',
    },
    {
      path: '/general/empresa/{id}/configuracion/',
      component: DatosConfiguracion,
      name: 'DatosConfiguracion',
    },
    {
      path: '/parametrizacion',
      component: Parametrizacion,
      name: 'Parametrizacion',
    },
    {
      path: '/horarios',
      component: HorarioPrincipal,
      name: 'HorarioPrincipal',
    },
    {
      path: '/reporte/horarios',
      component: ReporteHorarios,
      name: 'ReporteHorarioMainComponent',
    },
    {
      path: '/novedades',
      component: NovedadesPrincipal,
      name: 'NovedadesPrincipal',
    },
    {
      path: '/llegadas_tarde',
      component: LlegadasTarde,
      name: 'LlegadasTarde',
    },
    {
      path: '/horas_extras',
      component: HorasExtrasPrincipal,
      name: 'HorasExtrasPrincipal',
    },
    {
      path: '/nomina/pago',
      component: PagoNomina,
      props: true,
      name: 'PagoNomina',
    },
    {
      path: '/nomina/pago/:identidad',
      component: NominaFuncionario,
      name: 'NominaFuncionario',
    },
    {
      path: '/nomina/historial-pagos',
      component: HistorialPagos,
      name: 'HistorialPagos',
    },
    {
      path: '/nomina/provisiones',
      component: ProvisionesPrincipal,
      name: 'ProvisionesPrincipal',
    },
    {
      path: '/indicadores/novedades',
      component: IndicadoresNovedades,
      name: 'IndicadoresNovedades',
    },
    {
      path: '/indicadores/tiempo',
      component: IndicadoresTiempo,
      name: 'IndicadoresTiempo',
    },
    {
        path: '/administrativo/clientes',
        component: Clientes,
        name: 'Clientes',
    },
    {
        path: '/administrativo/soporte',
        component: Soporte,
        name: 'Soporte',
    },
    {
        path: '/administrativo/soporte/detalles/:id',
        component: DetalleSoporte,
        name: 'DetalleSoporte',
    },
    {
      path: '/nomina/liquidaciones',
      component: LiquidacionPrincipal,
      props: true,
      name: 'LiquidacionPrincipal',
    },
    {
        path: '/asistencia',
        component: Asistencia,
        name: 'Asistencia',
    },
    {
        path: '/encuestas',
        component: EncuestasPrincipal,
        name: 'Encuestas',
    },
    {
        path: '/ae/:id',
        component: AplicarEncuesta,
        name: 'ae',
    },
    {
        path: '/crearencuesta',
        component: EncuestaFormulario,
        name: 'CrearEncuesta',
    },
    {
        path: '/encuesta/:id',
        component: EncuestaVer,
        name: 'EncuestaVer',
    },

    { path: '*', redirect: { name: 'TableroPrincipal' } },
  ],
}
