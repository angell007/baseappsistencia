<template>
  <div class="container">
    <div v-if="mostrarInfo">
      <div class="row">
        <div class="col-12 mb-5">
          <header class="card">
            <div class="card-body">
              <div class="row pt-4">
                <div class="col-md-4">
                  <div class="row">
                    <div class="col-md-4 col-xs-12 text-center">
                      <img :src="rutaImagen" class="img-responsive" id="img-funcionario">
                    </div>
                    <div class="col-md-8 col-xs-12 text-xs-center">
                      <h4 class="font-weight-bold">{{funcionario.nombres}} {{funcionario.apellidos}}</h4>
                      <p>
                        <span id="employee-position">{{ funcionario.cargo.nombre}}</span>
                      </p>
                      <p class="font-weight-bold">{{ funcionario.dependencia.nombre}}</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-2 text-center">
                  <p class="pb-0 mb-0 font-weight-bold text-mute">Salario base</p>
                  <img src="/img/coin-icon.svg" alt="coin" class="svg-icon mx-auto">
                  <span class="salary-vacations-item">{{ funcionario.salario | moneda}}</span>
                </div>
                <div class="col-md-2 text-center">
                  <p class="pb-0 mb-0 font-weight-bold text-mute">Vacaciones acumuladas</p>
                  <img src="/img/vacations-icon.svg" alt="vacations" class="svg-icon mx-auto">
                  <span class="salary-vacations-item">0</span>
                </div>
                <!--<div class="col-md-2 text-center">
                  <p class="pb-0 mb-0 text-mute font-weight-bold">Colilla de pago</p>
                  <button class="btn btn-link default link-item">
                    <i class="iconsmind-File-Download d-block data-icon"></i>Descargar
                  </button>
                </div> -->
                <div class="col-md-2 text-center">
                  <p class="pb-0 mb-0 text-mute font-weight-bold">Certificado laboral</p>
                  <button class="btn btn-link default link-item">
                    <i class="iconsmind-File-HorizontalText d-block data-icon"></i>Descargar
                  </button>
                </div>
              </div>
              <div class="row mt-2">
                <div class="col-md-12 text-right">
                  <button
                    class="btn btn-secondary default btn-xs dropdown-toggle"
                    type="button"
                    data-toggle="dropdown"
                    aria-expanded="false"
                  >Más opciones</button>
                  <div
                    class="dropdown-menu"
                    x-placement="bottom-start"
                    style="position: absolute; transform: translate3d(0px, 25px, 0px); top: 0px; left: 0px; will-change: transform;"
                  >
                    <a class="dropdown-item extra-option" href="#">Contacto de emergencia</a>
                    <a class="dropdown-item extra-option" href="#">Experiencia laboral</a>
                    <a class="dropdown-item extra-option" href="#">Referencia personal</a>
                    <a class="dropdown-item extra-option" href="#">Documentos</a>
                  </div>
                  <a
                    href="#"
                    class="link-liq ml-5 mr-3"
                    @click.prevent="redirectToLiquidar"
                  >Liquidar empleado</a>
                </div>
              </div>
            </div>
          </header>
        </div>
      </div>
      <div class="row">
        <div class="col-md-8">
          <div class="row mt-4">
            <div class="col-md-12">
              <div class="card">
                <div class="card-title pl-4 pt-4 row">
                  <h1 class="titulo col-md-6">Datos Básicos</h1>
                  <div class="col-md-6 text-right">
                    <button class="btn btn-link pt-0 edit" @click="mostarModal('datosBasicos')">
                      <i class="simple-icon-pencil"></i> Editar
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-4">
                      <p class="font-weight-bold text-mute item-subtitle">Nombre completo</p>
                      <p class="font-weight-bold text-mute item-subtitle">Documento de identidad</p>
                      <p class="font-weight-bold text-mute item-subtitle">Correo electrónico</p>
                      <p class="font-weight-bold text-mute item-subtitle">Tipo de Contrato</p>
                      <p class="font-weight-bold text-mute item-subtitle">Fecha de ingreso</p>
                      <p
                        class="font-weight-bold text-mute item-subtitle"
                        v-if="funcionario.fecha_retiro"
                      >Fecha de retiro</p>
                      <p class="font-weight-bold text-mute item-subtitle">Título de estudio</p>
                    </div>
                    <div class="col-md-7 offset-1 item-data">
                      <p class="font-weight-bold">{{funcionario.nombres}} {{funcionario.apellidos}}</p>
                      <p class="font-weight-bold">{{funcionario.identidad}}</p>
                      <p class="font-weight-bold">{{funcionario.email || 'No registrado'}}</p>
                      <p class="font-weight-bold">{{funcionario.contrato.nombre || 'No registrado'}}</p>
                      <p class="font-weight-bold">{{fechaIngreso}}</p>
                      <p class="font-weight-bold" v-if="funcionario.fecha_retiro">{{fechaRetiro}}</p>
                      <p class="font-weight-bold">{{funcionario.titulo_estudio || 'No registrado'}}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <modal id="datosBasicos" ref="datosBasicos" :esLg="true">
              <template slot="titulo">Edición de datos básicos</template>
              <template slot="contenido">
                <datos-basicos :funcionarioEditar="funcionario" @mensaje="mostrarMensaje" @cambiarRuta="CambiaRutaImagen" ></datos-basicos>
              </template>
            </modal>
          </div>

          <div class="row mt-3">
            <div class="col-md-12">
              <div class="card">
                <div class="card-title pl-4 pt-4 row">
                  <h2 class="titulo col-md-6">Datos de empresa</h2>
                  <div class="col-md-6 text-right">
                    <button class="btn btn-link pt-0 edit" @click="mostarModal('datosEmpresa')">
                      <i class="simple-icon-pencil"></i> Editar
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-4">
                      <p class="font-weight-bold text-mute item-subtitle">Centro de costos</p>
                      <p class="font-weight-bold text-mute item-subtitle">Dependencia</p>
                      <p class="font-weight-bold text-mute item-subtitle">Cargo</p>
                      <p class="font-weight-bold text-mute item-subtitle">Tipo de turno</p>
                    </div>
                    <div class="col-md-7 offset-1 item-data">
                      <p class="font-weight-bold">{{funcionario.dependencia.centro_costo.nombre}}</p>
                      <p class="font-weight-bold">{{funcionario.dependencia.nombre}}</p>
                      <p class="font-weight-bold">{{funcionario.cargo.nombre}}</p>
                      <p class="font-weight-bold">{{funcionario.tipo_turno}}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <modal id="datosEmpresa" ref="datosEmpresa" :esLg="true">
              <template slot="titulo">Edición Datos de Empresa</template>
              <template slot="contenido">
                <datos-empresa :funcionarioEditar="funcionario" @notificar="mostrarMensaje"></datos-empresa>
              </template>
            </modal>
          </div>

          <div class="row mt-3">
            <div class="col-md-12">
              <div class="card">
                <div class="card-title pl-4 pt-4 row">
                  <h3 class="titulo col-md-6">Datos personales</h3>
                  <div class="col-md-6 text-right">
                    <button class="btn btn-link pt-0 edit" @click="mostarModal('datosPersonales')">
                      <i class="simple-icon-pencil"></i> Editar
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-4">
                      <p class="font-weight-bold text-mute item-subtitle">Fecha de nacimiento</p>
                      <p class="font-weight-bold text-mute item-subtitle">Género</p>
                      <p class="font-weight-bold text-mute item-subtitle">Estado civil</p>
                      <p class="font-weight-bold text-mute item-subtitle">Dirección de residencia</p>
                      <p class="font-weight-bold text-mute item-subtitle">Celular</p>
                    </div>
                    <div class="col-md-7 offset-1 item-data">
                      <p class="font-weight-bold">{{fechaNacimiento}}</p>
                      <p class="font-weight-bold">{{funcionario.sexo}}</p>
                      <p class="font-weight-bold">{{funcionario.estado_civil || 'No registrado'}}</p>
                      <p
                        class="font-weight-bold"
                      >{{funcionario.direccion_residencia || 'No registrado'}}</p>
                      <p class="font-weight-bold">{{funcionario.celular || 'No registrado'}}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <modal id="datosPersonales" ref="datosPersonales">
              <template slot="titulo">Édición datos complementarios</template>
              <template slot="contenido">
                <datos-personales :funcionarioEditar="funcionario" @notificar="mostrarMensaje"></datos-personales>
              </template>
            </modal>
          </div>

          <div class="row mt-3" v-if="funcionario.contactos_emergencia">
            <div class="col-md-12">
              <div class="row"></div>
              <div class="card">
                <div class="card-title pl-4 pt-4 row">
                  <h5 class="titulo col-md-6">Contacto de Emergencia</h5>
                  <div class="col-md-6 text-right">
                    <button class="btn btn-link pt-0 edit" @click="mostarModal('datosContacto')">
                      <i class="simple-icon-pencil"></i> Editar
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-4">
                      <p class="font-weight-bold text-right text-mute">Nombre Completo</p>
                      <p class="font-weight-bold text-right text-mute">Parentesco</p>
                      <p class="font-weight-bold text-right text-mute">Teléfono</p>
                      <p class="font-weight-bold text-right text-mute">Celular</p>
                      <p class="font-weight-bold text-right text-mute">Direccion de residencia</p>
                    </div>
                    <div class="col-md-7 offset-1 item-data">
                      <p
                        class="font-weight-bold"
                      >{{funcionario.contactos_emergencia.nombre_completo || 'No registrado'}}</p>
                      <p
                        class="font-weight-bold"
                      >{{funcionario.contactos_emergencia.parentesco || 'No registrado'}}</p>
                      <p
                        class="font-weight-bold"
                      >{{funcionario.contactos_emergencia.telefono || 'No registrado'}}</p>
                      <p
                        class="font-weight-bold"
                      >{{funcionario.contactos_emergencia.celular || 'No registrado'}}</p>
                      <p
                        class="font-weight-bold"
                      >{{funcionario.contactos_emergencia.direccion || 'No registrado'}}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <datos-contacto
              ref="datosContacto"
              :funcionarioEditar="funcionario"
              @mensaje="mostrarMensaje"
            ></datos-contacto>
          </div>

          <div class="row mt-4" v-if="funcionario.experiencias_laborales.length">
            <div class="col-md-12">
              <div class="card">
                <div class="card-title pl-4 pt-4">
                  <h6 class="titulo">Experiencia Laboral</h6>
                </div>
                <div class="card-body">
                  <div
                    class="row"
                    v-for="experiencia in funcionario.experiencias_laborales"
                    :key="experiencia.id"
                  >
                    <div class="col-md-4">
                      <p class="font-weight-bold text-right text-mute">Nombre de la empresa</p>
                      <p class="font-weight-bold text-right text-mute">Cargo</p>
                      <p class="font-weight-bold text-right text-mute">Labores realizadas</p>
                      <p class="font-weight-bold text-right text-mute">Teléfono de la empresa</p>
                    </div>
                    <div class="col-md-7 offset-1 item-data">
                      <p class="font-weight-bold">{{experiencia.nombre_empresa}}</p>
                      <p class="font-weight-bold">{{experiencia.cargo}}</p>
                      <p class="font-weight-bold">{{experiencia.labores}}</p>
                      <p class="font-weight-bold">{{experiencia.telefono_empresa}}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4 mt-4">
          <div class="row mb-5">
            <div class="col-md-12">
              <div class="card">
                <div class="card-title ml-2 pt-4 row">
                  <h4 class="titulo col-md-6">Salario</h4>
                  <div class="col-md-6 text-right">
                    <button class="btn btn-link pt-0 edit" @click="mostarModal('datosSalario')">
                      <i class="simple-icon-pencil"></i> Editar
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <p id="employee-salary">{{ funcionario.salario | moneda}}</p>
                  <p class="ml-1 text-mute font-weight-bold">Periodo de pago</p>
                  <p class="ml-1 font-weight-bold titulo" v-if="frecuencia_pago">{{frecuencia_pago}}</p>
                </div>
              </div>
            </div>
            <modal id="datosSalario" ref="datosSalario" :esLg="false">
              <template slot="titulo">Edición Salario</template>
              <template slot="contenido">
                <datos-salario
                  ref="datosSalario"
                  :funcionarioEditar="funcionario"
                  :salarioBase="salarioBase"
                  @mensaje="mostrarMensaje"
                ></datos-salario>
              </template>
            </modal>
          </div>

          <div class="row mt-5">
            <div class="col-md-12">
              <div class="card">
                <div class="card-title pl-4 pt-4 row">
                  <p class="titulo col-md-6">Afiliaciones</p>
                  <div class="col-md-6 text-right">
                    <button
                      class="btn btn-link pt-0 edit"
                      @click="mostarModal('datosAfiliaciones')"
                    >
                      <i class="simple-icon-pencil"></i> Editar
                    </button>
                  </div>
                </div>

                <div class="card-body">
                  <p class="font-weight-bold text-mute">EPS</p>
                  <p class="font-weight-bold">{{funcionario.eps.nombre}}</p>

                  <p class="font-weight-bold text-mute">Fondo de pensiones</p>
                  <p class="font-weight-bold">{{funcionario.pensiones.nombre}}</p>

                  <p class="font-weight-bold text-mute">Fondo de cesantías</p>
                  <p class="font-weight-bold">{{funcionario.cesantias.nombre}}</p>

                  <p class="font-weight-bold text-mute">Caja de Compensación</p>
                  <p class="font-weight-bold">{{ funcionario.caja_compensacion.nombre}}</p>

                  <p class="font-weight-bold text-mute">Entidad ARL</p>
                  <p class="font-weight-bold" v-if="arl">{{ arl}}</p>
                </div>
              </div>
            </div>
            <modal id="datosAfiliaciones" ref="datosAfiliaciones">
              <template slot="titulo">Edición datos Afiliaciones</template>
              <template slot="contenido">
                <datos-afiliaciones :funcionarioEditar="funcionario" @notificar="mostrarMensaje"></datos-afiliaciones>
              </template>
            </modal>
          </div>
        </div>

        <notifications group="notificaciones" position="bottom right"/>
      </div>
    </div>
    <div class="overlay" v-else>
      <div class="container-spinner">
        <atom-spinner :animation-duration="500" :size="70" color="#fff"/>
        <p class="text-center font-weight-bold text-spinner">Cargando módulo...</p>
      </div>
    </div>
  </div>
