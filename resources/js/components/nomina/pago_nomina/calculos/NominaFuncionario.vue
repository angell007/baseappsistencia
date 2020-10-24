<template>
  <div class="container" v-if="mostrarCalculos">
    <div class="card mb-3">
      <div class="card-body">
        <div class="row">
          <div class="col-md-2">
            <img :src="rutaImagen" alt="imagen_funcionario" id="img-funcionario">
          </div>
          <div class="col-md-4">
            <div>
              <h3>{{funcionario.nombres}} {{funcionario.apellidos}}</h3>
              <p class="cargo-funcionario font-weight-bold">{{funcionario.cargo.nombre}}</p>
              <p>
                <strong>C.C</strong>
                {{funcionario.identidad}}
              </p>
            </div>
          </div>
          <div class="col-md-3">
            <h4>
              Periodo de Pago
              <i class="simple-icon-calendar cargo-funcionario"></i>
            </h4>
            <p>{{inicioFormato}} - {{finFormato}}</p>
            <p>
              Frecuencia de pago:
              <span class="custom-label">{{datosEmpresa.frecuencia_pago}}</span>
            </p>
          </div>
          <div class="col-md-3">
            <h4>
              Compañia
              <i class="simple-icon-home cargo-funcionario"></i>
            </h4>
            <p>{{datosEmpresa.razon_social}}</p>
            <p>
              <strong>NIT</strong>
              : {{datosEmpresa.numero_documento}}
            </p>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="row mt-4 mb-2">
              <div class="col-md-8 offset-4">
                <div class="pl-3">
                  <button
                    v-for="(tab,indexTab) in tabs"
                    :key="indexTab"
                    :class="['tab-button', { active: tabActual === tab }]"
                    @click="tabActual=tab"
                  >{{tab}}</button>
                </div>
              </div>
            </div>
            <div class="row mt-4">
              <div class="col-md-12">
                <div class="col-md-12">
                  <colilla-pago
                    :funcionarioProp="funcionario"
                    :datosEmpresaProp="datosEmpresa"
                    :fechaInicio="inicio"
                    :fechaFin="fin"
                    v-if="tabActual === 'Colilla Pago'"
                  ></colilla-pago>

                  <seguridad-parafiscales
                    :funcionarioProp="funcionario"
                    :datosEmpresaProp="datosEmpresa"
                    :fechaInicio="inicio"
                    :fechaFin="fin"
                    v-if="tabActual === 'Seguridad y Parafiscales'"
                  ></seguridad-parafiscales>

                  <provisiones
                    :funcionarioProp="funcionario"
                    :datosEmpresaProp="datosEmpresa"
                    :fechaInicio="inicio"
                    :fechaFin="fin"
                    v-if="tabActual === 'Provisiones'"
                  ></provisiones>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ColillaPago from './colilla_pago/ColillaPago'
import SeguridadParafiscales from './seguridad_parafiscales/SeguridadParafiscales'
import Provisiones from './provisiones/Provisiones'

export default {
  components: { ColillaPago, SeguridadParafiscales, Provisiones },
  data() {
    return {
      funcionarioIdentidad: '',
      inicio: '',
      fin: '',
      funcionario: '',
      datosEmpresa: '',
      diasTrabajados: '',
      mostrarCalculos: false,
      tabs: ['Colilla Pago', 'Seguridad y Parafiscales', 'Provisiones'],
      tabActual: 'Colilla Pago',
      rutaImagen: '',
    }
  },
  created() {
    this.funcionarioIdentidad = this.$route.params.identidad
    this.inicio = this.$route.query.inicio
    this.fin = this.$route.query.fin
    this.getDatos()
  },
  methods: {
    getDatos() {
      axios
        .all([
          this.getUsuario(this.$route.params.identidad),
          this.cargarDatosEmpresa(),
        ])
        .then(
          axios.spread((funcionario, datosEmpresa) => {
            this.funcionario = funcionario.data
            this.rutaImagen = `/back/storage/app/public/${this.funcionario.image}`
            this.datosEmpresa = datosEmpresa.data
            this.mostrarCalculos = true
          })
        )
    },
    getUsuario(funcionarioIdentidad) {
      return axios.get(`/api/nomina/pago/funcionarios/${funcionarioIdentidad}`)
    },
    cargarDatosEmpresa() {
      return axios.get('/api/general/empresa/global')
    },
  },
  computed: {
    inicioFormato() {
      return moment(this.inicio).format('DD/MM/YYYY')
    },
    finFormato() {
      return moment(this.fin).format('DD/MM/YYYY')
    },
  },
}
</script>

<style scoped>
.info-calculo-general {
  border: 1px solid #b9b3b3;
}
table {
  border: 1px solid #b9b3b3;
}
.tab-button {
  padding: 6px 10px;
  border-top-left-radius: 3px;
  border-top-right-radius: 3px;
  border: 1px solid #ccc;
  cursor: pointer;
  background: #fff;
  margin-bottom: -1px;
  margin-right: -1px;
  font-weight: 600;
  color: #09151ddf;
}
.tab-button:hover {
  background: #e0e0e0;
}
.tab-button.active {
  background: #2a93d5;
  color: #f0f0f0;
  font-weight: bold;
}
.tab {
  border: 1px solid #ccc;
  padding: 10px;
}
#img-funcionario {
  width: 120px;
  height: 120px;
  border-radius: 50%;
  border: 1px solid #f5f4f4;
}
.cargo-funcionario {
  color: #2a93d5;
}
</style>
