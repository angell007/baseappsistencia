<template>
  <div class="row pt-3" :class="{ extra: extraValidada}" v-if="renderizarContenido">
    <div class="col-md-3">
      <p class="text-primary font-weight-bold m-0 p-0">{{nombreDeDia}} {{diario.fecha}}</p>
      <p class="m-0 p-0" v-if="turnoDato != '' && turnoDato != undefined">
        Turno:
        <b>{{turnoDato.hora_inicio_uno}} - {{turnoDato.hora_fin_uno}}</b>
      </p>
      <p class="m-0 p-0">
        Real:
        <b>{{formatoHoraMinuto(diario.hora_entrada_uno)}} - {{formatoHoraMinuto(diario.hora_salida_uno)}}</b>
      </p>
    </div>
    <div class="col-md-1 text-left pt-1">
      <a href="#" @click.prevent="mostrarModalDiario(diarioDato)">
        <i class="simple-icon-pencil pl-3"></i>
      </a>
    </div>
    <div class="col-md-1">
      <p class="pl-4 pt-2 custom-label">{{lista.horasTrabajadas}}</p>
    </div>
    <div class="col-md-1">
      <input
        type="number"
        min="0"
        class="form-control custom-control"
        v-model="lista.horasExtrasDiurnas"
      >
    </div>
    <div class="col-md-1">
      <input
        type="number"
        min="0"
        class="form-control custom-control"
        v-model="lista.horasExtrasNocturnas"
      >
    </div>
    <div class="col-md-1">
      <input
        type="number"
        min="0"
        class="form-control custom-control"
        v-model="lista.horasExtrasDiurnasFestivasDom"
      >
    </div>
    <div class="col-md-1">
      <input
        type="number"
        min="0"
        class="form-control custom-control"
        v-model="lista.horasExtrasNocturnasFestivasDom"
      >
    </div>
    <div class="col-md-1">
      <input
        type="number"
        min="0"
        class="form-control custom-control"
        v-model="lista.recargosNocturnos"
      >
    </div>
    <div class="col-md-1">
      <input
        type="number"
        min="0"
        class="form-control custom-control"
        v-model="lista.recargosFestivos"
      >
    </div>
    <div class="col-md-1 pr-4 pl-0">
      <a href="#" @click.prevent="makeRequestReporteExtras" title="Validar">
        <i class="simple-icon-check"></i>
      </a>
      <p class="custom-label" v-if="extraValidada">Validada</p>
    </div>
    <div
      class="modal fade"
      :id="'modalDiario'+ diarioDato.id"
      tabindex="-1"
      role="dialog"
      style="display: none;"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Editar horas</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group">
                <label for="hora_entrada_uno">Hora de Entrada</label>
                <input
                  type="time"
                  class="form-control custom-control"
                  v-model="diarioDato.hora_entrada_uno"
                  required
                >
              </div>
              <div class="form-group">
                <label for="hora_salida_uno">Hora de Salida</label>
                <input
                  type="time"
                  class="form-control custom-control"
                  v-model="diarioDato.hora_salida_uno"
                  required
                >
              </div>
              <div class="form-group text-right">
                <button type="button" class="btn btn-secondary raised" @click="putDiario">Actualizar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <overlay v-else></overlay>
</template>

<script>
import festivos from './Festivos.js'
import Overlay from '../utiles/Overlay'
import { RecargoValidator } from './clases/RecargoValidator'
import { ExtraValidator } from './clases/ExtraValidator'