</template>

<script>
import { AtomSpinner } from 'epic-spinners'
import DatosBasicos from './formularios/DatosBasicos'
import DatosEmpresa from './formularios/DatosEmpresa'
import DatosPersonales from './formularios/DatosPersonales'
import DatosContacto from './formularios/DatosContacto'
import DatosSalario from './formularios/DatosSalario'
import DatosAfiliaciones from './formularios/DatosAfiliaciones'
import Modal from '../../utiles/Modal'

export default {
  components: {
    AtomSpinner,
    DatosBasicos,
    DatosEmpresa,
    DatosPersonales,
    DatosContacto,
    DatosSalario,
    DatosAfiliaciones,
    Modal,
  },
  data() {
    return {
      funcionario: '',
      arl: '',
      frecuencia_pago: '',
      mostrarInfo: false,
      mostrarModalExperiencia: false,
      rutaImagen: '',
      salarioBase: '',
    }
  },
  created() {
    this.obtenerDatosEmpresa()
    this.obtenerFuncionario(this.$route.params.id)
  },

  methods: {
    obtenerFuncionario(identidad) {
      axios.get(`/api/${localStorage.getItem('tenant')}/funcionarios/${identidad}/mostrar`).then(datos => {
        this.funcionario = datos.data

        if(this.funcionario.image){
          this.rutaImagen = `back/storage/app/public/${this.funcionario.image}`
        }else{
          this.rutaImagen = `/img/robot.jpg`
        }
        this.mostrarInfo = true
      })
    },

    obtenerDatosEmpresa() {
      axios.get(`/api/${localStorage.getItem('tenant')}/general/empresa/global`).then(datos => {
        this.arl = datos.data.arl.nombre
        this.salarioBase = datos.data.salario_base
        this.frecuencia_pago = datos.data.frecuencia_pago
      })
    },
    mostarModal(referencia) {
      setTimeout(() => {
        this.$refs[referencia].mostrarModal()
      }, 500)
    },

    refrescarFuncionario(identidad) {
      this.obtenerFuncionario(identidad)
    },

    redirectToLiquidar() {
      this.$router.push({
        name: 'LiquidacionPrincipal',
        params: { id: this.funcionario.id },
      })
    },

    mostrarMensaje(mensaje) {
      setTimeout(() => {
        this.$notify({
          group: 'notificaciones',
          title: 'Notificación:',
          text: mensaje,
        })
      }, 800)
    },

    CambiaRutaImagen(ruta){
        this.rutaImagen = `/back/storage/app/public/${ruta}`;
    }
  },
  computed: {
    fechaNacimiento() {
      return moment(this.funcionario.fecha_nacimiento).format('DD-MM-YYYY')
    },
    fechaIngreso() {
      return moment(this.funcionario.fecha_ingreso).format('DD-MM-YYYY')
    },
    fechaRetiro() {
      return moment(this.funcionario.fecha_retiro).format('DD-MM-YYYY')
    },
  },
}
</script>

