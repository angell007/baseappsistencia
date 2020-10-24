<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="mb-2">
          <h1 class="font-weight-bold">Encuestas Aplicables</h1>
          <div class="float-sm-right text-zero">

            <router-link to="/crearencuesta" class="btn btn-link mr-3">
              <i class="simple-icon-plus"></i> Nueva Encuesta
            </router-link>
          </div>
        </div>
      </div>
    </div>

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
                  >Cantidad de Encuestas Creadas: {{encuestasDatos.length}}</span>
                </div>
              </div>
            </div>
            <div class="separator mb-5"></div>
          </div>
        </div>

        <div class="row" v-if="encuestasDatos.length">
          <div class="col-md-12">
            <table role="grid" class="table table-sm table-bordered table-striped">
              <thead class="bg-light">
                <tr>
                  <th>Nombre</th>
                  <th class="text-center">Tipo Aplicación</th>
                  <th class="text-center">Frecuencia Aplicación</th>
                  <th class="text-center">Restrictiva</th>
                  <th class="text-center">Estado</th>
                  <th class="text-center" style="width:125px !important;">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(encuesta, index) in encuestasDatos" :key="index" v-bind:class="[encuesta.estado]" >
                  <td class="">{{ encuesta.nombre}}</td>
                  <td class="text-center">{{ encuesta.tipo_aplicacion}}</td>
                  <td class="text-center">{{ encuesta.frecuencia_aplicacion}}</td>
                  <td class="text-center">{{ encuesta.restrictiva}}</td>
                  <td class="text-center">{{ encuesta.estado}}</td>
                  <td class="text-center">
                    <a
                      href @click.prevent="redireccionar(encuesta.id)"
                      class="table-icon"                     >
                      <i class="simple-icon-magnifier"></i>
                    </a>
                    <a
                      href="#"
                      class="table-icon"
                      v-if="encuesta.estado=='Activa'"
                      @click.prevent="editarEncuesta(encuesta.id)"
                    >
                      <i class="simple-icon-note"></i>
                    </a>
                    <a
                      href="#"
                      class="table-icon"
                      v-if="encuesta.estado=='Activa'"
                      @click.prevent="eliminarEncuesta(encuesta.id)"
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
          >No existen encuestas actualmente, para empezar a agregarlas vaya a la opción "Nueva Encuesta" en la parte superior derecha</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
    data() {
        return {
        encuestasDatos: [],
        encuestasDatosBuscador: [],
        buscador: '',
        }
    },
    mounted() {
        this.cargarEncuestas()
    },
    methods: {
        redireccionar(id) {
            this.$router.push({
                name: 'EncuestaVer',
                params: { id: id },
            })
        },
        cargarEncuestas() {
            axios.get('/api/encuestas/datos').then(datos => {
                this.encuestasDatos = this.encuestasDatosBuscador = datos.data
            })
        },

        editarEncuesta(id) {

        },

        eliminarEncuesta(id) {
            this.$swal
                .fire({
                title: '¿Está seguro(a)?',
                text: 'Al Inactivar la encuesta, los resultados ya recopilados se mantendrán pero no se podrán aplicar más',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Inactivar!',
                })
                .then(resultado => {
                if (resultado.value) {
                    axios.delete(`/api/encuestas/${id}/eliminar`).then(respuesta => {
                    this.cargarEncuestas()
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
            dp = this.encuestasDatosBuscador.filter(encuesta => {
            return (
                encuesta.nombre
                .toLowerCase()
                .indexOf(this.buscador.toLowerCase()) > -1
            )
            })
        } else {
            this.encuestasDatos = this.encuestasDatosBuscador
        }
        this.encuestasDatos = dp
        },
    }
}
</script>
<style scoped>
    .table tr td {
    text-transform: uppercase;
    }
    .Inactiva{
        background-color: #dc3545!important;
        color: #ffffff !important;
    }
    .Inactiva a{
        color: #ffffff !important;
    }
</style>