export default {
  components: { Overlay },
  props: {
    funcionario: Object,
    diario: Object,
  },
  data() {
    return {
      funcionarioDato: this.funcionario,
      diarioDato: this.diario,
      turnoDato: this.diario.turno_rotativo,
      horaInicioNoche: moment.utc('21:00:00', 'HH:mm:ss'),
      horaFinNoche: moment.utc('06:00:00', 'HH:mm:ss'),
      recargoValidator: null,
      lista: {
        horasTrabajadas: 0,
        horasExtrasDiurnas: 0,
        horasExtrasDiurnasReales: 0,
        horasExtrasNocturnas: 0,
        horasExtrasNocturnasReales: 0,
        horasExtrasDiurnasFestivasDom: 0,
        horasExtrasDiurnasFestivasDomReales: 0,
        horasExtrasNocturnasFestivasDom: 0,
        horasExtrasNocturnasFestivasDomReales: 0,
        recargosNocturnos: 0,
        recargosNocturnosReales: 0,
        recargosFestivos: 0,
        recargosFestivosReales: 0,
      },

      actualizarHora: {
        hora_entrada_uno: '',
        hora_salida_uno: '',
      },
      festivos: festivos,
      extraValidada: false,
      renderizarContenido: false,
    }
  },
  created() {
    this.calculoGeneral()
    this.getExtrasValidadas(this.funcionarioDato.id, this.diarioDato.fecha)
    this.asignacionDatosReales()
  },
  methods: {
    asignacionDatosReales() {
      this.lista.horasExtrasDiurnasReales = this.lista.horasExtrasDiurnas
      this.lista.horasExtrasNocturnasReales = this.lista.horasExtrasNocturnas
      this.lista.horasExtrasDiurnasFestivasDomReales = this.lista.horasExtrasDiurnasFestivasDom
      this.lista.horasExtrasNocturnasFestivasDomReales = this.lista.horasExtrasNocturnasFestivasDom
      this.lista.recargosFestivosReales = this.lista.recargosFestivos
      this.lista.recargosNocturnosReales = this.lista.recargosNocturnos
    },
    calculoGeneral() {
      const tolerancia =
        this.turnoDato.tolerancia_salida - this.turnoDato.tolerancia_entrada

      const entradaTurno = moment.utc(
        this.turnoDato.hora_inicio_uno,
        'HH:mm:ss'
      )
      const salidaTurno = moment.utc(this.turnoDato.hora_fin_uno, 'HH:mm:ss')

      if (salidaTurno < entradaTurno) {
        salidaTurno.add(1, 'd')
      }

      const duracionSegunTurno = moment
        .duration(salidaTurno.diff(entradaTurno))
        .add(tolerancia, 'm')
        .as('hours')

      const entradaReportada = moment.utc(
        this.diarioDato.hora_entrada_uno,
        'HH:mm:ss'
      )
      const salidaReportada = moment.utc(
        this.diarioDato.hora_salida_uno,
        'HH:mm:ss'
      )

      if (salidaReportada < entradaReportada) {
        salidaReportada.add(1, 'd')
      }

      const duracionReal = moment
        .duration(salidaReportada.diff(entradaReportada))
        .asHours()

      if (Math.round(duracionReal) < Math.round(duracionSegunTurno)) {
        this.lista.horasTrabajadas = Math.round(duracionReal)
      } else {
        this.lista.horasTrabajadas = Math.round(duracionReal)
      }
      /** Calcular recargos nocturnos */
      const recargoValidator = new RecargoValidator(
        entradaReportada,
        salidaReportada,
        this.horaInicioNoche,
        this.horaFinNoche
      )
      this.lista.recargosNocturnos = recargoValidator.calculoRecargos()

      /** Calcular extras */
      const extraValidator = new ExtraValidator(
        entradaReportada,
        salidaReportada,
        this.horaInicioNoche,
        this.horaFinNoche
      )
      extraValidator.register(this.lista).withJornadaLaboral(8)
      extraValidator.calcularExtras()
    },

    getExtrasValidadas(funcionario, fecha) {
      axios
        .get(`/api/${localStorage.getItem('tenant')}/horas_extras/datos/validados/${funcionario}/${fecha}`)
        .then(datos => {
          this.extrasValidadas = datos.data
          this.extraValidada =
            this.extrasValidadas.fecha === this.diarioDato.fecha ? true : false
          // asignar todas las propiedades a la validación que viene desde la BD, ya que esta ya se encuentra almacenada y tiene prioridad sobre la que se cálcula y que no ha sido validada
          if (this.extraValidada) {
            this.lista.horasTrabajadas = this.extrasValidadas.ht
            this.lista.horasExtrasDiurnas = this.extrasValidadas.hed
            this.lista.horasExtrasNocturnas = this.extrasValidadas.hen
            this.lista.horasExtrasDiurnasFestivasDom = this.extrasValidadas.hedfd
            this.lista.horasExtrasNocturnasFestivasDom = this.extrasValidadas.hedfn
            this.lista.recargosNocturnos = this.extrasValidadas.rn
            this.lista.recargosFestivos = this.extrasValidadas.rf
            this.lista.horasExtrasDiurnasReales = this.extrasValidadas.hed_reales
            this.lista.horasExtrasNocturnasReales = this.extrasValidadas.hen_reales
            this.lista.horasExtrasDiurnasFestivasDomReales = this.extrasValidadas.hedfd_reales
            this.lista.horasExtrasNocturnasFestivasDomReales = this.extrasValidadas.hedfn_reales
            this.lista.recargosNocturnosReales = this.extrasValidadas.rn_reales
            this.lista.recargosFestivosReales = this.extrasValidadas.rf_reales
          }
          this.renderizarContenido = true
        })
        .catch(error => {
          //console.log(error.response.data)
        })
    },

    makeRequestReporteExtras() {
      this.$swal
        .fire({
          title: '¿Está seguro(a)?',
          text:
            'Va a realizar el guardado de validación de las horas extras del funcionario, asegúrese que todo coincida, esto afectará cálculos de nómina.',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, continuar!',
        })
        .then(respuesta => {
          if (respuesta.value) {
            let reporte = {
              funcionario_id: this.funcionarioDato.id,
              fecha: this.diarioDato.fecha,
              ht: this.lista.horasTrabajadas,
              hed: this.lista.horasExtrasDiurnas,
              hen: this.lista.horasExtrasNocturnas,
              hedfd: this.lista.horasExtrasDiurnasFestivasDom,
              hedfn: this.lista.horasExtrasNocturnasFestivasDom,
              rn: this.lista.recargosNocturnos,
              rf: this.lista.recargosFestivos,
              hed_reales: this.lista.horasExtrasDiurnasReales,
              hen_reales: this.lista.horasExtrasNocturnasReales,
              hedfd_reales: this.lista.horasExtrasDiurnasFestivasDomReales,
              hedfn_reales: this.lista.horasExtrasNocturnasFestivasDomReales,
              rn_reales: this.lista.recargosNocturnosReales,
              rf_reales: this.lista.recargosFestivosReales,
            }

            if (this.extraValidada) {
              axios
                .put(
                  `/api/${localStorage.getItem('tenant')}/horas_extras/${this.extrasValidadas.id}/actualizar`,
                  reporte
                )
                .then(respuesta => {
                  this.$swal.fire(
                    'Actualizada!',
                    'La validación de horas extras para ' +
                      this.funcionarioDato.nombres +
                      ' se ha actualizado',
                    'success'
                  )
                })
            } else {
              axios.post(`/api/${localStorage.getItem('tenant')}/horas_extras/crear`, reporte).then(respuesta => {
                this.$swal.fire(
                  'Guardada!',
                  'La validación de horas extras para ' +
                    this.funcionarioDato.nombres +
                    ' se ha registrado',
                  'success'
                )
                this.extraValidada = true
              })
            }

            //Actualizar datos en vista
            this.getExtrasValidadas(
              this.funcionarioDato.id,
              this.diarioDato.fecha
            )
          }
        })
    },

    putDiario() {
      axios
        .put(
          `/api/${localStorage.getItem('tenant')}/diarios/turno_rotativo/${this.diarioDato.id}/actualizar`,
          this.$data.diarioDato
        )
        .then(respuesta => {
          this.cerrarModalDiario(this.diarioDato)
          this.calculoGeneral()
        })
    },

    mostrarModalDiario(diario) {
      let modalId = `#modalDiario${diario.id}`

      setTimeout(() => {
        $(modalId).modal({
          backdrop: 'static',
          keyboard: false,
        })
      }, 300)
    },

    cerrarModalDiario(diario) {
      let modalId = `#modalDiario${diario.id}`

      $(modalId).modal('hide')
    },

    formatoHoraMinuto(valor) {
      return moment.utc(valor, 'HH:mm').format('HH:mm')
    },
  },
  computed: {
    nombreDeDia() {
      return (
        moment(this.diarioDato.fecha)
          .format('dddd')
          .charAt(0)
          .toUpperCase() +
        moment(this.diarioDato.fecha)
          .format('dddd')
          .slice(1)
      )
    },
  },
}
</script>

<style scoped>
.simple-icon-pencil,
.simple-icon-check {
  font-size: 18px;
  color: #227cf1;
}
.extra {
  background-color: #d7eefd;
  margin-right: 0px;
}
.row {
  margin-right: 0px;
}
</style>
