<template>
  <tabla>
    <tr v-for="(seguridad,index) in datos" :key="`B-${index}`">
      <td class="custom-label">{{seguridad.concepto}}</td>
      <td class="text-center">
        <box-input patron="0.001" :parametro="seguridad" ref="seguridadFuncionario"></box-input>
      </td>
      <td class="text-center">
        <a href="#" class="item-edicion" @click.prevent="actualizarSeguridad(seguridad)">
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
      interfazActualizar: '',
    }
  },
  methods: {
    actualizarSeguridad(seguridad) {
      this.interfazActualizar = new Actualizar(seguridad)
      this.interfazActualizar.registrarAlerta(this.$swal)
      this.interfazActualizar.actualizar(
        `/api/parametrizacion/nomina/ssocial_funcionario/${
          this.interfazActualizar.parametro.id
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
