<template>
  <tabla>
    <tr v-for="(riesgo,index) in datos" :key="`D-${index}`">
      <td class="custom-label">{{riesgo.concepto}}</td>
      <td class="text-center">
        <box-input patron="0.00001" :parametro="riesgo"></box-input>
      </td>
      <td class="text-center">
        <a href="#" class="item-edicion" @click.prevent="actualizarRiesgos(riesgo)">
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
      riesgos: [],
      interfazRiesgos: '',
    }
  },

  methods: {
    actualizarRiesgos(riesgo) {
      this.interfazRiesgos = new Actualizar(riesgo)
      this.interfazRiesgos.registrarAlerta(this.$swal)
      this.interfazRiesgos.actualizar(
        `/api/parametrizacion/nomina/riesgos/${
          this.interfazRiesgos.parametro.id
        }/editar`
      )
    },
    /** Helper para fijar porcentajes, ej: 2.33333333 => 2.333 */
    formatoPorcentaje(porcentaje) {
      return Number(porcentaje).toFixed(3)
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
