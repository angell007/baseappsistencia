<template>
  <div class="container" v-if="renderizarTablero">
    <div class="row">
      <div class="col-12">
        <h3>{{ Titulo }}</h3>
        <div class="separator mb-5"></div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-9">
        <div class="row icon-cards">
          <div class="col-12">
            <div class="row">
                <div class="col-md-3 col-xs-12 mb-2">
                    <div class="card">
                    <div class="card-body text-center">
                        <i class="iconsmind-Timer-2"></i>
                        <p class="card-text mb-0">LLegadas Tarde</p>
                        <p class="lead card-item-tablero text-center mb-0">{{Indicadores.Llegadas}}</p>
                    </div>
                    </div>
                </div>
                <div class="col-md-3 col-xs-12 mb-2">
                    <div class="card">
                    <div class="card-body text-center">
                        <i class="iconsmind-Bag-Coins"></i>
                        <p class="card-text mb-0">Novedades</p>
                        <p class="lead card-item-tablero text-center mb-0">{{Indicadores.Novedades}}</p>
                    </div>
                    </div>
                </div>
                <div class="col-md-3 col-xs-12 mb-2">
                    <div class="card">
                    <div class="card-body text-center">
                        <i class="iconsmind-Door"></i>
                        <p class="card-text mb-0">Renuncias</p>
                        <p class="lead card-item-tablero text-center mb-0">{{Indicadores.Renuncias}}</p>
                    </div>
                    </div>
                </div>
                <div class="col-md-3 col-xs-12 mb-2">
                    <div class="card">
                    <div class="card-body text-center">
                        <i class="iconsmind-Conference"></i>
                        <p class="card-text mb-0">Nuevo personal</p>
                        <p class="lead card-item-tablero text-center mb-0">{{Indicadores.Nuevos}}</p>
                    </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
        <div class="row mt-4">
          <div class="col-12">
            <div class="card">
              <div class="card-title pl-3 pt-3 mb-0">
                <h4 class>
                  Top 5 llegadas tarde en el mes
                  <!-- <img  src="img/cup-icon.svg" class="svg-icon"  alt="Top-imagen" /> -->
                </h4>
              </div>
              <div class="card-body d-flex justify-content-around align-items-center p-2">
                <template v-if="topFuncionariosByRetardos.length">
                  <div
                    class="text-center"
                    v-for="(funcionario,index) in topFuncionariosByRetardos"
                    :key="index"
                  >
                    <img v-if="funcionario.image!=null" class="img-funcionario" :src="`back/storage/app/public/${funcionario.image}`"  alt="" />
                    <img v-else :src="`/img/robot.jpg`" class="img-funcionario" alt="" >
                    <p class="mb-0">{{parsearNombreFuncionario(funcionario)}}</p>
                    <p>
                      <small>{{funcionario.llegadas}} Retraso<span v-if="funcionario.llegadas>1">s</span></small>
                    </p>
                  </div>
                </template>
                <p class v-else>
                  <img src="/img/llegadas.png" class="img-fluid" alt="sin llegadas tarde" >
                </p>
              </div>
            </div>
          </div>
        </div>
        <div class="mt-4">
          <grafica-retardos :datos="graficaRetardos">
            <h4 class>Llegadas tarde en este mes</h4>
          </grafica-retardos>
        </div>
        <!-- 
        <div class="mt-4">
          <grafica-costos>
            <h5 class>Costos nómina</h5>
          </grafica-costos>
        </div>  -->
      </div>

      <div class="col-md-3">
        <birthdays :funcionarios="birthdayFuncionarios"></birthdays>
        <contratos-por-vencer :funcionarios="contratosFuncionarios"></contratos-por-vencer>
      </div>
    </div>
  </div>
  <overlay v-else></overlay>
</template>

<script>
import GraficaRetardos from './GraficaRetardos'
import GraficaCostos from './GraficaCostos'
import Birthdays from './Birthdays'
import ContratosPorVencer from './ContratosPorVencer'
import Overlay from '../utiles/Overlay'
export default {
  components: {
    GraficaRetardos,
    GraficaCostos,
    Birthdays,
    ContratosPorVencer,
    Overlay,
  },
  data() {
    return {
      Titulo: '' ,
      renderizarTablero: false,
      topFuncionariosByRetardos: [],
      graficaRetardos: [],
      birthdayFuncionarios: [],
      contratosFuncionarios: [],
      Indicadores : {
          Llegadas : 0,
          Novedades : 0,
          Renuncias : 0,
          Nuevos : 0
      }
    }
  },
  created() {
    this.getTitulo()
    this.getAllDatos()
    //this.getEmpresaDatos()
  },
  methods: {
    getTitulo(){
      var usuario = JSON.parse(localStorage.getItem('usuario'));
      
      this.Titulo = "Bienvenido "+usuario["nombres"]+", ¡recuerda que hoy es un gran día para sonreir!"
    },
    getAllDatos() {
      axios
        .all([
          this.getTopFuncionariosByRetardos(),
          this.getDatosGraficaRetardos(),
          this.getBirthdaysFuncionarios(),
          this.getContratosPorVencer(),
          this.getIndicadores()
        ])
        .then(
          axios.spread(
            (
              retardosDatos,
              graficaRetardosDatos,
              birthdaysDatos,
              contratosDatos,
              indicadoresDatos
            ) => {
              this.topFuncionariosByRetardos = retardosDatos.data
              this.graficaRetardos = graficaRetardosDatos.data
              this.birthdayFuncionarios = birthdaysDatos.data
              this.contratosFuncionarios = contratosDatos.data
              this.renderizarTablero = true
              this.Indicadores = indicadoresDatos.data
            }
          )
        )
    },
    getTopFuncionariosByRetardos() {
      return axios.get(`/api/${localStorage.getItem('tenant')}/tablero/llegadas_tarde/top`)
    },
    getDatosGraficaRetardos() {
      return axios.get(`/api/${localStorage.getItem('tenant')}/tablero/llegadas_tarde`)
    },
    getBirthdaysFuncionarios() {
      return axios.get(`/api/${localStorage.getItem('tenant')}/tablero/funcionarios/birthday`)
    },
    getContratosPorVencer() {
      return axios.get(`/api/${localStorage.getItem('tenant')}/tablero/funcionarios/contratos`)
    },
    getIndicadores(){
      return axios.get(`/api/${localStorage.getItem('tenant')}/tablero/indicadores`)
    },
    parsearNombreFuncionario({ nombres, apellidos }) {
      return nombres.split(' ')[0] + ' ' + apellidos.split(' ')[0]
    },
    getErrorServidor(error) {
      if (error.response) {
        this.$swal.fire(
          'Error!',
          'Han ocurrido errores, por favor intentar más tarde',
          'error'
        )
      }
    },

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
    getToken(){
        const token = localStorage.getItem('token');
        return token;
    }


  },
}
</script>

<style scoped>
.icon-cards i {
  font-size: 46px;
  line-height: 66px;
  color: #4bb1f0;
}
.card-item-tablero {
  font-family: 'Montserrat', sans-serif;
  font-size: 1.3rem;
}
.img-funcionario {
  width: 42px;
  border-radius: 50%;
  border: 1px solid #ccc;
}
.svg-icon {
  width: 38px;
  display: inline-block;
  padding-bottom: 10px;
  padding-left: 4px;
}
</style>
