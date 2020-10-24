<template>
  <div class="container">
    <router-link to="/turnos" class="btn btn-link mb-2 p-0">
      <i class="simple-icon-action-undo"></i> Volver
    </router-link>
    <h2 class="font-weight-bold text-primary">Agregar/editar turno fijo</h2>

    <modal ref="horario" id="horario" :esLg="true">
      <template slot="titulo">Asignar horario</template>
      <template slot="contenido">
        <form @submit.prevent="asignacionMasivaHorarios">
          <div class="form-row">
            <div class="form-group col-md-3">
              <label class="custom-label" for="hora_inicio_uno">Hora de entrada 1</label>
              <input
                type="time"
                name="hora_inicio_uno"
                class="form-control custom-control"
                v-model="horarioAsignacionMasiva.hora_inicio_uno"
              >
              <small
                class="invalid"
                v-if="errors.has('hora_inicio_uno')"
              >{{errors.first('hora_inicio_uno')}}</small>
            </div>
            <div class="form-group col-md-3">
              <label class="custom-label" for="hora_fin_uno">Hora de salida 1</label>
              <input
                type="time"
                name="hora_fin_uno"
                class="form-control custom-control"
                v-model="horarioAsignacionMasiva.hora_fin_uno"
              >
              <small
                class="invalid"
                v-if="errors.has('hora_fin_uno')"
              >{{errors.first('hora_fin_uno')}}</small>
            </div>
            <div class="form-group col-md-3">
              <label class="custom-label" for="hora_inicio_dos">Hora de entrada 2</label>
              <input
                type="time"
                class="form-control custom-control"
                name="hora_inicio_dos"
                v-model="horarioAsignacionMasiva.hora_inicio_dos"
              >
              <small
                class="invalid"
                v-if="errors.has('hora_inicio_dos')"
              >{{errors.first('hora_inicio_dos')}}</small>
            </div>
            <div class="form-group col-md-3">
              <label class="custom-label" for="hora_fin_dos">Hora de salida 2</label>
              <input
                type="time"
                class="form-control custom-control"
                name="hora_fin_dos"
                v-model="horarioAsignacionMasiva.hora_fin_dos"
              >
              <small
                class="invalid"
                v-if="errors.has('hora_fin_dos')"
              >{{errors.first('hora_fin_dos')}}</small>
            </div>
          </div>

          <div class="form-group text-right">
            <button type="submit" class="btn btn-secondary raised">Enviar</button>
          </div>
        </form>
      </template>
    </modal>

    <div class="card">
      <div class="card-body">
        <form @submit.prevent="validarAntesDeEnviar">
          <div class="form-row">
            <div class="form-group col-md-4">
              <label class="custom-label" for="nombre">Nombre</label>
              <input
                type="text"
                class="form-control custom-control"
                name="nombre"
                v-validate="'required|min:3'"
                data-vv-as="Nombre"
                placeholder="Nombre del Turno"
                v-model="lista.nombre"
              >
              <small class="invalid" v-if="errors.has('nombre')">{{errors.first('nombre')}}</small>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-4">
              <label class="custom-label" for="tolerancia_entrada">Tolerancia de Entrada</label>
              <input
                type="text"
                class="form-control custom-control"
                name="tolerancia_entrada"
                v-validate="'required|numeric|min_value:0'"
                data-vv-as="Tolerancia de entrada"
                v-model="lista.tolerancia_entrada"
              >
              <small
                class="invalid"
                v-if="errors.has('tolerancia_entrada')"
              >{{errors.first('tolerancia_entrada')}}</small>
            </div>
            <div class="form-group col-md-4">
              <label class="custom-label" for="tolerancia_salida">Tolerancia de Salida</label>
              <input
                type="text"
                class="form-control custom-control"
                name="tolerancia_salida"
                v-validate="'required|numeric|min_value:0'"
                data-vv-as="Tolerancia de salida"
                v-model="lista.tolerancia_salida"
              >
              <small
                class="invalid"
                v-if="errors.has('tolerancia_salida')"
              >{{errors.first('tolerancia_salida')}}</small>
            </div>
            <div class="form-group col-md-4">
              <label class="custom-label" for="extras">Horas Extras</label>
              <select name="extras" class="form-control custom-control" v-model="lista.extras">
                <option value="0">No</option>
                <option value="1">Si</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <button
              class="btn btn-link btn-xs"
              type="button"
              @click="showModalHorario"
            >Asignación masiva</button>
          </div>
          <div class="form-row" v-for="(hora,index) in horariosDias" :key="index">
            <div class="form-group col-md-4">
              <label class="custom-label" for="dia">Nombre día {{index +1}}</label>
              <input
                type="text"
                :name="`dia${index+1}`"
                v-validate="'required'"
                data-vv-as="Nombre del día"
                class="form-control custom-control"
                v-model="dias[index]"
                :disabled="true"
              >
              <small
                class="invalid"
                v-if="errors.has('dia'+(index+1))"
              >{{errors.first('dia'+(index+1))}}</small>
            </div>
            <div class="form-group col-md-2">
              <label class="custom-label" for="hora_inicio_uno">Hora de entrada 1</label>
              <input
                type="time"
                :name="`hora_inicio_uno_${index+1}`"
                v-validate="'required'"
                data-vv-as="Hora de entrada"
                class="form-control custom-control"
                v-model="horariosDias[index].hora_inicio_uno"
              >
              <small
                class="invalid"
                v-if="errors.has(`hora_inicio_uno_${index+1}`)"
              >{{errors.first(`hora_inicio_uno_${index+1}`)}}</small>
            </div>
            <div class="form-group col-md-2">
              <label class="custom-label" for="hora_fin_uno">Hora de salida 1</label>
              <input
                type="time"
                :name="`hora_fin_uno_${index+1}`"
                v-validate="'required'"
                data-vv-as="Hora de salida"
                class="form-control custom-control"
                v-model="horariosDias[index].hora_fin_uno"
              >
              <small
                class="invalid"
                v-if="errors.has(`hora_fin_uno_${index+1}`)"
              >{{errors.first(`hora_fin_uno_${index+1}`)}}</small>
            </div>
            <div class="form-group col-md-2">
              <label class="custom-label" for="hora_inicio_dos">Hora de entrada 2</label>
              <input
                type="time"
                class="form-control custom-control"
                :name="`hora_inicio_dos_${index+1}`"
                v-validate="'required'"
                data-vv-as="Hora de entrada"
                v-model="horariosDias[index].hora_inicio_dos"
              >
              <small
                class="invalid"
                v-if="errors.has(`hora_inicio_dos_${index+1}`)"
              >{{errors.first(`hora_inicio_dos_${index+1}`)}}</small>
            </div>
            <div class="form-group col-md-2">
              <label class="custom-label" for="hora_fin_dos">Hora de salida 2</label>
              <input
                type="time"
                class="form-control custom-control"
                :name="`hora_fin_dos${index+1}`"
                v-validate="'required'"
                data-vv-as="Hora de salida"
                v-model="horariosDias[index].hora_fin_dos"
              >
              <small
                class="invalid"
                v-if="errors.has(`hora_fin_dos${index+1}`)"
              >{{errors.first(`hora_fin_dos${index+1}`)}}</small>
            </div>
          </div>

          <div
            class="form-row"
            v-for="(horaOpcional, index) in horariosDiasOpcionales"
            :key="`${index}-opcional`"
          >
            <div class="form-group col-md-4">
              <label class="custom-label" for="dia">Nombre día opcional {{index +1}}</label>
              <input
                type="text"
                name="dia"
                class="form-control custom-control"
                v-model="diasOpcionales[index]"
                :disabled="true"
              >
            </div>
            <div class="form-group col-md-2">
              <label class="custom-label" for="hora_inicio_uno">Hora de entrada 1</label>
              <input
                type="time"
                name="hora_inicio_uno"
                class="form-control custom-control"
                v-model="horariosDiasOpcionales[index].hora_inicio_uno"
              >
            </div>
            <div class="form-group col-md-2">
              <label class="custom-label" for="hora_fin_uno">Hora de salida 1</label>
              <input
                type="time"
                name="hora_fin_uno"
                class="form-control custom-control"
                v-model="horariosDiasOpcionales[index].hora_fin_uno"
              >
            </div>
            <div class="form-group col-md-2">
              <label class="custom-label" for="hora_inicio_dos">Hora de entrada 2</label>
              <input
                type="time"
                class="form-control custom-control"
                name="hora_inicio_dos"
                v-model="horariosDiasOpcionales[index].hora_inicio_dos"
              >
            </div>
            <div class="form-group col-md-2">
              <label class="custom-label" for="hora_fin_dos">Hora de salida 2</label>
              <input
                type="time"
                class="form-control custom-control"
                name="hora_fin_dos"
                v-model="horariosDiasOpcionales[index].hora_fin_dos"
              >
            </div>
          </div>

          <div class="form-group text-right">
            <button type="submit" class="btn btn-secondary raised">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import colorTurnos from './colores'
