<template>
  <div class="container" v-if="mostrarCalculos">
    <resumen-colilla
      :salarioDatos="salarioDatos"
      :horasExtrasDatos="horasExtrasDatos"
      :novedadesDatos="novedadesDatos"
      :ingresosDatos="ingresosDatos"
      :retencionesDatos="retencionesDatos"
      :deduccionesDatos="deduccionesDatos"
      :netoApagar="netoApagar"
    ></resumen-colilla>

    <dias-trabajados :salarioDatos="salarioDatos" :novedadesDatos="novedadesDatos"></dias-trabajados>

    <salario :funcionario="funcionario" :salarioDatos="salarioDatos" :datosEmpresa="datosEmpresa"></salario>

    <extras-recargos
      :horasExtrasDatos="horasExtrasDatos"
      :porcentajesExtrasDatos="porcentajesExtrasDatos"
      :funcionario="funcionario"
    ></extras-recargos>

    <novedades
      :novedadesDatos="novedadesDatos"
      :datosEmpresa="datosEmpresa"
      :funcionario="funcionario"
    ></novedades>

    <ingresos :ingresosDatos="ingresosDatos"></ingresos>
    <retenciones :retencionesDatos="retencionesDatos"></retenciones>

    <deducciones :deduccionesDatos="deduccionesDatos"></deducciones>

    <p class="text-uppercase font-weight-bold text-muted">Para tener en cuenta:</p>

    <p>
      <small>Para efectos laborales, todos los meses tienen 30 días, y los días tienen 8 horas</small>
    </p>

    <p>
      <small>Si desea editar alguna de las configuraciones mencionadas para estos cálculos, puede ir al apartado de parametrización</small>
    </p>
  </div>
  <overlay v-else></overlay>
</template>

<script>
import ExtrasRecargos from './componentes/ExtrasRecargos'
import Salario from './componentes/Salario'
import Novedades from './componentes/Novedades'
import Ingresos from './componentes/Ingresos'
import DiasTrabajados from './componentes/DiasTrabajados'
import Retenciones from './componentes/Retenciones'
import Deducciones from './componentes/Deducciones'
import ResumenColilla from './componentes/ResumenColilla'
import Overlay from '../../../../utiles/Overlay'

export default {
  components: {
    ExtrasRecargos,
    Salario,
    Novedades,
    Ingresos,
    DiasTrabajados,
    Retenciones,
    Deducciones,
    ResumenColilla,
    Overlay,
  },
  props: {
    funcionarioProp: Object,
    datosEmpresaProp: Object,
    fechaInicio: String,
    fechaFin: String,
  },
  data() {
    return {
      funcionario: '',
      datosEmpresa: '',
      mostrarCalculos: false,
      horasExtrasDatos: '',
      porcentajesExtrasDatos: '',
      salarioDatos: '',
      novedadesDatos: '',
      ingresosDatos: '',
      retencionesDatos: '',
      deduccionesDatos: '',
      netoApagar: 0,
    }
  },
  created() {
    this.getUsuario()
  },
  methods: {
    getUsuario() {
      this.funcionario = this.funcionarioProp
      this.datosEmpresa = this.datosEmpresaProp
      this.getDatos()
    },
    getDatos() {
      axios
        .all([
          this.getHorasExtrasDatos(),
          this.getHorasExtrasPorcentajes(),
          this.getSalarioDiasTrabajados(),
          this.getNovedadesDatos(),
          this.getIngresosDatos(),
          this.getRetencionesDatos(),
          this.getDeduccionesDatos(),
          this.getPagoNeto(),
        ])
        .then(
          axios.spread(
            (
              extras,
              extrasP,
              salario,
              novedades,
              ingresos,
              retenciones,
              deducciones,
              pago
            ) => {
              this.horasExtrasDatos = extras.data
              this.porcentajesExtrasDatos = extrasP.data
              this.salarioDatos = salario.data
              this.novedadesDatos = novedades.data
              this.ingresosDatos = ingresos.data
              this.retencionesDatos = retenciones.data
              this.deduccionesDatos = deducciones.data
              this.netoApagar = pago.data.total_valor_neto
              this.mostrarCalculos = true
            }
          )
        )
    },
    getHorasExtrasDatos() {
      return axios.get(
        `/api/nomina/extras/funcionarios/${this.funcionario.id}/${
          this.fechaInicio
        }/${this.fechaFin}`
      )
    },
    getHorasExtrasPorcentajes() {
      return axios.get('/api/parametrizacion/nomina/extras/porcentajes')
    },
    getSalarioDiasTrabajados() {
      return axios.get(
        `/api/nomina/salario/funcionarios/${this.funcionario.id}/${
          this.fechaInicio
        }/${this.fechaFin}`
      )
    },
    getNovedadesDatos() {
      return axios.get(
        `/api/nomina/novedades/funcionarios/${this.funcionario.id}/${
          this.fechaInicio
        }/${this.fechaFin}`
      )
    },
    getIngresosDatos() {
      return axios.get(
        `/api/nomina/ingresos/funcionarios/${this.funcionario.id}/${
          this.fechaInicio
        }/${this.fechaFin}`
      )
    },
    getRetencionesDatos() {
      return axios.get(
        `/api/nomina/retenciones/funcionarios/${this.funcionario.id}/${
          this.fechaInicio
        }/${this.fechaFin}`
      )
    },
    getDeduccionesDatos() {
      return axios.get(
        `/api/nomina/deducciones/funcionarios/${this.funcionario.id}/${
          this.fechaInicio
        }/${this.fechaFin}`
      )
    },
    getPagoNeto() {
      return axios.get(
        `/api/nomina/pago-neto/funcionarios/${this.funcionario.id}/${
          this.fechaInicio
        }/${this.fechaFin}`
      )
    },
  },
}
</script>

<style scoped>
p small {
  font-size: 13.5px;
  font-weight: bold;
}
</style>
