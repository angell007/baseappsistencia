<template>
  <div class="container">
    <div class="row">
      <div class="col-8">
        <div class="card">
          <div class="card-title mt-2 ml-4">
            <div class="row">
              <div class="col-md-6">
                <h3 class="font-weight-bold mt-2">Listado de Novedades - {{nombreMes | capital}}</h3>
              </div>
              <div class="col-md-6 text-right">
                <button class="btn btn-link mr-4 mt-2" @click="mostrarModal('novedad',true)">
                  <i class="simple-icon-plus"></i> Nueva
                </button>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-5">
                <div class="form-group">
                  <label for="fecha_inicio" class="custom-label">Fecha de Inicio</label>
                  <input
                    type="date"
                    name="fecha_inicio"
                    v-model="fecha_inicio"
                    class="form-control custom-control"
                  >
                </div>
              </div>
              <div class="col-md-5">
                <div class="form-group">
                  <label for="fecha_fin" class="custom-label">Fecha de Fin</label>
                  <input
                    type="date"
                    name="fecha_fin"
                    v-model="fecha_fin"
                    class="form-control custom-control"
                  >
                </div>
              </div>
              <div class="col-md-2 pt-4 text-center">
                <button
                  class="btn btn-outline-secondary default btn-xs mt-2 w-100"
                  @click="cargarNovedades(fecha_inicio,fecha_fin)"
                >
                  <i class="iconsmind-Search-People"></i> Filtrar
                </button>
              </div>
            </div>
            <div class="row mt-2" v-if="novedadesDatos.length">
              <div class="col-12 mt-2">
                <h4 class="font-weight-bold mb-4">Funcionarios</h4>
              </div>

              <div
                class="col-12 mb-4 fila-novedad"
                v-for="(nov,index) in novedadesDatos"
                :key="index"
              >
                <div
                  class="align-self-center d-flex flex-column flex-md-row justify-content-between min-width-zero align-items-md-center"
                >
                  <p class="w-40 w-xs-100 mb-0">
                    <img v-if="nov.funcionario.image!=null" :src="`/back/storage/app/public/${nov.funcionario.image}`" class="img-funcionario mr-1"  alt="">
                    <img v-else :src="`/img/robot.jpg`" class="img-funcionario mr-1" alt="" >
                    <span
                      class="font-weight-bold"
                    >{{nov.funcionario.nombres}} {{nov.funcionario.apellidos}}</span>
                  </p>

                  <p
                    class="mb-1 font-weight-bold w-15 w-xs-100"
                  >{{nov.funcionario.dependencia.nombre}}</p>
                  <p class="mb-1 font-weight-bold w-15 w-xs-100">{{nov.tipo}}</p>
                  <div class="w-xs-100 detalles">
                    <button class="btn btn-link" @click="mostrarDetalles(nov.id,index)">
                      <i class="simple-icon-magnifier font-weight-bold"></i>
                    </button>
                  </div>
                </div>
                <div class="mt-3">
                  <detalles-novedad
                    :detalle="nov"
                    :ref="'detallesNovedad'+ nov.id"
                    @editar="editarNovedad"
                    @eliminar="eliminarNovedad"
                  ></detalles-novedad>
                </div>
              </div>
            </div>
            <div class="alert alert-secondary" v-else>
              <p
                class="font-weight-bold text-center"
              >No existen novedades reportadas en el periodo actual.</p>
            </div>
          </div>
        </div>

        <!-- Modal -->
        <modal ref="novedad" id="novedad" :esLg="true">
          <template slot="titulo">Agregar/Editar novedad</template>
          <template slot="contenido">
            <novedad-formulario
              ref="novedadFormulario"
              @recargar="cargarNovedades(fecha_inicio,fecha_fin)"
            ></novedad-formulario>
          </template>
        </modal>
        <!-- Modal -->
      </div>

      <div class="col-4">
        <div class="row">
          <div class="col-6">
            <div class="card mb-4">
              <div class="card-body text-center incapacidades">
                <i class="iconsmind-Plane"></i>
                <p class="card-text mb-0">Vacaciones</p>
                <p class="lead text-center">{{ cantidadTiposNov('Vacaciones') || '0'}}</p>
              </div>
            </div>
          </div>
          <div class="col-6">
            <div class="card mb-4">
              <div class="card-body text-center incapacidades">
                <i class="iconsmind-Ambulance"></i>
                <p class="card-text mb-0">Incapacidades</p>
                <p class="lead text-center">{{cantidadTiposNov('Incapacidad') || '0'}}</p>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-6">
            <div class="card mb-4">
              <div class="card-body text-center incapacidades">
                <i class="iconsmind-Baby-Clothes"></i>
                <p class="card-text mb-0">Licencias</p>
                <p class="lead text-center">{{cantidadTiposNov('Licencia') || '0'}}</p>
              </div>
            </div>
          </div>
          <div class="col-6">
            <div class="card mb-4">
              <div class="card-body text-center incapacidades">
                <i class="iconsmind-Calendar-3"></i>
                <p class="card-text mb-0">Permisos</p>
                <p class="lead text-center">{{cantidadTiposNov('Permiso') || '0'}}</p>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-6">
            <div class="card mb-4">
              <div class="card-body text-center incapacidades">
                <i class="iconsmind-Door"></i>
                <p class="card-text mb-0">Abandonos</p>
                <p class="lead text-center">{{cantidadTiposNov('Abandono') || '0'}}</p>
              </div>
            </div>
          </div>
          <div class="col-6">
            <div class="card mb-4">
              <div class="card-body text-center incapacidades">
                <i class="iconsmind-Lock-User"></i>
                <p class="card-text mb-0">Suspensiones</p>
                <p class="lead text-center">{{cantidadTiposNov('Suspensión') || '0'}}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import NovedadFormulario from './NovedadFormulario'
