<template>
  <div class="container" v-if="mostrarCalculo">
    <resumen-provisiones :provisionesDatos="provisionesDatos"></resumen-provisiones>

    <p v-if="funcionario.subsidio_transporte">
      <small>Se incluye el Subsidio de transporte en la Base para cesantías y prima, ya que el empleado tiene configurado este auxilio y su salario es menor de 2MMLV.</small>
    </p>

    <base-calculo :funcionario="funcionario" :base="provisionesDatos.base_cesantias">
      Cálculo Base cesantías,intereses a las cesantías
      <i class="iconsmind-Coins-3"></i>
    </base-calculo>

    <base-calculo :funcionario="funcionario" :base="provisionesDatos.base_prima">
      Cálculo Base prima
      <i class="iconsmind-Christmas-Tree"></i>
    </base-calculo>

    <base-calculo :funcionario="funcionario" :base="provisionesDatos.base_vacaciones">
      Cálculo Base vacaciones
      <i class="iconsmind-Palm-Tree"></i>
    </base-calculo>

    <dias-vacaciones :diasVacaciones="provisionesDatos.dias_vacaciones"></dias-vacaciones>
  </div>
  <overlay v-else></overlay>
</template>

<script>
import BaseCalculo from './componentes/BaseCalculo'
import DiasVacaciones from './componentes/DiasVacaciones'
import ResumenProvisiones from './componentes/ResumenProvisiones'
import Overlay from '../../../../utiles/Overlay'

export default {
  components: { BaseCalculo, DiasVacaciones, ResumenProvisiones, Overlay },
  props: {
    funcionarioProp: Object,
    datosEmpresaProp: Object,
    fechaInicio: String,
    fechaFin: String,
  },
  data() {
    return {
      funcionario: '',
      datosEmpresa: '',
      mostrarCalculo: false,
      provisionesDatos: '',
    }
  },
  created() {
    this.funcionario = this.funcionarioProp
    this.datosEmpresa = this.datosEmpresaProp
    this.getProvisionesDatos()
    setTimeout(() => {
      this.mostrarCalculo = true
    }, 1000)
  },

  methods: {
    async getProvisionesDatos() {
      let datos = await axios.get(
        `/api/nomina/provisiones/funcionarios/${this.funcionario.id}/${
          this.fechaInicio
        }/${this.fechaFin}`
      )
      this.provisionesDatos = datos.data
    },
  },
}
</script>

<style scoped>
p small {
  font-size: 13px;
  font-weight: bold;
  color: rgba(31, 29, 29, 0.911);
}
.fila-total {
  background-color: #eeeeee;
  font-weight: bold;
  color: #1b1a1a;
}
.fila-vacia {
  height: 1.5rem;
}
p i {
  font-size: 26px;
}
</style>
