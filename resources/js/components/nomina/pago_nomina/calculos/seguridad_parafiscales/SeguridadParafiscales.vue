<template>
  <div class="container" v-if="mostrarCalculo">
    <resumen
      :seguridadDatos="seguridadDatos"
      :ibcSeguridad="retencionesDatos.IBC_seguridad"
      :porcentajesDatos="porcentajesDatos"
    ></resumen>

    <ibc-salud-pension :retencionesDatos="retencionesDatos"></ibc-salud-pension>

    <ibc-riesgos :ibcRiesgos="seguridadDatos.ibc_riesgos" :datosEmpresa="datosEmpresa"></ibc-riesgos>

    <ibc-parafiscales :ibcParafiscales="seguridadDatos.ibc_parafiscales"></ibc-parafiscales>
  </div>
  <overlay v-else></overlay>
</template>

<script>
import IbcSaludPension from './componentes/IbcSaludPension'
import IbcRiesgos from './componentes/IbcRiesgos'
import IbcParafiscales from './componentes/IbcParafiscales'
import Resumen from './componentes/Resumen'
import Overlay from '../../../../utiles/Overlay'

export default {
  components: {
    IbcSaludPension,
    IbcRiesgos,
    IbcParafiscales,
    Resumen,
    Overlay,
  },
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
      retencionesDatos: '',
      seguridadDatos: '',
      porcentajesDatos: '',
    }
  },
  created() {
    this.datosEmpresa = this.datosEmpresaProp
    this.funcionario = this.funcionarioProp
    this.getRetencionesDatos()
    this.getSeguridadDatos()
    this.getPorcentajesDatos()
    setTimeout(() => {
      this.mostrarCalculo = true
    }, 1000)
  },
  methods: {
    async getRetencionesDatos() {
      let datos = await axios.get(
        `/api/nomina/retenciones/funcionarios/${this.funcionario.id}/${
          this.fechaInicio
        }/${this.fechaFin}`
      )
      this.retencionesDatos = datos.data
    },
    async getSeguridadDatos() {
      let datos = await axios.get(
        `/api/nomina/seguridad/funcionarios/${this.funcionario.id}/${
          this.fechaInicio
        }/${this.fechaFin}`
      )
      this.seguridadDatos = datos.data
    },
    async getPorcentajesDatos() {
      let datos = await axios.get(
        `/api/parametrizacion/nomina/ssocial_empresa/porcentajes/${
          this.funcionario.id
        }`
      )
      this.porcentajesDatos = datos.data
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
</style>
