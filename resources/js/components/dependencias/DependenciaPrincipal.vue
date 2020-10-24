<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="mb-2">
          <h1 class="font-weight-bold">Dependencias</h1>
          <div class="float-sm-right text-zero">
            <button type="button" class="btn btn-link" @click="mostrarModal('dependencia',true)">
              <i class="simple-icon-plus"></i> Nueva Dependencia
            </button>
          </div>
        </div>
      </div>
    </div>

    <modal id="dependencia" ref="dependencia">
      <template slot="titulo">Agregar/Editar dependencia</template>
      <template slot="contenido">
        <dependencia-formulario ref="formulario" @recargar="cargarDependencias"></dependencia-formulario>
      </template>
    </modal>

    <div class="card mb-4">
      <div class="card-body">
        <div class="row">
          <div class="col-12">
            <div class="mb-2">
              <a
                class="btn pt-0 pl-0 d-inline-block d-md-none"
                data-toggle="collapse"
                href="#displayOptions"
                role="button"
                aria-expanded="true"
                aria-controls="displayOptions"
              >
                Mostrar Opciones
                <i class="simple-icon-arrow-down align-middle"></i>
              </a>
              <div class="collapse d-md-block" id="displayOptions">
                <div class="d-block d-md-inline-block">
                  <div class="search-sm d-inline-block float-md-left mr-1 mb-1 align-top">
                    <input placeholder="Buscar..." v-model="buscador">
                  </div>
                </div>
                <div class="float-md-right" style="margin-right: 1rem;">
                  <span
                    class="text-muted text-small"
                  >Cantidad de Dependencias: {{dependenciasDatos.length}}</span>
                </div>
              </div>
            </div>
            <div class="separator mb-5"></div>
          </div>
        </div>

        <div class="row" v-if="dependenciasDatos.length">
          <div class="col-md-12">
            <table role="grid" class="table table-sm table-bordered table-striped">
              <thead class="bg-light">
                <tr>
                  <th>Nombre</th>
                  <th class="text-center">Centro de costos</th>
                  <th class="text-center">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(dependencia, index) in dependenciasDatos" :key="index">
                  <td class="custom-label">{{ dependencia.nombre}}</td>
                  <td class="text-center custom-label">{{ dependencia.centro_costo.nombre}}</td>
                  <td class="text-center">
                    <a
                      href="#"
                      class="table-icon"
                      @click.prevent="editarDependencia(dependencia.id)"
                    >
                      <i class="simple-icon-note"></i>
                    </a>
                    <a
                      href="#"
                      class="table-icon"
                      @click.prevent="eliminarDependencia(dependencia.id)"
                    >
                      <i class="simple-icon-trash"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="alert alert-secondary" v-else>
          <p
            class="font-weight-bold text-center"
          >No existen dependencias actualmente, para empezar a agregarlas vaya a la opción "Nueva dependencia" en la parte superior derecha</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import DependenciaFormulario from './DependenciaFormulario'
import Modal from '../utiles/Modal'

export default {
  components: { DependenciaFormulario, Modal },
  data() {
    return {
      dependenciasDatos: [],
      dependenciasDatosBuscador: [],
      buscador: '',
    }
  },
  mounted() {
    this.cargarDependencias()
  },

  methods: {
    mostrarModal(modal, limpiar = false) {
      if (limpiar) {
        this.$refs.formulario.limpiarFormulario()
        this.$refs.formulario.$validator.reset()
        this.$refs.formulario.centroCostosObjeto = null
      }
      this.$refs[modal].mostrarModal()
    },

    cargarDependencias() {
      axios.get('/api/dependencias/datos').then(datos => {
        this.dependenciasDatos = this.dependenciasDatosBuscador = datos.data
      })
    },

    editarDependencia(id) {
      const dependencia = this.dependenciasDatos.find(dependencia => {
        return dependencia.id === id
      })
      this.$refs.formulario.lista = Object.assign({}, dependencia)
      this.$refs.formulario.asignarCentroCostos(dependencia.centro_costo_id)
      this.mostrarModal('dependencia')
    },

    eliminarDependencia(id) {
      this.$swal
        .fire({
          title: '¿Está seguro(a)?',
          text:
            'Asegúrese de haber movido los funcionarios a otra dependencia, de lo contrario serán eliminados',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si,eliminarlo!',
        })
        .then(resultado => {
          if (resultado.value) {
            axios.delete(`/api/dependencias/${id}/eliminar`).then(respuesta => {
              this.cargarDependencias()
              this.$swal.fire('Correcto!', respuesta.data.message, 'success')
            })
          }
        })
    },
  },
  watch: {
    buscador() {
      let dp = null
      if (this.buscador !== null || this.buscador.length > 0) {
        dp = this.dependenciasDatosBuscador.filter(dependencia => {
          return (
            dependencia.nombre
              .toLowerCase()
              .indexOf(this.buscador.toLowerCase()) > -1
          )
        })
      } else {
        this.dependenciasDatos = this.dependenciasDatosBuscador
      }
      this.dependenciasDatos = dp
    },
  },
}
</script>
<style scoped>
table thead th {
  width: 25%;
}
.table-icon {
  font-weight: 700;
  margin: 0 10px;
  color: #2a93d5;
  font-size: 0.95rem;
}
</style>
