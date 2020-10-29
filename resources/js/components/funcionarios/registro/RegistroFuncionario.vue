<template>
  <div class="container">
    <div class="row ml-1 mb-2">
      <router-link to="/funcionarios" class="btn btn-outline-secondary btn-xs">Volver</router-link>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <form-wizard
              title="Registro de Nuevo Funcionario"
              subtitle="Llene el formulario paso a paso"
              nextButtonText="Siguiente"
              backButtonText="Atrás"
              finishButtonText="Terminar"
              color="#2a93d5"
              shape="circle"
              stepSize="xs"
              @on-complete="formularioCompleto"
            >
              <template slot="step" slot-scope="props">
                <wizard-step
                  :tab="props.tab"
                  :transition="props.transition"
                  :key="props.tab.title"
                  :index="props.index"
                ></wizard-step>
              </template>

              <tab-content
                title="Datos del Funcionario"
                icon="iconsmind-Administrator"
                :before-change="validarDatosBasicos"
              >
                <datos-basicos ref="datosBasicos"></datos-basicos>
              </tab-content>

              <tab-content
                :before-change="validarInformacionEmpresa"
                title="Información de empresa"
                icon="iconsmind-Phone-2"
              >
                <informacion-empresa ref="informacionEmpresa"></informacion-empresa>
              </tab-content>

              <tab-content
                :before-change="validarPrestaciones"
                title="Prestaciones sociales"
                icon="iconsmind-Notepad"
              >
                <prestaciones ref="prestaciones"></prestaciones>
              </tab-content>

              <tab-content
                :beforeChange="validarDotacion"
                title="Dotacion y/o Tallas"
                icon="iconsmind-Network"
              >
                <dotacion ref="dotacion"></dotacion>
              </tab-content>
            </form-wizard>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
/** Componentes */
import DatosBasicos from './formularios/DatosBasicos'
import InformacionEmpresa from './formularios/InformacionEmpresa'
import Prestaciones from './formularios/Prestaciones'
import Dotacion from './formularios/Dotacion'

export default {
  components: {
    DatosBasicos,
    InformacionEmpresa,
    Prestaciones,
    Dotacion,
  },
  data() {
    return {
      funcionario: '',
    }
  },
  methods: {
    validarDatosBasicos() {
      return this.$refs.datosBasicos.guardarDatosBasicos()
    },

    validarInformacionEmpresa() {
      return this.$refs.informacionEmpresa.guardarInformacionEmpresa()
    },

    validarPrestaciones() {
      return this.$refs.prestaciones.guardarPrestaciones()
    },

    validarDotacion() {
      return this.$refs.dotacion.guardarDotacion()
    },

    formularioCompleto() {
      this.funcionario = Object.assign(
        {},
        this.$refs.datosBasicos.datosBasicos,
        this.$refs.informacionEmpresa.informacionEmpresa,
        this.$refs.prestaciones.prestaciones,
        this.$refs.dotacion.dotacion
      )

      let data = new FormData()

      for (let prop in this.funcionario) {
        data.append(prop, this.funcionario[prop])
      }
      data.append('image', this.$refs.datosBasicos.imagenTemporal)

      axios
        .post(`/api/${localStorage.getItem('tenant')}/funcionarios/crear`, data)
        .then(respuesta => {
          this.$swal.fire('Bien hecho!', respuesta.data.message, 'success')
          this.limpiarFormulario()
          this.$validator.reset()
          this.$router.push({ name: 'FuncionariosPrincipal' })
        })
        .catch(error => {
          if (error.response) {
            let errorServidor = null
            for (let err in error.response.data.errors) {
              if (err === 'email' || err === 'identidad') {
                errorServidor = error.response.data.errors[err][0]
              }
            }

            this.$swal.fire('Error', errorServidor, 'error')
          }
        })
    },

    limpiarFormulario() {
      for (let referencia in this.$refs) {
        this.$refs[referencia].limpiarDatos()
      }
    },
  },
}
</script>

<style scoped>
h4.wizard-title {
  font-weight: bold;
}
</style>