import Modal from '../utiles/Modal'
export default {
  components: { Modal },
  data() {
    return {
      lista: {
        id: '',
        nombre: '',
        extras: '0',
        tolerancia_entrada: 0,
        tolerancia_salida: 0,
        color: '',
      },

      dias: ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'],
      diasOpcionales: ['Sábado', 'Domingo'],
      horariosDias: [],
      horariosDiasOpcionales: [],

      horarioAsignacionMasiva: {
        hora_inicio_uno: '',
        hora_fin_uno: '',
        hora_inicio_dos: '',
        hora_fin_dos: '',
      },
      horariosPostPromises: [],
    }
  },
  created() {
    if (this.turnoExistente()) {
      this.lista = this.$route.params['turno']
    }
    this.fillHorarios(this.dias, this.horariosDias)
    this.fillHorarios(this.diasOpcionales, this.horariosDiasOpcionales)
  },

  methods: {
    turnoExistente() {
      return this.$route.params['turno'] ? true : false
    },

    fillHorarios(dias, horario) {
      for (let dia of dias) {
        horario.push({
          id: '',
          hora_inicio_uno: '',
          hora_fin_uno: '',
          hora_inicio_dos: '',
          hora_fin_dos: '',
          turno_fijo_id: '',
          jornada_turno: 'Diurno',
          dia,
        })
      }

      if (this.turnoExistente()) {
        let index = null
        const turno = this.$route.params['turno']

        turno.horarios_turno_fijo.forEach(horarioTurnoFijo => {
          horario.forEach(horarioDia => {
            index = horario.indexOf(horarioDia)
            if (horarioDia.dia === horarioTurnoFijo.dia) {
              horario[index] = horarioTurnoFijo
            }
          })
        })
      }
    },

    async validarAntesDeEnviar() {
      let validado = await this.$validator.validateAll()
      if (validado) {
        this.makeRequest()
        return
      }
      this.$swal.fire(
        'Error!',
        'Debe corregir los errores antes de enviar',
        'error'
      )
    },

    makeRequest() {
      if (!this.lista.id) {
        this.postTurno()
      } else {
        this.putTurno()
      }
    },

    postTurno() {
      this.lista.color = this.colorAletatorio()
      axios
        .post('/api/turnos/fijo/crear', this.lista)
        .then(respuesta => {
          this.$emit('recargar')
          /** Guardar horarios turno */
          this.postOrPutHorariosTurno(respuesta)
        })
        .catch(error => {
          this.catchErrorServidor(error)
        })
    },

    putTurno() {
      axios
        .put(`/api/turnos/${this.lista.id}/fijo/editar`, this.lista)
        .then(respuesta => {
          this.$emit('recargar')
          /** Actualizar horarios turno */
          this.postOrPutHorariosTurno(respuesta)
        })
        .catch(error => {
          this.catchErrorServidor(error)
        })
    },

    /* función para elegir el color del turno aleatoriamente */
    colorAletatorio() {
      let colores = colorTurnos.colores
      let color = colores[Math.floor(Math.random() * colores.length)]
      return color
    },

    showModalHorario() {
      this.$refs.horario.mostrarModal()
    },

    asignacionMasivaHorarios() {
      for (let propiedad in this.horarioAsignacionMasiva) {
        if (this.horarioAsignacionMasiva[propiedad]) {
          this.asignarEntradaOrSalida(
            propiedad,
            this.horarioAsignacionMasiva[propiedad]
          )
        }
      }
      modalEmitter.$emit('cerrar', this.$refs.horario.id)
      return
    },

    asignarEntradaOrSalida(entradaOrSalida, valorHoraAsignada) {
      this.horariosDias.forEach(horario => {
        horario[entradaOrSalida] = valorHoraAsignada
      })
    },

    postOrPutHorariosTurno(respuesta) {
      this.makePostPromises(respuesta)

      axios.all(this.horariosPostPromises).then(respuesta => {
        this.$router.push({ name: 'TurnoPrincipal' })
        this.limpiarDatosFormulario()
        this.$validator.reset()
      })
    },

    makePostPromises(respuesta) {
      this.horariosDias.forEach(horario => {
        horario.turno_fijo_id = respuesta.data.id
        this.horariosPostPromises.push(this.postOrPutHorario(horario))
      })

      this.horariosDiasOpcionales.forEach(horario => {
        if (horario.hora_inicio_uno && horario.hora_fin_uno) {
          horario.turno_fijo_id = respuesta.data.id
          this.horariosPostPromises.push(this.postOrPutHorario(horario))
        }
      })
    },

    postOrPutHorario(horario) {
      if (!horario.id) {
        axios.post('/api/horario/turno_fijo/crear', horario)
      } else {
        axios.put(`/api/horario/turno_fijo/${horario.id}/editar`, horario)
      }
    },

    limpiarDatosFormulario() {
      for (let propiedad in this.$data.lista) {
        if (
          propiedad == 'tolerancia_entrada' ||
          propiedad == 'tolerancia_salida'
        ) {
          continue
        }
        this.lista[propiedad] = ''
      }

      this.horariosDias = []
      this.horariosDiasOpcionales = []
      this.fillHorarios(this.dias, this.horariosDias)
      this.fillHorarios(this.diasOpcionales, this.horariosDiasOpcionales)
    },

    catchErrorServidor(error) {
      if (error.response) {
        this.$swal.fire(
          'Error',
          'Han ocurrido errores, por favor intente más tarde',
          'error'
        )
      }
    },
  },
}
</script>
