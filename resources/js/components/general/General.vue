<template>
  <div class="container">
    <div class="card" v-if="existeEmpresa">
      <div class="card-title pl-4 pt-3 mb-0">
        <h2 class="float-md-left font-weight-bold text-uppercase text-muted">
          Resumen
          <span class="empresa">{{empresa.razon_social}}</span>
        </h2>
        <button
          class="btn btn-link float-md-right pr-5 config-option"
          @click="mostrarModal('datosConfiguracion')"
        >
          <i class="simple-icon-settings"></i> Cambiar configuración de pago
        </button>
      </div>

      <!-- Modal de configuración de pago -->
      <modal id="datosConfiguracion" :esLg="true" ref="datosConfiguracion">
        <template slot="titulo">Configuración de pago</template>
        <template slot="contenido">
          <datos-configuracion
            :empresaId="empresa.id"
            :empresaConfiguracion="empresa.configuracion_pago"
            @notificar="mostrarMensaje"
          ></datos-configuracion>
        </template>
      </modal>
      <!-- Modal de configuración de pago -->

      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <div class="card-partial">
              <div class="card-body">
                <div class="row">
                  <h1 class="font-weight-bold text-muted col-md-6 subtitle">Datos Básicos</h1>
                  <div class="col-md-6 text-right">
                    <button
                      class="btn btn-link pt-0 pr-0 edit"
                      @click="mostrarModal('datosBasicos')"
                    >
                      <i class="simple-icon-pencil font-weight-bold"></i> Editar
                    </button>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-5">
                    <p class="font-weight-bold text-muted text-right">Razón social</p>
                  </div>
                  <div class="col-md-6">
                    <p class="item">{{empresa.razon_social}}</p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5">
                    <p class="font-weight-bold text-muted text-right">NIT</p>
                  </div>
                  <div class="col-md-6">
                    <p class="item">{{empresa.numero_documento}}</p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5">
                    <p class="font-weight-bold text-muted text-right">Fecha de constitución</p>
                  </div>
                  <div class="col-md-6">
                    <p class="item">{{empresa.fecha_constitucion}}</p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5">
                    <p class="font-weight-bold text-muted text-right">Email de contacto</p>
                  </div>
                  <div class="col-md-6">
                    <p class="item">{{empresa.email_contacto}}</p>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-5">
                    <p class="font-weight-bold text-muted text-right">Teléfono</p>
                  </div>
                  <div class="col-md-6">
                    <p class="item">{{empresa.telefono_contacto}}</p>
                  </div>
                </div>
              </div>
            </div>
            <!-- Modal de datos básicos -->
            <modal id="datosBasicos" :esLg="false" ref="datosBasicos">
              <template slot="titulo">Datos básicos</template>
              <template slot="contenido">
                <datos-basicos :empresaEditar="empresa" @notificar="mostrarMensaje"></datos-basicos>
              </template>
            </modal>
            <!-- Modal de datos básicos -->
          </div>
          <div class="col-md-6">
            <div class="card-partial">
              <div class="card-body">
                <div class="row">
                  <h1 class="font-weight-bold text-muted col-md-6 subtitle">Datos de Pila</h1>
                  <div class="col-md-6 text-right">
                    <button class="btn btn-link pt-0 pr-0 edit" @click="mostrarModal('datosPila')">
                      <i class="simple-icon-pencil font-weight-bold"></i> Editar
                    </button>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5">
                    <p class="font-weight-bold text-muted text-right">Operador de Pago</p>
                  </div>
                  <div class="col-md-6">
                    <p class="item">{{empresa.operador_pago}}</p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5">
                    <p class="font-weight-bold text-muted text-right">Companía ARL</p>
                  </div>
                  <div class="col-md-6">
                    <p class="item">{{empresa.arl.nombre}}</p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5">
                    <p class="font-weight-bold text-muted text-right">Aplica Ley 1429 de 2010</p>
                  </div>
                  <div class="col-md-6">
                    <p class="item" v-if="empresa.ley_1429">Si</p>
                    <p class="item" v-else>No</p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5">
                    <p class="font-weight-bold text-muted text-right">Aplica Ley 590 de 2010</p>
                  </div>
                  <div class="col-md-6">
                    <p class="item" v-if="empresa.ley_590">Si</p>
                    <p class="item" v-else>No</p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5">
                    <p class="font-weight-bold text-muted text-right">Aplica Ley 1607 de 2012</p>
                  </div>
                  <div class="col-md-6">
                    <p class="item" v-if="empresa.ley_1607">Si</p>
                    <p class="item" v-else>No</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Modal de datos de pila -->
          <modal id="datosPila" :esLg="true" ref="datosPila">
            <template slot="titulo">Datos de pila</template>
            <template slot="contenido">
              <datos-pila :empresaEditar="empresa" @notificar="mostrarMensaje"></datos-pila>
            </template>
          </modal>
          <!-- Modal de datos de pila -->
        </div>

        <div class="row mt-3">
          <div class="col-md-6">
            <div class="card-partial">
              <div class="card-body">
                <div class="row">
                  <h1 class="font-weight-bold text-muted col-md-6 subtitle">Datos de Pago</h1>
                  <div class="col-md-6 text-right">
                    <button class="btn btn-link pt-0 pr-0 edit" @click="mostrarModal('datosPago')">
                      <i class="simple-icon-pencil font-weight-bold"></i> Editar
                    </button>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <p class="font-weight-bold text-muted text-right">Frecuencia de Pago</p>
                  </div>
                  <div class="col-md-5">
                    <p class="item">{{empresa.frecuencia_pago}}</p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <p class="font-weight-bold text-muted text-right">Medio de Pago</p>
                  </div>
                  <div class="col-md-5">
                    <p class="item">{{empresa.medio_pago}}</p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <p class="font-weight-bold text-muted text-right">Banco</p>
                  </div>
                  <div class="col-md-5">
                    <p class="item">{{empresa.banco.nombre}}</p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <p class="font-weight-bold text-muted text-right">Tipo de cuenta</p>
                  </div>
                  <div class="col-md-5">
                    <p class="item">{{empresa.tipo_cuenta}}</p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <p class="font-weight-bold text-muted text-right">Número de cuenta</p>
                  </div>
                  <div class="col-md-5">
                    <p class="item">{{empresa.numero_cuenta}}</p>
                  </div>
                </div>
              </div>
            </div>
            <!-- Modal de datos de pago -->
            <modal id="datosPago" :esLg="true" ref="datosPago">
              <template slot="titulo">Datos de pago</template>
              <template slot="contenido">
                <datos-pago :empresaEditar="empresa" @notificar="mostrarMensaje"></datos-pago>
              </template>
            </modal>
            <!-- Modal de datos de pago -->
          </div>

          <div class="col-md-6">
            <div class="card-partial">
              <div class="card-body">
                <div class="row">
                  <h1 class="font-weight-bold text-muted col-md-6 subtitle">Datos Nómina</h1>
                  <div class="col-md-6 text-right">
                    <button
                      class="btn btn-link pt-0 pr-0 edit"
                      @click="mostrarModal('datosNomina')"
                    >
                      <i class="simple-icon-pencil font-weight-bold"></i> Editar
                    </button>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 offset-1">
                    <p class="font-weight-bold text-muted text-right">Máximas horas extras</p>
                  </div>
                  <div class="col-md-4">
                    <p class="item">{{empresa.max_horas_extras}}</p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 offset-1">
                    <p class="font-weight-bold text-muted text-right">Máximos festivos legales</p>
                  </div>
                  <div class="col-md-4">
                    <p class="item">{{empresa.max_festivos_legales}}</p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 offset-1">
                    <p class="font-weight-bold text-muted text-right">Máximas llegadas Tarde</p>
                  </div>
                  <div class="col-md-4">
                    <p class="item">{{empresa.max_llegadas_tarde}}</p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 offset-1">
                    <p class="font-weight-bold text-muted text-right">Salario Base Mensual</p>
                  </div>
                  <div class="col-md-4">
                    <p class="item">{{empresa.salario_base | moneda}}</p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 offset-1">
                    <p class="font-weight-bold text-muted text-right">Auxilio de Transporte</p>
                  </div>
                  <div class="col-md-4">
                    <p class="item">{{empresa.auxilio_transporte | moneda}}</p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 offset-1">
                    <p class="font-weight-bold text-muted text-right">Hora Inicio noche</p>
                  </div>
                  <div class="col-md-4">
                    <p class="item">{{empresa.hora_inicio_noche}}</p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 offset-1">
                    <p class="font-weight-bolder text-muted text-right">Hora Fin Noche</p>
                  </div>
                  <div class="col-md-4">
                    <p class="item">{{empresa.hora_fin_noche}}</p>
                  </div>
                </div>
              </div>
            </div>
            <!-- Modal de datos de nómina -->
            <modal id="datosNomina" :esLg="false" ref="datosNomina">
              <template slot="titulo">Datos de nómina</template>
              <template slot="contenido">
                <datos-nomina :empresaEditar="empresa" @notificar="mostrarMensaje"></datos-nomina>
              </template>
            </modal>
            <!-- Modal de datos de nómina -->
          </div>
        </div>
      </div>
    </div>
    <!-- Componente de notificaciones -->
    <notifications group="notificaciones" position="bottom right"/>

    <!-- Componente de notificaciones -->
  </div>