import DetallesNovedad from './DetallesNovedad'
import Modal from '../utiles/Modal'

export default {
  components: { NovedadFormulario, DetallesNovedad, Modal },
  data() {
    return {
      fecha_inicio: moment()
        .startOf('month')
        .format(moment.HTML5_FMT.DATE),
      fecha_fin: moment()
        .endOf('month')
        .format(moment.HTML5_FMT.DATE),
      novedadesDatos: [],
    }
  },
  created() {
    this.cargarNovedades(this.fecha_inicio, this.fecha_fin)
  },

  methods: {
    cargarNovedades(fechaInicio, fechaFin) {
      axios
        .get(`/api/${localStorage.getItem('tenant')}/novedades/datos/${fechaInicio}/${fechaFin}`)
        .then(datos => {
          this.novedadesDatos = datos.data
        })
    },

    mostrarModal(nombreModal, limpiarDatos = false) {
      if (limpiarDatos) {
        this.$refs.novedadFormulario.limpiarFormulario()
        this.$refs.novedadFormulario.$validator.reset()
      }
      this.$refs[nombreModal].mostrarModal()
    },

    mostrarDetalles(id, index) {
      let novedad = `detallesNovedad${id}`
      this.$refs[novedad][0].estadoActivo = !this.$refs[novedad][0].estadoActivo
    },

    cantidadTiposNov(tipo) {
      let tipos = this.novedadesDatos.filter(novedad => {
        return novedad.tipo === tipo
      })
      return tipos.length
    },

    editarNovedad(id) {
      let novedad = this.novedadesDatos.find(novedad => {
        return novedad.id === id
      })

      this.$refs.novedadFormulario.funcionario = novedad.funcionario

      delete novedad.funcionario
      delete novedad.novedad

      this.$refs.novedadFormulario.lista = Object.assign({}, novedad)
      this.$refs.novedadFormulario.deshabilitarCampo = true

      if (novedad.modalidad == 'Hora') {
        this.$refs.novedadFormulario.lista.fecha_inicio = this.formatoFechaHora(
          novedad.fecha_inicio
        )
        this.$refs.novedadFormulario.lista.fecha_fin = this.formatoFechaHora(
          novedad.fecha_fin
        )
      } else {
        this.$refs.novedadFormulario.lista.fecha_inicio = this.formatoFecha(
          novedad.fecha_inicio
        )
        this.$refs.novedadFormulario.lista.fecha_fin = this.formatoFecha(
          novedad.fecha_fin
        )
      }
      this.mostrarModal('novedad')
    },

    eliminarNovedad(id) {
      this.$swal
        .fire({
          title: '¿Está seguro(a) de eliminar la novedad?',
          text: 'No se podrán revertir los cambios',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#2a93d5',
          cancelButtonText: 'Cancelar',
          confirmButtonText: 'Si, eliminarla!',
        })
        .then(resultado => {
          if (resultado.value) {
            axios.delete(`/api/${localStorage.getItem('tenant')}/novedades/${id}/eliminar`).then(respuesta => {
              this.$swal.fire('Eliminada!', respuesta.data.message, 'success')
            })
          }
          this.cargarNovedades(this.fecha_inicio, this.fecha_fin)
        })
    },

    formatoFecha(fecha) {
      return moment(fecha).format('YYYY-MM-DD')
    },

    formatoFechaHora() {
      return moment(fecha).format(moment.HTML5_FMT.DATETIME_LOCAL)
    },
  },
  computed: {
    nombreMes() {
      return moment(this.fecha_inicio).format('MMMM')
    },
  },
}
</script>
<style scoped>
.img-funcionario {
  width: 38px;
  border-radius: 50%;
  border: 1px solid #ccc;
}
.fila-novedad {
  border-bottom: 1px solid #ccc;
}
.incapacidades i {
  font-size: 38px;
  line-height: 66px;
  color: #2a93d5;
}
</style>
