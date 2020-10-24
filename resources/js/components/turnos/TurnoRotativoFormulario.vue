<template>
  <form @submit.prevent="validarAntesDeEnviar">
    <div class="form-group">
      <label class="custom-label" for="nombre">Nombre</label>
      <input
        type="text"
        name="nombre"
        v-validate="'required|min:3'"
        data-vv-as="Nombre del turno"
        class="form-control custom-control col-6"
        placeholder="Nombre del Turno"
        v-model="lista.nombre"
      >
      <small class="invalid" v-if="errors.has('nombre')">{{errors.first('nombre')}}</small>
    </div>

    <div class="form-row">
      <div class="form-group col-md-4">
        <label class="custom-label" for="tolerancia_entrada">Tolerancia de Entrada</label>
        <input
          type="text"
          class="form-control custom-control"
          name="tolerancia_entrada"
          v-validate="'required|min_value:0|max_value:60|numeric'"
          data-vv-as="Tolerancia entrada"
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
          data-vv-as="Tolerancia salida"
          v-validate="'required|min_value:0|max_value:60|numeric'"
          v-model="lista.tolerancia_salida"
        >
        <small
          class="invalid"
          v-if="errors.has('tolerancia_salida')"
        >{{errors.first('tolerancia_salida')}}</small>
      </div>
      <div class="form-group col-md-4">
        <label class="custom-label" for="extras">Horas Extras</label>
        <select
          class="form-control custom-control"
          name="extras"
          v-validate="'required'"
          data-vv-as="Extras"
          v-model="lista.extras"
        >
          <option value="0">No</option>
          <option value="1">Si</option>
        </select>
        <small class="invalid" v-if="errors.has('extras')">{{errors.first('extras')}}</small>
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-3">
        <label class="custom-label" for="hora_inicio_uno">Hora de Entrada</label>
        <input
          type="time"
          class="form-control custom-control"
          name="hora_inicio_uno"
          v-validate="'required'"
          data-vv-as="Hora de entrada"
          v-model="lista.hora_inicio_uno"
        >
        <small
          class="invalid"
          v-if="errors.has('hora_inicio_uno')"
        >{{errors.first('hora_inicio_uno')}}</small>
      </div>
      <div class="form-group col-md-3">
        <label class="custom-label" for="hora_fin_uno">Hora de Salida</label>
        <input
          type="time"
          class="form-control custom-control"
          name="hora_fin_uno"
          v-validate="'required'"
          data-vv-as="Hora de salida"
          v-model="lista.hora_fin_uno"
        >
        <small class="invalid" v-if="errors.has('hora_fin_uno')">{{errors.first('hora_fin_uno')}}</small>
      </div>
    </div>

    <div class="form-group text-right">
      <button type="submit" class="btn btn-secondary raised">Guardar</button>
    </div>
  </form>
</template>

<script>
import colorTurnos from './colores.js'
export default {
  data() {
    return {
      lista: {
        id: '',
        nombre: '',
        extras: '1',
        tolerancia_entrada: 0,
        tolerancia_salida: 0,
        hora_inicio_uno: '',
        hora_fin_uno: '',
        hora_inicio_dos: '',
        hora_fin_dos: '',
        jornada_turno: '',
        color: '',
      },
    }
  },

  methods: {
    async validarAntesDeEnviar() {
      let validado = await this.$validator.validateAll()
      if (validado) {
        this.makeRequest()
        return
      }
      this.$swal.fire(
        'Error!',
        'Debe corregir los campos antes de enviar',
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
      /** Pendiente cambiar */
      this.lista.jornada_turno = 'Diurno'
      this.lista.color = this.colorAletatorio()
      axios
        .post('/api/turnos/rotativo/crear', this.$data.lista)
        .then(respuesta => {
          this.$emit('cerrar')
          this.$swal.fire('Correcto', respuesta.data.message, 'success')
          this.$emit('recargar')
          this.limpiarDatos()
          this.$validator.reset()
        })
        .catch(error => {
          this.errorServidor(error)
        })
    },

    putTurno() {
      axios
        .put(`/api/turnos/${this.lista.id}/rotativo/editar`, this.$data.lista)
        .then(respuesta => {
          this.$emit('cerrar')
          this.$swal.fire('Correcto', respuesta.data.message, 'success')
          this.$emit('recargar')
          this.limpiarDatos()
          this.$validator.reset()
        })
        .catch(error => {
          this.errorServidor(error)
        })
    },
    limpiarDatos() {
      for (let propiedad in this.$data.lista) {
        if (propiedad != 'dependencia_id' && propiedad != 'tipo_turno') {
          this.$data.lista[propiedad] = ''
        }
      }
      this.$data.lista.tolerancia_entrada = this.$data.lista.tolerancia_salida = 0
      this.$data.lista.extras = '1'
    },
    errorServidor(error) {
      if (error.response) {
        this.$swal.fire(
          'Error!',
          'Han ocurrido errores, por favor intente más tarde',
          'error'
        )
      }
    },
    /* función para elegir el color del turno aleatoriamente */
    colorAletatorio() {
      let colores = colorTurnos.colores
      let color = colores[Math.floor(Math.random() * colores.length)]
      return color
    },
  },
}
</script>

