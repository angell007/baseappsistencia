<template>
<div>
  <nav class="navbar fixed-top">
    <div class="d-flex align-items-center navbar-left">
      <a href="#" class="menu-button d-none d-md-block" @click.prevent="ocultarSidebar">
        <svg class="main" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 9 17">
          <rect x="0.48" y="0.5" width="7" height="1"></rect>
          <rect x="0.48" y="7.5" width="7" height="1"></rect>
          <rect x="0.48" y="15.5" width="7" height="1"></rect>
        </svg>
        <svg class="sub" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 17">
          <rect x="1.56" y="0.5" width="16" height="1"></rect>
          <rect x="1.56" y="7.5" width="16" height="1"></rect>
          <rect x="1.56" y="15.5" width="16" height="1"></rect>
        </svg>
      </a>

      <a
        href="#"
        class="menu-button-mobile d-xs-block d-sm-block d-md-none"
        @click.prevent="ocultarSidebar"
      >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 17">
          <rect x="0.5" y="0.5" width="25" height="1"></rect>
          <rect x="0.5" y="7.5" width="25" height="1"></rect>
          <rect x="0.5" y="15.5" width="25" height="1"></rect>
        </svg>
      </a>

       <img :src="`${Empresa.Imagen}`" class="logo-cliente">
    </div>

    <a class="navbar-logo" href="#">
      <span class="logo d-block"></span>
      <span class="logo-mobile d-none d-xs-block"></span>
    </a>

    <div class="navbar-right">
      <div class="header-icons d-inline-block align-middle">

          <!-- <div class="position-relative d-inline-block">
          <button
            @click="mostarModal('NuevoTicket')"
            class="header-icon btn btn-empty"
            type="button"
            aria-expanded="false"
          >
            <i class="iconsmind-Support"></i>
          </button>


        </div> -->


          <div class="position-relative d-inline-block">
          <button
            class="header-icon btn btn-empty"
            type="button"
            id="notificationButton"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >
            <i class="simple-icon-bell"></i>
            <span class="count">0</span>
          </button>
          <div
            class="dropdown-menu dropdown-menu-right mt-3 scroll position-absolute"
            id="notificationDropdown"
          >
            <div class="d-flex flex-row mb-3 pb-3 border-bottom">
              <!--
              <a href="#">
                <img src alt class="img-thumbnail list-thumbnail xsmall border-0 rounded-circle">
              </a>
              <div class="pl-3 pr-2">
                <a href="#">
                  <p class="font-weight-medium mb-1">Augusto Carrillo ha llegado tarde</p>
                  <p class="text-muted mb-0 text-small">01/04/2020 - 09:57am</p>
                </a>
              </div> 
              -->
            </div>
          </div>
        </div>

        <!--
        <button
          class="header-icon btn btn-empty d-none d-sm-inline-block"
          type="button"
          id="fullScreenButton"
        >
          <i class="simple-icon-size-fullscreen"></i>
          <i class="simple-icon-size-actual"></i>
        </button> -->
      </div>

      <div class="user d-inline-block">
        <button
          class="btn btn-empty p-0"
          type="button"
          data-toggle="dropdown"
          aria-haspopup="true"
          aria-expanded="false"
        >
          <span>
            {{Funcionario.Nombre}} 
            <img :src="`${Funcionario.Imagen}`" class="img-funcionario" alt="" >
          </span>
        </button>

        <div class="dropdown-menu dropdown-menu-right mt-3">
          <a class="dropdown-item" href="#" @click.prevent="cerrarSesion">Cerrar Sesión</a>
          <a class="dropdown-item" href="https://www.geneticapp.co/terminos-y-condiciones-y-politica-de-proteccion-de-datos-personales/" target="_blank" >Términos y Condiciones</a>
        </div>
      </div>
    </div>
  </nav>
  <!--
  <modal id="NuevoTicket" ref="NuevoTicket" :esLg="false">
        <template slot="titulo">Nuevo Ticket de Soporte</template>
        <template slot="contenido">
        <form >
            <div class="form-group row">
            <label class="custom-label col-form-label col-md-5" >Tipo de Solicitud</label>
            <select
                name="tipo"
                class="form-control custom-control col-md-6"
            >
                <option value="Error">Error</option>
                <option value="Consulta">Consulta</option>
                <option value="Mejora">Mejora</option>
                <option value="Sugerencia">Sugerencia</option>
            </select>
            </div>

            <div class="form-group row">
            <label class="custom-label col-form-label col-md-5">Detalles</label>
            <textarea
                name="detalles"
                data-vv-as="detalles"
                class="form-control col-md-6"
                placeholder="Indique detalladamente su situación"
            ></textarea>
            <small
                class="invalid col-md-6 offset-5"
                v-if="errors.has('detalles')"
            >{{errors.first('detalles')}}</small>
            </div>
            <div class="form-group row">
                <label class="label label-success">En un lapso no mayor a 24 horas estaremos dando respuesta a su solicitud. Si el problema perciste por favor comunicarse al teléfono (7) 6973188</label>
            </div>


            <div class="form-group text-right">
            <button type="submit" class="btn btn-secondary raised">Reportar</button>
            </div>
        </form>
        </template>
    </modal> -->
    </div>
</template>

<script>
import Modal from './utiles/Modal'
export default {
  components: {
    Modal
  },
  data() {
    return {
      Funcionario: {
        Nombre:'',
        Imagen:'',
      },
      Empresa:{
        Nombre:'',
        Imagen:''
      }
    }
  },
  created() {
    this.getInformacion()
  },
  methods: {
    getInformacion(){
      var usuario = JSON.parse(localStorage.getItem('usuario'));
      var empresa = JSON.parse(localStorage.getItem('empresa'));

      this.Funcionario.Nombre= usuario.nombres.split(' ')[0]+" "+usuario.apellidos.split(' ')[0];
      this.Funcionario.Imagen=  ((usuario.image) ? +usuario.image : '/img/robot.jpg');

      this.Empresa.Nombre= empresa.razon_social;
      this.Empresa.Imagen=  ((empresa.image) ? +empresa.imagen : 'https://via.placeholder.com/150x50.png?text='+empresa.razon_social.replace(" ","+")); 
    },
    ocultarSidebar() {
      eventEmitter.$emit('ocultarSidebar', false)
    },
    mostarModal(referencia) {
      setTimeout(() => {
        this.$refs[referencia].mostrarModal()
      }, 500)
    },
    cerrarSesion() {
      const token = localStorage.getItem('token')
      axios
        .post(
          '/api/auth/logout',
          {},
          { headers: { Authorization: 'Bearer ' + token } }
        )
        .then(respuesta => {
          localStorage.removeItem('token')
          localStorage.removeItem('tenant')
          this.$emit('logout')
        })
        .catch(error => {
          if (error.response.status == 400) {
            this.$swal.fire(
              'Error!',
              'No se encuentra autorizado para realizar esta acción',
              'error'
            )
          }
        })
    },
  },
}
</script>
<style>
</style>

