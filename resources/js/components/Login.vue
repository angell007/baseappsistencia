<template>
  <div style="height:100%;">
    <div class="fixed-background"></div>
    <div class="container">
      <div class="row h-100">
        <div class="col-12 col-md-10 mx-auto my-auto">
          <div class="card auth-card">
            <div class="position-relative image-side">
              <p class="text-white h2">LA MAGIA ESTÁ EN LOS DETALLES</p>
              <p class="white mb-0">
                Por favor, utilice sus credenciales para ingresar
                <br />Si no es miembro, por favor solicite un
                <a href="#" class="white">DEMO</a>.
              </p>
            </div>
            <div class="form-side">
              <a href="https://app.geneticapp.co">
                <span class="logo-single"></span>
              </a>
              <h6 class="mb-4">Iniciar Sesión</h6>
              <form @submit.prevent="validarAntesDeEnviar">
                <label class="form-group has-float-label mb-4">
                  <input
                    class="form-control"
                    type="text"
                    name="usuario"
                    v-validate="'required|email'"
                    v-model="formulario.usuario"
                    placeholder
                  />
                  <span>Correo Electrónico</span>
                  <small class="invalid">{{ errors.first("usuario") }}</small>
                </label>
                <label class="form-group has-float-label mb-4">
                  <input
                    class="form-control"
                    type="password"
                    name="password"
                    v-validate="'required|min:6'"
                    v-model="formulario.password"
                    placeholder
                  />
                  <span>Contraseña</span>
                  <small class="invalid">{{ errors.first("password") }}</small>
                </label>
                <div class="d-flex justify-content-between align-items-center">
                  <a href="#">Olvidó su Contraseña?</a>
                  <button
                    class="btn btn-primary btn-lg btn-shadow"
                    type="submit"
                  >
                    INICIAR SESIÓN
                  </button>
                </div>
                <notifications
                  group="notificaciones"
                  position="top center"
                  :width="500"
                />
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {

    beforeCreate: function() {
        document.body.className = 'background no-footer ltr rounded';
    },
  data() {
    return {
      formulario: {
        usuario: '',
        password: '',
      },
    }
  },
  methods: {
    async validarAntesDeEnviar() {
      let validado = await this.$validator.validateAll()
      if (validado) {
        this.iniciarSesion()
        return
      }
      this.$notify({
        group: 'notificaciones',
        title: 'Error',
        text: 'Debe corregir los errores antes de iniciar sesión',
        type: 'error',
      })
    },
    iniciarSesion() {
      axios
        .post('/api/auth/login', this.$data.formulario)
        .then(datos => {
        console.log(datos.data);
          localStorage.setItem('token', datos.data.token)
          localStorage.setItem('tenant', datos.data.User['empresa_name'])
          eventEmitter.$emit('autenticado')
          this.$router.push('/tablero')
        })
        .catch(error => {
          if (error.response.status == 401) {
            this.$notify({
              group: 'notificaciones',
              title: 'Error',
              text: 'Credenciales inválidas, intente nuevamente',
              type: 'error',
            })
          }
        })
    },
  },
  created() {},
}
</script>

<style>
</style>
