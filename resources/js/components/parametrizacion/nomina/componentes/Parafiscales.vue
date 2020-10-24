<template>
  <tabla>
    <tr v-for="(parafiscal,index) in datos" :key="`E-${index}`">
      <td class="custom-label">{{parafiscal.concepto}}</td>
      <td class="text-center">
        <box-input patron="0.01" :parametro="parafiscal"></box-input>
      </td>
      <td class="text-center">
        <a href="#" class="item-edicion" @click.prevent="actualizarParafiscales(parafiscal)">
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
      parafiscales: [],
      interfaz: '',
    }
  },

  methods: {
    actualizarParafiscales(aporte) {
      this.interfaz = new Actualizar(aporte)
      this.interfaz.registrarAlerta(this.$swal)
      this.interfaz.actualizar(
        `/api/parametrizacion/nomina/parafiscales/${
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
