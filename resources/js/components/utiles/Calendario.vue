<template>
  <div>
    <date-picker
      v-model="fechaSeleccionada"
      format="DD/MM/YYYY"
      lang="es"
      input-class="calendario"
      :range-separator="simbolo"
      :shortcuts="shortcuts"
      :width="defaultWidth"
      :editable="false"
      :clearable="defaultBorrado"
      @change="$emit('change',$event)"
      :notAfter="fechaMaxima"
      :notBefore="fechaMinima"
    ></date-picker>
  </div>
</template>
<script>
import DatePicker from 'vue2-datepicker'
import { es } from 'vue2-datepicker/src/locale/languages'
export default {
  name: 'calendario',
  components: { DatePicker },
  props: {
    fecha: [String, Object],
    customWidth: String,
    borrado: Boolean,
    fechaMaxima: [String, Object],
    fechaMinima: [String, Object],
  },
  data() {
    return {
      defaultWidth: 320,
      simbolo: '-',
      fechaActual: '',
      fechaSeleccionada: '',
      defaultBorrado: false,
      shortcuts: [
        {
          text: 'Hoy',
          onClick: () => {
            this.fechaSeleccionada = [new Date(), new Date()]
          },
        },
      ],
    }
  },
  created() {
    if (this.fecha) {
      this.fechaSeleccionada = moment(this.fecha, 'YYYY-MM-DD')
    } else {
      this.fechaSeleccionada = moment.now()
    }
    if (this.customWidth) {
      this.defaultWidth = this.customWidth
    }
    if (this.borrado) {
      this.defaultBorrado = true
    }
  },
  methods: {
    formatearFecha() {
      this.fechaSeleccionada = moment(this.fechaSeleccionada).format(
        'YYYY-MM-DD'
      )
      return this.fechaSeleccionada
    },
  },
}
</script>

<style>
.calendario {
  height: calc(1.6rem + 2px);
  border-radius: 4px;
  width: 100%;
  border: 1px solid #ccc;
  line-height: 1.4;
  font-size: 14px;
  padding: 6px 30px;
  padding-left: 10px;
  display: inline-block;
  font-weight: bold;
  color: #35495e;
}
.calendario::placeholder {
  color: #adadad;
}
</style>
