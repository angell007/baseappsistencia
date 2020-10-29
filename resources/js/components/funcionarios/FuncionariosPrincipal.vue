<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="mb-2">
          <h1 class="font-weight-bold">Lista de Funcionarios</h1>
          <div class="float-sm-right text-zero">
            <router-link to="/funcionarios/registro" class="btn btn-link mr-3">
              <i class="simple-icon-user-following"></i> Nuevo funcionario
            </router-link>
          </div>
        </div>
      </div>

      <div class="col-md-12">
        <div class="mb-2">
          <a
            class="btn pt-0 pl-0 d-inline-block d-md-none"
            data-toggle="collapse"
            href="#displayOptions"
            role="button"
            aria-expanded="true"
            aria-controls="displayOptions"
          >
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
              >Cantidad de Funcionarios: {{funcionariosDatos.length}}</span>
            </div>
          </div>
        </div>
        <div class="separator mb-5"></div>
      </div>
    </div>

    <!-- Listado de Funcionarios-->
    <div
      class="row list disable-text-selection"
      data-check-all="checkAll"
      id="lista_funcionarios"
      v-if="funcionariosDatos.length > 0"
    >
      <div
        class="col-xl-2 col-lg-2 col-12 col-md-2 col-sm-6 mb-4"
        v-for="funcionario in funcionariosDatos"
        :key="funcionario.id"
      >
        <tarjeta
          :id="funcionario.id"
          :fecha_ingreso="funcionario.fecha_ingreso"
          :image="funcionario.image"
          :nombres="funcionario.nombres"
          :apellidos="funcionario.apellidos"
          :identidad="funcionario.identidad"
          :cargo="funcionario.cargo.nombre"
        ></tarjeta>
      </div>
    </div>

    <div class="alert alert-secondary" v-else>
      <div class="row warning-icon mb-1">
        <i class="simple-icon-info mx-auto"></i>
      </div>
      <div class="row mt-1 text-cener">
        <p
          class="font-weight-bold mx-auto"
        >No existen funcionarios actualmente, para empezar a agregarlos vaya a la opción "Nuevo funcionario" en la parte superior derecha.</p>
      </div>
    </div>
  </div>
</template>

<script>
import Tarjeta from './detalles/Tarjeta'

export default {
  components: { Tarjeta },
  data() {
    return {
      buscador: '',
      mostrarRegistro: false,
      funcionariosDatos: [],
    }
  },

  created() {
    this.cargarFuncionarios()
  },

  methods: {
    cargarFuncionarios() {
      axios
        .get(`/api/${localStorage.getItem('tenant')}/funcionarios/datos`)
        .then(datos => {
          this.funcionariosDatos = datos.data
        })
        .catch(err => {
          if (err.response) {
            this.$swal.fire(
              'Error!',
              'Han ocurrido errores, por favor intente más tarde',
              'error'
            )
          }
        })
    },
  },
}
</script>

<style scoped>
#lista_funcionarios .card {
  height: 38%;
}
.warning-icon {
  font-size: 2rem;
}
</style>
