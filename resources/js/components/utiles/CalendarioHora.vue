<template>
  <date-picker
    v-model="horaSeleccionada"
    @change="actualizarHora"
    format="HH:mm:ss a"
    lang="es"
    input-class="calendario"
    :width="defaultWidth"
    customWidth
    type="time"
    :placeholder="placeHolder"
    :editable="false"
    :clearable="false"
  ></date-picker>
</template>

<script>
import DatePicker from 'vue2-datepicker'
import { es } from 'vue2-datepicker/src/locale/languages'
export default {
  name: 'calendario-hora',
  props: { default: String, customWidth: String },
  components: { DatePicker },
  data() {
    return {
      defaultWidth: 320,
      horaSeleccionada: '',
      placeHolder: 'Seleccionar Hora',

      timePickerOptions: {
        start: '00:00',
        step: '00:30',
        end: '23:30',
      },
    }
  },
  created() {
    if (this.customWidth) {
      this.defaultWidth = this.customWidth
    }
    this.horaSeleccionada = moment(this.default, 'HH:mm:ss')
  },
  methods: {
    actualizarHora() {
      this.$emit('cambio', this.horaSeleccionada)
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
