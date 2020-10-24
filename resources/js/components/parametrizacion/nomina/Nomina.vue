<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1 class="font-weight-bold">Nómina</h1>
        <div class="separator mb-5"></div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <p
          class="alert alert-secondary font-weight-bold"
        >Recordar que los cambios de estos valores modificáran los cálculos correspondientes al momento del pago de nómina</p>
      </div>
    </div>

    <div v-if="renderizarNomina">
      <div class="row mb-2">
        <div class="col-md-12">
          <h2 class="font-weight-bold titulo">Horas extras y Recargos</h2>
        </div>
        <horas-extras ref="horasExtras" @notificacion="mostrarMensaje" :datos="extrasDatos"></horas-extras>
      </div>

      <div class="row mt-3">
        <div class="col-md-12">
          <h3 class="font-weight-bold titulo">Aportes Seguridad social - Funcionario</h3>
        </div>
        <ssocial-funcionario
          ref="ssocialFuncionario"
          @notificacion="mostrarMensaje"
          :datos="seguridadFuncionarioDatos"
        ></ssocial-funcionario>
      </div>

      <div class="row mt-3">
        <div class="col-md-12">
          <h4 class="font-weight-bold titulo">Aportes Seguridad social - Empresa</h4>
        </div>
        <ssocial-empresa
          ref="ssocialEmpresa"
          @notificacion="mostrarMensaje"
          :datos="seguridadEmpresaDatos"
        ></ssocial-empresa>
      </div>

      <div class="row mt-3">
        <div class="col-md-12">
          <h5 class="font-weight-bold titulo">Riesgos ARL</h5>
        </div>
        <riesgos-arl ref="riesgosArl" @notificacion="mostrarMensaje" :datos="riesgosArlDatos"></riesgos-arl>
      </div>

      <div class="row mt-3">
        <div class="col-md-12">
          <h5 class="font-weight-bold titulo">Parafiscales</h5>
        </div>
        <parafiscales ref="parafiscales" @notificacion="mostrarMensaje" :datos="parafiscalesDatos"></parafiscales>
      </div>

      <div class="row mt-3">
        <div class="col-md-12">
          <h5 class="font-weight-bold titulo">Incapacidades</h5>
        </div>
        <incapacidades
          ref="incapacidades"
          @notificacion="mostrarMensaje"
          :datos="incapacidadesDatos"
        ></incapacidades>
      </div>

      <notifications group="notificacionesNomina" position="bottom right"/>
    </div>

    <div class="overlay" v-else>
      <div class="container-spinner">
        <semipolar-spinner :animation-duration="800" :size="70" color="#fff"/>
        <p class="text-center font-weight-bold text-spinner">Cargando módulo...</p>
      </div>
    </div>
  </div>
</template>

<script>
import HorasExtras from './componentes/HorasExtras'
import SsocialFuncionario from './componentes/SsocialFuncionario'
import SsocialEmpresa from './componentes/SsocialEmpresa'
import RiesgosArl from './componentes/RiesgosArl'
import Parafiscales from './componentes/Parafiscales'
import Incapacidades from './componentes/Incapacidades'
import { SemipolarSpinner } from 'epic-spinners'

export default {
  components: {
    SemipolarSpinner,
    HorasExtras,
    SsocialFuncionario,
    SsocialEmpresa,
    RiesgosArl,
    Parafiscales,
    Incapacidades,
  },
  data() {
    return {
      renderizarNomina: false,
      extrasDatos: [],
      incapacidadesDatos: [],
      parafiscalesDatos: [],
      riesgosArlDatos: [],
      seguridadEmpresaDatos: [],
      seguridadFuncionarioDatos: [],
    }
  },

  created() {
    this.getDatos()
  },

  methods: {
    getDatos() {
      axios
        .all([
          this.getExtras(),
          this.getIncapacidades(),
          this.getParafiscales(),
          this.getRiesgos(),
          this.getSeguridadEmpresa(),
          this.getSeguridadFuncionario(),
        ])
        .then(
          axios.spread(
            (
              extras,
              incapacidades,
              parafiscales,
              riesgos,
              seguridadEmpresa,
              seguridadFuncionario
            ) => {
              this.extrasDatos = extras.data
              this.incapacidadesDatos = incapacidades.data
              this.parafiscalesDatos = parafiscales.data
              this.riesgosArlDatos = riesgos.data
              this.seguridadEmpresaDatos = seguridadEmpresa.data
              this.seguridadFuncionarioDatos = seguridadFuncionario.data
              this.renderizarNomina = true
            }
          )
        )
    },
    getExtras() {
      return axios.get('/api/parametrizacion/nomina/extras')
    },
    getIncapacidades() {
      return axios.get('/api/parametrizacion/nomina/incapacidades')
    },
    getParafiscales() {
      return axios.get('/api/parametrizacion/nomina/parafiscales')
    },
    getRiesgos() {
      return axios.get('/api/parametrizacion/nomina/riesgos')
    },
    getSeguridadEmpresa() {
      return axios.get('/api/parametrizacion/nomina/ssocial_empresa')
    },
    getSeguridadFuncionario() {
      return axios.get('/api/parametrizacion/nomina/ssocial_funcionario')
    },
    mostrarMensaje(mensaje) {
      setTimeout(() => {
        this.$notify({
          group: 'notificacionesNomina',
          title: 'Actualización correcta',
          text: mensaje,
        })
      }, 600)
    },
  },
}
</script>

<style scoped>
.titulo {
  font-size: 1.4rem;
  font-weight: bold;
}
</style>