</template>

<script>
import DatosBasicos from './actualizacion/DatosBasicos'
import DatosNomina from './actualizacion/DatosNomina'
import DatosPago from './actualizacion/DatosPago'
import DatosPila from './actualizacion/DatosPila'
import DatosConfiguracion from './actualizacion/DatosConfiguracion'
import Modal from '../utiles/Modal'

export default {
  components: {
    DatosBasicos,
    DatosNomina,
    DatosPago,
    DatosPila,
    DatosConfiguracion,
    Modal,
  },
  data() {
    return {
      existeEmpresa: '',
      empresa: {},
      configuracionRegistrada: false,
    }
  },
  created() {
    this.getEmpresaDatos()
  },
  methods: {
    cargarConfiguracionPago() {
      let token = this.getToken();
      const config = {
        headers: { Authorization: `Bearer ${token}` }
       };
      axios
        .get(`/api/${localStorage.getItem('tenant')}/general/empresa/configuracion`, config)
        .then(datos => {
          if (datos.data) {
            this.configuracionRegistrada = true
            return
          }
        })
        .catch(error => {
          if (error.response) {
            this.mostrarAdvertenciaModalConfigPago()
          }
        })
    },
    getEmpresaDatos() {
      let token = this.getToken();
      const config = {
        headers: { Authorization: `Bearer ${token}` }
       };
      axios.get(`/api/${localStorage.getItem('tenant')}/general/empresa/datos`,config).then(datos => {
        this.datosEmpresa = datos.data

        if (!this.datosEmpresa) {
          this.existeEmpresa = false
          this.mostrarAdvertenciaModal()
          return
        }
        this.empresa = this.datosEmpresa;
        this.existeEmpresa = true

        this.cargarConfiguracionPago()
      })
    },
    mostrarModal(referencia) {
      this.$refs[referencia].mostrarModal()
    },
    /** Cuando aún no se ha registrado la empresa */
    mostrarAdvertenciaModal() {
      this.$swal
        .fire(
          'No ha registrado la compañia aún!',
          'A continuación se iniciará el proceso de registro',
          'warning'
        )
        .then(() => {
          this.$router.push({ name: 'EmpresaFormulario' })
        })
    },
    mostrarAdvertenciaModalConfigPago() {
      setTimeout(() => {
        if (this.existeEmpresa) {
          this.$swal.fire(
            'No ha registrado la configuración de pago de la compañía!',
            'Esto es necesario para realizar cálculos en los pagos de nómina',
            'warning'
          )
        }
      }, 2000)
    },
    mostrarMensaje(mensaje) {
      setTimeout(() => {
        this.$notify({
          group: 'notificaciones',
          title: 'Notificación Importante',
          text: mensaje,
        })
      }, 800)
    },
    getToken(){
        const token = localStorage.getItem('token');
        return token;
    }
  },
}
</script>

<style scoped>
.subtitle {
  font-size: 1.2rem;
}
.edit {
  font-size: 1rem;
  color: #2a93d5;
  font-weight: bold;
}
.card-partial {
  background: #f6f6f6;
}
.empresa {
  color: #2a93d5;
  border-left: 1px solid darkgray;
  padding-left: 5px;
  padding-top: 0;
  padding-bottom: 0;
}
.item {
  font-family: 'Lato';
}
h2,
.config-option,
.edit {
  font-family: 'Montserrat';
}
.item {
  font-size: 0.88rem;
  font-weight: bold;
  color: rgba(75, 75, 75, 0.87);
}
.config-option {
  color: #2a93d5;
  font-size: 0.8rem;
  font-weight: bold;
}
</style>