<style scoped>
#img-funcionario {
  width: 96px;
  height: 96px;
  border-radius: 50%;
}
.salary-vacations-item,
#employee-salary {
  font-size: 1.28rem;
  font-weight: 700;
}
#employee-position {
  padding: 4px;
  color: #fff;
  border: 1px solid #4c78ad;
  background: #2a93d5;
  font-size: 0.75rem;
  font-weight: 600;
}
.titulo {
  font-size: 1.25rem;
  font-family: 'Montserrat';
  font-weight: 700;
}
.card-title {
  margin-bottom: 0;
}
.card .card-body {
  padding-top: 0.5rem;
}
.text-mute {
  color: dimgray;
}
.item-subtitle {
  text-align: right;
  font-family: 'Lato';
}
.edit {
  font-size: 1.1rem;
  color: #2a93d5;
  font-weight: bold;
}
.data-icon {
  padding-top: 10px;
  font-size: 2rem;
}
.svg-icon {
  width: 60px;
  display: block;
  text-align: center;
}
.link-item {
  padding: 5px;
  font-weight: 700;
  color: #000;
}
.link-liq {
  color: rgb(177, 15, 15);
  font-weight: bold;
  text-decoration: underline;
}
.extra-option {
  padding: 6px;
  color: #000;
  font-weight: 700;
}
.item-data p {
  font-family: 'Montserrat';
  font-size: 0.8rem;
}
@media (max-width: 767px) {
  .text-xs-center {
    text-align: center;
  }
}
</style>
