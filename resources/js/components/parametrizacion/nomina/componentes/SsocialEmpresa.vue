<template>
  <tabla>
    <tr v-for="(seguridad,index) in datos" :key="`C-${index}`">
      <td class="custom-label">{{seguridad.concepto}}</td>
      <td class="text-center">
        <box-input patron="0.001" :parametro="seguridad" ref="seguridadEmpresa"></box-input>
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
      interfaz: '',
    }
  },
  methods: {
    actualizarSeguridad(seguridad) {
      this.interfaz = new Actualizar(seguridad)
      this.interfaz.registrarAlerta(this.$swal)
      this.interfaz.actualizar(
        `/api/parametrizacion/nomina/ssocial_empresa/${
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
