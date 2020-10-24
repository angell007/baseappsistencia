<template>
  <tabla>
    <tr v-for="(extra,index) in datos" :key="`A-${index}`">
      <td class="custom-label">{{extra.concepto}}</td>
      <td class="text-center custom-label">
        <box-input patron="0.01" :parametro="extra" ref="extras"></box-input>
      </td>
      <td class="text-center">
        <a href="#" class="item-edicion" @click.prevent="actualizar(extra)">
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
  components: { BoxInput, Tabla },
  data() {
    return {
      interfaz: '',
    }
  },

  methods: {
    actualizar(extra) {
      this.interfaz = new Actualizar(extra)
      this.interfaz.registrarAlerta(this.$swal)
      this.interfaz.actualizar(
        `/api/parametrizacion/nomina/extras/${
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
