<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="mb-2">
          <h1 class="font-weight-bold">Entidades prestadoras de salud</h1>
          <div class="float-sm-right text-zero">
            <button type="button" class="btn btn-link mr-1" @click="mostrarModal('eps',true)">
              <i class="simple-icon-plus"></i> Nueva Eps
            </button>
          </div>
        </div>
      </div>
    </div>

    <modal id="eps" ref="eps">
      <template slot="titulo">Agregar/Editar eps</template>
      <template slot="contenido">
        <eps-formulario ref="formulario" @recargar="getEps"></eps-formulario>
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
                  <span class="text-muted text-small">Cantidad de Eps: {{epsDatos.length}}</span>
                </div>
              </div>
            </div>
            <div class="separator mb-5"></div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <table class="table table-bordered table-striped table-sm" role="grid">
              <thead class="bg-light">
                <tr role="row">
                  <th>Nombre</th>
                  <th class="text-center">NIT</th>
                  <th class="text-center">Acciones</th>
                </tr>
              </thead>

              <paginate ref="paginator" name="epsDatos" :list="epsDatos" :per="10" tag="tbody">
                <tr v-for="(eps,index) in paginated('epsDatos')" :key="index">
                  <td class="custom-label">{{ eps.nombre}}</td>
                  <td class="text-center custom-label">{{ eps.nit}}</td>
                  <td class="text-center">
                    <template v-if="eps.editable">
                      <a href="#" class="table-icon" @click.prevent="editEps(eps.id)">
                        <i class="simple-icon-note"></i>
                      </a>
                      <a href="#" class="table-icon" @click.prevent="deleteEps(eps.id)">
                        <i class="simple-icon-trash"></i>
                      </a>
                    </template>
                    <template v-else>
                      <span class="custom-label">No editable</span>
                    </template>
                  </td>
                </tr>
              </paginate>
            </table>
            <paginate-links
              for="epsDatos"
              :show-step-links="true"
              :classes="{'ul': 'pagination', 'li': 'page-item', 'a': 'page-link'}"
            ></paginate-links>
            <small
              class="font-weight-bold"
              v-if="$refs.paginator"
            >Mostrando {{$refs.paginator.pageItemsCount}} resultados</small>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import EpsFormulario from './EpsFormulario'
import Modal from '../utiles/Modal'

export default {
  components: { EpsFormulario, Modal },
  data() {
    return {
      epsDatos: [],
      epsDatosBuscador: [],
      buscador: '',
      paginate: ['epsDatos'],
    }
  },

  created() {
    this.getEps()
  },

  methods: {
    mostrarModal(modal, limpiarFormulario = false) {
      if (limpiarFormulario) {
        this.$refs.formulario.limpiarFormulario()
        this.$refs.formulario.$validator.reset()
      }
      this.$refs[modal].mostrarModal()
    },

    getEps() {
      axios.get('/api/eps/datos').then(datos => {
        this.epsDatos = this.epsDatosBuscador = datos.data
      })
    },

    editEps(id) {
      const eps = this.epsDatos.find(eps => {
        return eps.id === id
      })
      this.$refs.formulario.lista = Object.assign({}, eps)
      this.mostrarModal('eps')
    },

    deleteEps(id) {
      this.$swal
        .fire({
          title: '¿Está seguro(a)?',
          text:
            'Asegúrese de haber movido los funcionarios a otra eps, de lo contrario serán eliminados',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si,eliminarlo!',
        })
        .then(resultado => {
          if (resultado.value) {
            axios
              .delete(`/api/eps/${id}/eliminar`)
              .then(respuesta => {
                this.getEps()
                this.$swal.fire('Correcto!', respuesta.data.message, 'success')
              })
              .catch(error => {
                if (error.response) {
                  this.$swal.fire(
                    'Oops!',
                    'Han ocurrido errores, por favor intente más tarde',
                    'error'
                  )
                }
              })
          }
        })
    },
  },
  watch: {
    buscador() {
      let eps = null
      if (this.buscador !== null || this.buscador.length > 0) {
        eps = this.epsDatosBuscador.filter(eps => {
          return (
            eps.nombre.toLowerCase().indexOf(this.buscador.toLowerCase()) > -1
          )
        })
      } else {
        this.epsDatos = this.epsDatosBuscador
      }

      this.epsDatos = eps
    },
  },
}
</script>

<style scoped>
.table-icon {
  font-weight: 700;
  margin: 0 10px;
  color: #2a93d5;
  font-size: 0.95rem;
}
</style>
