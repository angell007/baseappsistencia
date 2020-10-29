<template>
<div>
  <div class="container" v-if="!renderizar">
      <div class="alert alert-secondary">
        <p class="font-weight-bold">El módulo de Liquidaciones no se encuentra habilitado, favor comunicarse con soporte@geneticapp.co</p>
        </div>
  </div>
  <div class="container" v-if="renderizar">
    <h1 class="font-weight-bold">
      Liquidación |
      <span class="text-primary">{{funcionarioFullName}}</span>
    </h1>

    <hr class="separator">

    <form @submit.prevent>
      <div class="row">
        <div class="col-md-6 step-form pr-1 pt-2">
          <fieldset>
            <legend>1. Causas liquidación</legend>
            <div class="form-group row">
              <label class="custom-label col-form-label text-right col-5">Motivo de la Liquidación</label>
              <input type="text" class="form-control custom-control col-6">
            </div>
            <div class="form-group row">
              <label
                class="custom-label col-form-label text-right col-5"
              >¿Es liquidación sin justa causa?</label>
              <div class="form-check form-check-inline">
                <input
                  class="form-check-input"
                  type="checkbox"
                  id="inlineCheckbox1"
                  v-model="justaCausa"
                >
                <label class="form-check-label" for="inlineCheckbox1">{{withJustaCausa}}</label>
              </div>
            </div>
          </fieldset>
        </div>
        <div class="col-md-5 offset-1 step-form pr-1 pt-2">
          <fieldset>
            <legend>2. Fechas liquidación</legend>
            <div class="form-group row">
              <label class="custom-label col-form-label text-right col-5">Fecha inicio de contrato</label>
              <input
                type="text"
                class="form-control custom-control col-6"
                v-model="fechaIngreso"
                :disabled="true"
              >
            </div>
            <div class="form-group row">
              <label class="custom-label col-form-label text-right col-5">Fecha fin de contrato</label>
              <!-- <input type="text" class="form-control custom-control col-6" v-model="fechaRetiro"> -->

              <calendario
                customWidth="240"
                :fecha="fechaRetiro"
                :fechaMaxima="fechaFinMaxima"
                :fechaMinima="fechaFinMinima"
                @change="changeFechaFin($event)"
                ref="calendario"
              ></calendario>
            </div>
            <div class="form-group row">
              <label class="custom-label col-form-label text-right col-5">Días a liquidar</label>
              <input
                type="text"
                class="form-control custom-control col-6"
                v-model="funcionario.dias_liquidacion"
                :disabled="true"
              >
            </div>
            <div class="form-group row">
              <label class="custom-label col-form-label text-right col-5">Vacaciones hasta la fecha</label>
              <input
                type="text"
                class="form-control custom-control col-6"
                name="vacaciones_acumuladas"
                v-validate="'required|decimal:3|min_value:0'"
                data-vv-as="Vacaciones acumuladas"
                v-model="funcionario.vacaciones_actuales"
                @blur="postWithVacacionesActuales(funcionario.vacaciones_actuales, $refs.calendario.fechaSeleccionada)"
              >
              <small
                class="invalid col-6 offset-5"
                v-if="errors.has('vacaciones_acumuladas')"
              >{{errors.first('vacaciones_acumuladas')}}</small>
            </div>
            <div class="form-group row">
              <label
                class="custom-label col-form-label text-right col-5"
              >Vacaciones acumuladas último periodo</label>
              <input
                type="text"
                class="form-control custom-control col-6"
                v-model="funcionario.vacaciones_ultimo_periodo"
                :disabled="true"
              >
            </div>
          </fieldset>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-md-6 step-form pr-1 pt-2">
          <fieldset>
            <legend>3. Bases liquidación</legend>
            <div class="form-group row">
              <label class="custom-label col-form-label text-right col-5">Salario base</label>
              <input
                type="text"
                class="form-control custom-control col-6"
                v-model="funcionario.salario"
                @blur="postWithSalarioBase(funcionario.salario, $refs.calendario.fechaSeleccionada)"
              >
            </div>
            <div class="form-group row">
              <label class="custom-label col-form-label text-right col-5">Base vacaciones</label>
              <input
                type="text"
                class="form-control custom-control col-6"
                v-model="funcionario.base_vacaciones"
                @blur="postWithBases"
              >
            </div>
            <div class="form-group row">
              <label class="custom-label col-form-label text-right col-5">Base cesantías</label>
              <input
                type="text"
                class="form-control custom-control col-6"
                v-model="funcionario.base_cesantias"
                @blur="postWithBases"
              >
            </div>
            <div class="form-group row">
              <label class="custom-label col-form-label text-right col-5">Base prima</label>
              <input
                type="text"
                class="form-control custom-control col-6"
                v-model="funcionario.base_prima"
                @blur="postWithBases"
              >
            </div>
          </fieldset>
        </div>
        <div class="col-md-5 offset-1 step-form pr-1 pt-2">
          <fieldset>
            <legend>4. Otros ingresos / egresos</legend>
            <div class="form-group row">
              <label class="custom-label col-form-label text-right col-5">Otros ingresos</label>
              <input
                type="number"
                class="form-control custom-control col-6"
                v-model="funcionario.total_ingresos"
                @blur="postWithIngresos(funcionario.total_ingresos, funcionario.total_egresos)"
              >
            </div>
            <div class="form-group row">
              <label class="custom-label col-form-label text-right col-5">Otros egresos</label>
              <input
                type="text"
                class="form-control custom-control col-6"
                v-model="funcionario.total_egresos"
                @blur="postWithIngresos(funcionario.total_ingresos, funcionario.total_egresos)"
              >
            </div>
          </fieldset>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-md-9 offset-1">
          <fieldset>
            <legend>5. Comentarios</legend>
            <div class="form-group row">
              <label class="custom-label col-form-label text-right col-2">Observaciones</label>
              <textarea class="form-control custom-control col-10" cols="30" rows="5"></textarea>
            </div>
          </fieldset>
        </div>
      </div>

      <div class="row jumbotron">
        <div class="col-md-6">
          <h5>6. Resumen liquidación</h5>
          <table class="table">
            <tbody>
              <tr>
                <td class="custom-label">Vacaciones</td>
                <td class="custom-label">{{funcionario.total_vacaciones | moneda}}</td>
              </tr>
              <tr>
                <td class="custom-label">Cesantías</td>
                <td class="custom-label">{{funcionario.total_cesantias | moneda}}</td>
              </tr>
              <tr>
                <td class="custom-label">Intereses cesantías</td>
                <td class="custom-label">{{funcionario.total_intereses_cesantias | moneda}}</td>
              </tr>
              <tr>
                <td class="custom-label">Prima de servicios</td>
                <td class="custom-label">{{funcionario.total_prima | moneda}}</td>
              </tr>
              <tr>
                <td class="custom-label">Indemnización por despido</td>
                <td
                  class="custom-label"
                  v-if="justaCausa"
                >{{funcionario.total_indemnizacion | moneda}}</td>
                <td class="custom-label" v-else>0</td>
              </tr>
              <tr>
                <td class="custom-label">Otros</td>
                <td class="custom-label">{{otrosIngresos}}</td>
              </tr>
              <tr>
                <td class="custom-label">
                  <em>Total liquidación</em>
                </td>
                <td
                  class="custom-label"
                  v-if="justaCausa"
                >{{funcionario.total_liquidacion_indemnizacion | moneda }}</td>
                <td class="custom-label" v-else>{{funcionario.total_liquidacion | moneda }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="col-md-6">
          <h4>7. Previsualización</h4>
          <div class="d-flex flex justify-content-center">
            <a
              href="#"
              class="btn btn-link"
              @click.prevent="postPdfLiquidacion"
            >Previsualizar liquidación</a>
            <a href="#" class="btn btn-link">Descargar pagos salariales</a>
          </div>
          <h3>8. Liquidar empleado</h3>
          <p class="text-justify">
            Al confirmar la liquidación, el empleado no volverá a aparecer en la lista de empleados activos, ni en el siguiente pago de nómina.
            Si luego deseas editar algo o reincorporar nuevamente el empleado, lo podrás hacer desde la sección "Empleados
          </p>

          <div class="form-group text-center">
            <button type="submit" class="btn btn-secondary raised">Liquidar empleado</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
</template>

<script>
import Calendario from '../../utiles/Calendario'
export default {
  components: { Calendario },
  data() {
    return {
      funcionario: '',
      fechaFinMaxima: moment()
        .endOf('month')
        .add(1, 'd')
        .format('YYYY-MM-DD'),
      fechaFinMinima: moment()
        .startOf('month')
        .format('YYYY-MM-DD'),
      renderizar: false,
      lastIngresos: '',
      justaCausa: false,
      salarioPendiente: false,
    }
  },
  created() {
    if (this.$route.params['id']) {
      this.get()
    } else {
      //this.$router.push('/funcionarios')
    }
  },

  methods: {
    get(fechaFin = null) {
      let requestServer = null
      if (!fechaFin) {
        requestServer = axios.get(
          `/api/${localStorage.getItem('tenant')}/nomina/liquidaciones/funcionarios/${
            this.$route.params['id']
          }/mostrar`
        )
      } else {
        requestServer = axios.get(
          `/api/${localStorage.getItem('tenant')}/nomina/liquidaciones/funcionarios/${
            this.$route.params['id']
          }/mostrar/${fechaFin}`
        )
      }
      requestServer.then(datos => {
        this.funcionario = datos.data
        this.fechaFinMinima = this.funcionario.ultimo_periodo.fecha_fin
          ? moment(this.funcionario.ultimo_periodo.fecha_fin)
          : this.fechaFinMinima
        this.renderizar = true
      })
    },

    postWithVacacionesActuales(diasAcumulados, fechaFin) {
      const fechaFinContrato = moment(fechaFin).format('YYYY-MM-DD')
      axios
        .post(
          `/api/${localStorage.getItem('tenant')}/nomina/liquidaciones/${
            this.$route.params['id']
          }/vacaciones_actuales`,
          { diasAcumulados, fechaFin }
        )
        .then(datos => {
          this.resetAfterUpdate(datos)
        })
    },

    postWithSalarioBase(salarioBase, fechaFin) {
      const fechaFinContrato = moment(fechaFin).format('YYYY-MM-DD')
      axios
        .post(
          `/api/${localStorage.getItem('tenant')}/nomina/liquidaciones/${this.$route.params['id']}/salario_base`,
          { salarioBase, fechaFin }
        )
        .then(datos => {
          this.resetAfterUpdate(datos)
        })
    },

    postWithBases() {
      axios
        .post(`/api/${localStorage.getItem('tenant')}/nomina/liquidaciones/${this.$route.params['id']}/bases`, {
          fechaRetiro: moment(this.$refs.calendario.fechaSeleccionada).format(
            'YYYY-MM-DD'
          ),
          salarioBase: this.funcionario.salario,
          baseVacaciones: this.funcionario.base_vacaciones,
          baseCesantias: this.funcionario.base_cesantias,
          basePrima: this.funcionario.base_prima,
        })
        .then(datos => {
          this.resetAfterUpdate(datos)
        })
    },

    postWithIngresos(ingresos, egresos) {
      axios
        .post(
          `/api/${localStorage.getItem('tenant')}/nomina/liquidaciones/${this.$route.params['id']}/ingresos`,
          { ingresos, egresos }
        )
        .then(datos => {
          this.resetAfterUpdate(datos)
        })
    },

    postPdfLiquidacion() {
      axios({
        method: 'post',
        responseType: 'arraybuffer',
        url: `/api/${localStorage.getItem('tenant')}/nomina/liquidaciones/previsualizacion`,
        data: { funcionario: this.funcionario },
      }).then(respuesta => {
        let blob = new Blob([respuesta.data], { type: 'application/pdf' })
        let link = document.createElement('a')
        link.href = window.URL.createObjectURL(blob)
        link.download = `${this.funcionario.nombres}_${
          this.funcionario.apellidos
        }_liq.pdf`
        link.click()
      })
    },

    /** Se dispara cuando se cambia la fecha del componente calendario */
    changeFechaFin(fecha) {
      const fechaFinContrato = moment(fecha).format('YYYY-MM-DD')
      this.get(fechaFinContrato)
    },

    resetAfterUpdate(datos) {
      this.funcionario = datos.data
      this.fechaFinMinima = this.funcionario.ultimo_periodo.fecha_fin
        ? moment(this.funcionario.ultimo_periodo.fecha_fin)
        : this.fechaFinMinima
    },
  },

  computed: {
    funcionarioFullName() {
      return `${this.funcionario.nombres} ${this.funcionario.apellidos}`
    },
    fechaIngreso() {
      return moment(this.funcionario.fecha_ingreso).format('DD/MM/YYYY')
    },
    fechaRetiro() {
      return moment(this.funcionario.fecha_retiro).format('YYYY-MM-DD')
    },
    otrosIngresos() {
      return (
        Number.parseInt(this.funcionario.total_ingresos) -
        Number.parseInt(this.funcionario.total_egresos)
      )
    },

    withJustaCausa() {
      return this.justaCausa === true ? 'Si' : 'No'
    },
  },
}
</script>

<style scoped>
legend,
h5,
h4,
h3 {
  font-size: 1.1rem;
  font-family: 'Montserrat';
  color: #2a93d5;
  font-weight: bold;
}
.jumbotron {
  background-color: #fff;
}
.step-form {
  background-color: rgb(243, 243, 243);
}
.btn-link {
  color: #7860aa;
  font-weight: bold;
}
</style>
