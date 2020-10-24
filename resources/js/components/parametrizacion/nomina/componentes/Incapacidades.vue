<template>
  <tabla>
    <tr v-for="(incapacidad,index) in datos" :key="`F-${index}`">
      <td class="custom-label">{{incapacidad.concepto}}</td>
      <td class="text-center">
        <box-input patron="0.00001" :parametro="incapacidad"></box-input>
      </td>
      <td class="text-center">
        <a href="#" class="item-edicion" @click.prevent="actualizarIncapacidades(incapacidad)">
          <i class="simple-icon-check"></i>
        </a>
      </td>
    </tr>
  </tabla>
</template>

<script>
import BoxInput from '../reutilizables/BoxInput'
import Tabla from '../reutilizables/Tabla'
import { Actualizar } from './Actualizar'

export default {
  props: { datos: Array },
  components: { Tabla, BoxInput },
  data() {
    return {
      interfaz: '',
    }
  },

  methods: {
    actualizarIncapacidades(incapacidad) {
      this.interfaz = new Actualizar(incapacidad)
      this.interfaz.registrarAlerta(this.$swal)
      this.interfaz.actualizar(
        `/api/parametrizacion/nomina/incapacidades/${
          this.interfaz.parametro.id
        }/editar`
      )
    },
  },
}
</script>

<style scoped>
.item-edicion {
  color: #2a93d5;
}
.item-edicion i {
  font-size: 1.3rem;
}
</style>
