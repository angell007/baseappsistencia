<template>
  <div class="row pt-3" :class="{ extra: validada}">
    <div class="col-md-3">
      <p class="text-primary font-weight-bold m-0 p-0">{{nombreDeDia}} {{diario.fecha}}</p>
      <p class="m-0 p-0" v-if="turnoDato != '' && turnoDato != undefined">
        Turno:
        <b>{{turnoDato.hora_inicio_uno}} - {{turnoDato.hora_fin_uno}} y {{turnoDato.hora_inicio_dos}} - {{turnoDato.hora_fin_dos}}</b>
      </p>
      <p class="m-0 p-0">
        Real:
        <b>{{horaMinutos(diario.hora_entrada_uno)}} - {{horaMinutos(diario.hora_salida_uno)}} y {{horaMinutos(diario.hora_entrada_dos)}} - {{horaMinutos(diario.hora_salida_dos)}}</b>
      </p>
    </div>
    <div class="col-md-1 text-left">
      <a href="#" @click.prevent="mostrarModalDiarioFijo(diarioDato)" title="Editar">
        <i class="simple-icon-pencil"></i>
      </a>
    </div>

    <div class="col-md-1">
      <p class="pl-4 pt-2">{{lista.horasTrabajadas}}</p>
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
      <a href="#" @click.prevent="guardarReporteDeExtras" title="Validar">
        <i class="simple-icon-check"></i>
      </a>
      <p class="text-success font-weight-bold text-muted" v-if="validada">Validada</p>
    </div>
    <div
      class="modal fade"
      :id="'modalDiarioFijo'+ diarioDato.id"
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
                <label class="custom-label" for="hora_entrada_uno">Hora de Entrada Uno</label>
                <input
                  type="time"
                  class="form-control custom-control"
                  v-model="diarioDato.hora_entrada_uno"
                >
              </div>
              <div class="form-group">
                <label class="custom-label" for="hora_salida_uno">Hora de Salida Uno</label>
                <input
                  type="time"
                  class="form-control custom-control"
                  v-model="diarioDato.hora_salida_uno"
                >
              </div>
              <div class="form-group">
                <label class="custom-label" for="hora_entrada_uno">Hora de Entrada Dos</label>
                <input
                  type="time"
                  class="form-control custom-control"
                  v-model="diarioDato.hora_entrada_dos"
                >
              </div>
              <div class="form-group">
                <label class="custom-label" for="hora_salida_uno">Hora de Salida Dos</label>
                <input
                  type="time"
                  class="form-control custom-control"
                  v-model="diarioDato.hora_salida_dos"
                >
              </div>
              <div class="form-group text-right">
                <button
                  type="button"
                  class="btn btn-secondary raised"
                  @click="actualizarDiarioFijo"
                >Actualizar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    funcionario: Object,
    diario: Object,
  },
  data() {
    return {
      funcionarioDato: this.funcionario,
      diarioDato: this.diario,
      horaInicioNoche: moment.utc('21:00:00', 'HH:mm:ss'),
      horaFinNoche: moment.utc('06:00:00', 'HH:mm:ss'),
      turnoDato: '',
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
      extrasValidadas: '',
      validada: false,
      esVisible: false,
    }
  },
  mounted() {
    this.cargarExtrasValidadas(this.funcionarioDato.id, this.diarioDato.fecha)
    this.relacionarConHoraTurno()
    this.calcularHorasTrabajadas()
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

    calcularHorasTrabajadas() {
      /** Tolerancia */
      let tolerancia =
        this.diarioDato.turno_fijo.tolerancia_salida -
        this.diarioDato.turno_fijo.tolerancia_entrada
      /** Turno */

      // let turnoCorrespondiente = this.diarioDato.turno_fijo.horarios_turno_fijo.find(horario=> {
      //     return this.nombreDeDia === horario.dia
      // })

      let entradaUnoTurno = moment.utc(
        this.turnoDato.hora_inicio_uno,
        'HH:mm:ss'
      )
      let salidaUnoTurno = moment.utc(this.turnoDato.hora_fin_uno, 'HH:mm:ss')
      let entradaDosTurno = moment.utc(
        this.turnoDato.hora_inicio_dos,
        'HH:mm:ss'
      )
      let salidaDosTurno = moment.utc(this.turnoDato.hora_fin_dos, 'HH:mm:ss')

      if (salidaUnoTurno < entradaUnoTurno) {
        salidaUnoTurno.add(1, 'd')
      }

      if (salidaDosTurno < entradaDosTurno) {
        salidaDosTurno.add(1, 'd')
      }

      let duracionUnoTurno = moment
        .duration(salidaUnoTurno.diff(entradaUnoTurno))
        .asHours()
      let duracionUnoTurnoTolerancia = moment
        .duration(salidaUnoTurno.diff(entradaUnoTurno))
        .add(tolerancia, 'm')
        .asHours()
      let duracionDosTurno = moment
        .duration(salidaDosTurno.diff(entradaDosTurno))
        .asHours()
      let duracionTotalTurnoTolerancia =
        duracionUnoTurnoTolerancia + duracionDosTurno
      let duraciontotalTurno = duracionUnoTurno + duracionDosTurno
      /** Turno */

      /** Reales */
      let entradaUno = moment.utc(this.diarioDato.hora_entrada_uno, 'HH:mm:ss')
      let salidaUno = moment.utc(this.diarioDato.hora_salida_uno, 'HH:mm:ss')
      let entradaDos = moment.utc(this.diarioDato.hora_entrada_dos, 'HH:mm:ss')
      let salidaDos = moment.utc(this.diarioDato.hora_salida_dos, 'HH:mm:ss')

      if (salidaUno < entradaUno) {
        salidaUno.add(1, 'd')
      }

      if (salidaDos < entradaDos) {
        salidaDos.add(1, 'd')
      }

      let duracionUno = moment.duration(salidaUno.diff(entradaUno)).asHours()
      let duracionDos = moment.duration(salidaDos.diff(entradaDos)).asHours()
      let duracionTotal = duracionUno + duracionDos
      /** Reales */

      if (
        Math.round(duracionTotalTurnoTolerancia) > Math.round(duracionTotal)
      ) {
        this.lista.horasTrabajadas = Math.round(duraciontotalTurno)
      } else {
        this.lista.horasTrabajadas = Math.round(duracionTotal)
      }
      /** Cálculo de horas extras */
      this.calcularExtras(entradaUno, salidaUno, entradaDos, salidaDos)
    },

    calcularExtras(
      horaEntradaUno,
      horaSalidaUno,
      horaEntradaDos,
      horaSalidaDos
    ) {
      let entradaUno = horaEntradaUno.clone()
      let salidaUno = horaSalidaUno.clone()
      let entradaDos = horaEntradaDos.clone()
      let salidaDos = horaSalidaDos.clone()
      let diferencia = 0
      let contadorExtrasDiurnas = 0
      let contadorExtrasNocturnas = 0
      let jornadaLaboralOrdinaria = 8
      let horasRealesLaboradas =
        Math.round(moment.duration(salidaUno.diff(entradaUno)).asHours()) +
        Math.round(moment.duration(salidaDos.diff(entradaDos)).asHours())

      let horaInicioDiurna = moment
        .utc('06:00:00', 'HH:mm:ss')
        .format('HH:mm:ss')
      let horaFinDiurna = moment.utc('21:00:00', 'HH:mm:ss').format('HH:mm:ss')

      let entradaUnoFormato = entradaUno.format('HH:mm:ss')
      let salidaUnoFormato = salidaUno.format('HH:mm:ss')
      let entradaDosFormato = entradaDos.format('HH:mm:ss')
      let salidaDosFormato = salidaDos.format('HH:mm:ss')

      if (horasRealesLaboradas > jornadaLaboralOrdinaria) {
        diferencia = horasRealesLaboradas - jornadaLaboralOrdinaria

        //Diurnas
        if (
          entradaUnoFormato > horaInicioDiurna &&
          salidaUnoFormato < horaFinDiurna
        ) {
          if (
            entradaDos.format('HH:mm:ss') > horaInicioDiurna &&
            salidaDos.format('HH:mm:ss') < horaFinDiurna
          ) {
            this.lista.horasExtrasDiurnas = diferencia
            //Nocturnas
          } else if (
            entradaDosFormato > horaInicioDiurna &&
            salidaDosFormato > horaFinDiurna
          ) {
            let diferenciaNocturnas = Math.round(
              moment
                .duration(
                  moment(salidaDosFormato, 'HH:mm:ss').diff(
                    moment(horaFinDiurna, 'HH:mm:ss')
                  )
                )
                .asHours()
            )
            this.lista.horasExtrasNocturnas = diferenciaNocturnas
            this.lista.horasExtrasDiurnas = Math.abs(
              diferencia - this.lista.horasExtrasNocturnas
            )
          }
        }
      }
    },

    relacionarConHoraTurno() {
      let turno = this.diarioDato.turno_fijo.horarios_turno_fijo.find(
        horario => {
          return this.nombreDeDia === horario.dia
        }
      )
      this.turnoDato = turno
    },

    cargarExtrasValidadas(funcionario, fecha) {
      axios
        .get(`/api/horas_extras/datos/validados/${funcionario}/${fecha}`)
        .then(datos => {
          this.extrasValidadas = datos.data
          this.validada =
            this.extrasValidadas.fecha === this.diarioDato.fecha ? true : false

          if (this.validada) {
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
        })
        .catch(error => {
          //console.log(error.response.data)
        })
    },

    actualizarDiarioFijo() {
      axios
        .put(
          `/api/diarios/turno_fijo/${this.diarioDato.id}/actualizar`,
          this.$data.diarioDato
        )
        .then(respuesta => {
          this.cerrarModalDiario(this.diarioDato)
          this.calcularHorasTrabajadas()
        })
    },

    guardarReporteDeExtras() {
      this.$swal
        .fire({
          title: '¿Está seguro(a)?',
          text:
            'Va a realizar el guardado de validación de las horas extras del funcionario, asegúrese que todo coincida como debe ya que esto afectará cálculos de nómina.',
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

            if (this.validada === true) {
              axios
                .put(
                  `/api/horas_extras/${this.extrasValidadas.id}/actualizar`,
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
              axios.post('/api/horas_extras/crear', reporte).then(respuesta => {
                this.validada = true
                this.$swal.fire(
                  'Guardada!',
                  'La validación de horas extras para ' +
                    this.funcionarioDato.nombres +
                    ' se ha registrado',
                  'success'
                )
              })
            }

            //Actualizar datos en vista
            this.cargarExtrasValidadas(
              this.funcionarioDato.id,
              this.diarioDato.fecha
            )
          }
        })
    },

    mostrarModalDiarioFijo(diario) {
      let modalId = `#modalDiarioFijo${diario.id}`

      setTimeout(() => {
        $(modalId).modal({
          backdrop: 'static',
          keyboard: false,
        })
      }, 300)
    },

    cerrarModalDiario(diario) {
      let modalId = `#modalDiarioFijo${diario.id}`

      $(modalId).modal('hide')
    },

    horaMinutos(valor) {
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
  color: #2a93d5;
}
.extra {
  background-color: #d7eefd;
  margin-right: 0px;
}
.row {
  margin-right: 0px;
}
</style>
