<template>
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <h1 class="font-weight-bold">Pago de Nómina</h1>
      </div>
      <div class="col-md-4 offset-4">
        <span class="font-weight-bold">Periodo de pago</span>:
        <i class="simple-icon-calendar"></i>
        <span class="font-weight-bold">{{inicioPeriodo}}</span> -
        <i class="simple-icon-calendar"></i>
        <span class="font-weight-bold">{{finPeriodo}}</span>
        <div class="rollback-payment text-right">
          <a class="btn btn-link btn-sm" href="#" @click.prevent>Pagar el periodo anterior</a>
        </div>
      </div>
    </div>

    <div class="alert alert-secondary" v-if="nomina.nomina_paga">
      <p
        class="font-weight-bold text-center"
      >Este periodo ya ha sido pagado, sin embargo, puede editar y volver a guardar dando click en la siguiente opción:</p>
      <a
        href="#"
        id="editPayroll"
        class="d-block text-center"
        @click.prevent="deletePagoNomina"
      >Volver a editar el pago</a>
    </div>

    <div class="row icon-cards">
      <div class="card-body">
        <div class="row">
          <card-concepto :concepto="nomina.salarios" icon="iconsmind-Money-2">Salarios (neto)</card-concepto>
          <card-concepto :concepto="nomina.provisiones" icon="iconsmind-Bag-Coins">Provisiones</card-concepto>
          <card-concepto :concepto="nomina.seguridad_social" icon="iconsmind-Ambulance">Seg. Social</card-concepto>
          <card-concepto :concepto="nomina.parafiscales" icon="iconsmind-Mens">Parafiscales</card-concepto>
          <card-concepto :concepto="nomina.extras" icon="iconsmind-Clock-Forward">Extras</card-concepto>
          <card-concepto :concepto="nomina.ingresos" icon="iconsmind-Coins-3">Ingresos</card-concepto>
        </div>
      </div>
    </div>

    <div class="row d-flex justify-content-center">
      <p>
        Costo total empresa:
        <span class="custom-label">{{nomina.costo_total_empresa | moneda}}</span>
      </p>
    </div>

    <div class="row d-flex justify-content-center" v-if="nomina.nomina_paga">
      <a href="#" class="text-center font-weight-bold nomina-descargables" @click.prevent>
        <i class="iconsmind-File-Excel" id="icono-descargables"></i>
        Resumen de Nómina
      </a>
    </div>

    <div class="row" v-if="renderizar">
      <modal id="extrasRecargos" ref="extrasRecargos" :esLg="false">
        <template slot="titulo">Horas extras/recargos</template>
        <template slot="contenido">
          <table class="table table-bordered table-sm">
            <thead>
              <tr>
                <th class="custom-label">Diurnas</th>
                <th class="custom-label">Nocturnas</th>
                <th class="custom-label">Diur. Dom</th>
                <th class="custom-label">Noct. Dom</th>
                <th class="custom-label">Rec. Noct</th>
                <th class="custom-label">Rec. Fest</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td
                  class="custom-label text-center"
                  v-for="(extra,index) in horasExtras"
                  :key="index"
                >{{extra}}</td>
              </tr>
            </tbody>
          </table>
        </template>
      </modal>

      <modal id="novedades" ref="novedades">
        <template slot="titulo">Novedades</template>
        <template slot="contenido">
          <table class="table table-bordered table-sm" v-if="novedades.length">
            <thead>
              <tr>
                <th class="custom-label">Concepto</th>
                <th class="custom-label text-center">Días</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(novedad,index) in novedades" :key="index">
                <td class="custom-label">{{novedad.concepto}}</td>
                <td class="custom-label text-center">{{novedad.dias}}</td>
              </tr>
            </tbody>
          </table>
          <p class="custom-label" v-else>El funcionario no presenta novedades en este periodo</p>
        </template>
      </modal>
      <div
        class="modal fade"
        tabindex="-1"
        role="dialog"
        style="display: none;"
        aria-hidden="true"
        >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Otros Ingresos</h5>
                <button
                type="button"
                class="close"
                data-dismiss="modal"
                aria-label="Close"
                >
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <ingreso-prestacional
                @cerrar="cerrarModalIngresosP(funcionario)"
                ></ingreso-prestacional>
            </div>
            </div>
        </div>
        </div>
        <!--Modal-->

      <div class="col-12">
        <h2 class="font-weight-bold">Lista de Funcionarios</h2>
        <!-- <div class="form-group row">
          <label
            for="centro_costos"
            class="custom-label col-form-label col-md-2 offset-3"
          >Filtro centro de costos</label>
          <select name="centro_costos" class="form-control custom-control col-md-4">
            <option value="seleccione">Seleccione</option>
          </select>
        </div> -->
        <div class="card">
          <div class="card-body">
            <table class="table table-striped tabla-funcionarios">
              <thead>
                <tr class="text-center">
                  <th>Funcionario</th>
                  <th>Ingresos Constitutivos de Salario</th>
                  <th>Ingresos No Constitutivos de Salario</th>
                  <th>Deducciones</th>
                  <th>Pago a Empleado</th>
                </tr>
              </thead>

              <tbody>
                <tr v-for="(funcionario,index) in funcionarios" :key="index" class="text-center">
                  <td>
                    <img
                      :src="`${funcionario.original.image}`"
                      class="img-funcionario"
                      alt="Imagen funcionario"
                    >
                    <p
                      class="item-nomina mb-2"
                    >{{funcionario.original.nombres}} {{funcionario.original.apellidos}}</p>
                  </td>
                  <td>
                    <a
                      href="#"
                      class="d-block item-nomina mb-2"
                      @click.prevent="mostrarExtrasRecargos(funcionario.original)"
                    >Extras y Recargos</a>
                    <div>
                      <a
                        href="#"
                        class="d-block item-nomina mb-2"
                        @click.prevent="mostrarNovedades(funcionario.original)"
                      >Vacac, Incap y Lic</a>
                      <a href="#" class="d-block item-nomina" @click.prevent="mostrarModalIngresosP(funcionario)">Otros ingresos</a>
                    </div>
                  </td>
                  <td>
                    <div>
                      <a href="#" class="d-block item-nomina" >Otros ingresos No Prestacionales</a>
                    </div>
                  </td>

                  <td>
                    <div>
                      <a href="#" class="d-block item-nomina" @click.prevent>Otras deducciones</a>
                    </div>
                  </td>
                  <td>
                    <p
                      class="custom-label"
                    >{{funcionario.original.salario_neto| moneda}} / {{nomina.frecuencia_pago}}</p>
                    <router-link
                      :to="{ path: '/nomina/pago/'+ funcionario.original.identidad, query: {
                          inicio: nomina.inicio_periodo, fin: nomina.fin_periodo}}"
                      class="d-block item-nomina"
                    >Ver cálculos</router-link>
                    <a
                      href="#"
                      class="item-nomina"
                      @click.prevent="getColilla(funcionario.original)"
                    >Colilla</a>
                  </td>
                </tr>
              </tbody>
            </table>
            <!-- Modal Extras y recargos-->
            <div class="text-right" v-if="!nomina.nomina_paga">
              <button
                type="button"
                class="btn btn-secondary raised text-right"
                @click="postPagoNomina"
              >Guardar y proceder</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <overlay v-else></overlay>
  </div>
</template>

<script>
import IngresoPrestacional from './formularios/IngresoPrestacional'
import IngresoNoPrestacional from './formularios/IngresoNoPrestacional'
import Deduccion from './formularios/Deduccion'
import Modal from './../../utiles/Modal'
import Overlay from '../../utiles/Overlay'
import CardConcepto from './reutilizables/CardConcepto'

export default {
  components: {
    IngresoPrestacional,
    IngresoNoPrestacional,
    Deduccion,
    Modal,
    Overlay,
    CardConcepto,
  },
  data() {
    return {
      id: '',
      nomina: '',
      funcionarios: [],
      horasExtras: '',
      novedades: [],
      pago: {},
      inicioParemeter: '',
      finParemeter: '',
      uriPagoNomina: '',
      uriPagoFuncionarios: '',
      renderizar: false,
      colillaUri: '',
    }
  },

  created() {
    //Si existen parametros en la ruta del componente al momento de crearlo significa que viene de hisorial de pagos por lo tanto se requiere ver un pago antiguo,
    if (Object.keys(this.$route.params).length) {
      this.inicioParemeter = this.$route.params.inicio
      this.finParemeter = this.$route.params.fin
    }

    this.setUris()
    this.getPagoNomina()
  },
  methods: {
    //Se settean las uris para que tome esos parámetros y cargue la nómina de esa fecha. Si no existen carga la nómina actual
    setUris() {
      this.uriPagoNomina =
        this.inicioParemeter && this.finParemeter
          ? `/api/${localStorage.getItem('tenant')}/nomina/pago/${this.inicioParemeter}/${this.finParemeter}`
          : `/api/${localStorage.getItem('tenant')}/nomina/pago`

      this.uriPagoFuncionarios =
        this.inicioParemeter && this.finParemeter
          ? `/api/${localStorage.getItem('tenant')}/nomina/pago/funcionarios/${this.inicioParemeter}/${
              this.finParemeter
            }`
          : `/api/${localStorage.getItem('tenant')}/nomina/pago/funcionarios`
    },

    getPagoNomina() {
      axios.get(this.uriPagoNomina).then(datos => {
        this.nomina = datos.data
        this.pago.id = this.nomina.nomina_paga_id
          ? this.nomina.nomina_paga_id
          : ''
        this.getFuncionarios()
        this.getUsuario()
      })
    },

    getFuncionarios() {
      axios.get(this.uriPagoFuncionarios).then(datos => {
        this.funcionarios = datos.data
        this.renderizar = true
      })
    },

    getUsuario() {
      const token = 'Bearer '.concat(localStorage.getItem('token'))
      axios
        .get(`/api/auth/user`, {
          headers: { Authorization: token },
        })
        .then(datos => {
          this.pago.admin_id = datos.data.user.id
        })
        .catch(error => {
          if (error.response.status === 400) {
            localStorage.removeItem('token')
            localStorage.removeItem('tenant')
          }
        })
    },

    mostrarExtrasRecargos(funcionario) {
      this.horasExtras = Object.values(funcionario.horas_extras)
      this.$refs.extrasRecargos.mostrarModal()
    },

    mostrarNovedades(funcionario) {
      this.novedades = []
      if (funcionario.novedades) {
        for (let novedad in funcionario.novedades) {
          this.novedades.push({
            concepto: novedad,
            dias: funcionario.novedades[novedad],
          })
        }
      }
      this.$refs.novedades.mostrarModal()
    },
    mostrarModalIngresosP(funcionario) {
      let elemento = `#modalIngresosP${funcionario.original.id}`
      let elementoRef = `ingresoP${funcionario.original.id}`
      //Llamar método de la referencia hija ingreso-prestacional
      //this.$refs[elementoRef][0].borrarDatos()
      //this.$refs[elementoRef][0].getIngresosPrestacionales()
      $(elemento).modal({
        backdrop: 'static',
        keyboard: false,
      })
    },
    mostrarModalIngresosNP(funcionario) {
      let elemento = `#modalIngresosNP${funcionario.original.id}`
      let elementoRef = `ingresoNP${funcionario.original.id}`
      //Llamar método de la referencia hija ingreso-no-prestacional
      this.$refs[elementoRef][0].borrarDatos()
      this.$refs[elementoRef][0].getIngresosNPrestacionales()
      $(elemento).modal({
        backdrop: 'static',
        keyboard: false,
      })
    },

    mostrarModalDeducciones(funcionario) {
      let elemento = `#modalDeducciones${funcionario.original.id}`
      let elementoRef = `deduccion${funcionario.original.id}`
      //Llamar método de la referencia hija ingreso-no-prestacional
      this.$refs[elementoRef][0].borrarDatos()
      this.$refs[elementoRef][0].getDeducciones()
      $(elemento).modal({
        backdrop: 'static',
        keyboard: false,
      })
    },

    cerrarModalIngresosP(funcionario) {
      let elemento = `#modalIngresosP${funcionario.original.id}`
      $(elemento).modal('hide')
    },
    cerrarModalIngresosNP(funcionario) {
      let elemento = `#modalIngresosNP${funcionario.original.id}`
      $(elemento).modal('hide')
    },

    cerrarModalDeducciones(funcionario) {
      let elemento = `#modalDeducciones${funcionario.original.id}`
      $(elemento).modal('hide')
    },

    postPagoNomina() {
      this.pago.inicio_periodo = this.nomina.inicio_periodo
      this.pago.fin_periodo = this.nomina.fin_periodo
      this.pago.total_salarios = this.nomina.salarios
      this.pago.total_retenciones = this.nomina.retenciones
      this.pago.total_provisiones = this.nomina.provisiones
      this.pago.total_seguridad_social = this.nomina.seguridad_social
      this.pago.total_parafiscales = this.nomina.parafiscales
      this.pago.total_extras_recargos = this.nomina.extras
      this.pago.total_ingresos = this.nomina.ingresos
      this.pago.costo_total = this.nomina.costo_total_empresa

      this.$swal
        .fire({
          title: '¿Está seguro?',
          text: 'Revise que todo coincida antes de continuar',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, continuar!',
        })
        .then(result => {
          if (result.value) {
            this.renderizar = false
            axios.post(`/api/${localStorage.getItem('tenant')}/nomina/pago/nomina`, this.pago).then(respuesta => {
              this.$swal.fire('Correcto!', respuesta.data.message, 'success')
              this.getPagoNomina()
            })
          }
        })
    },

    deletePagoNomina() {
      axios
        .delete(`/api/${localStorage.getItem('tenant')}/nomina/pago/${this.pago.id}/eliminar`)
        .then(respuesta => {
          this.renderizar = false
          this.getPagoNomina()
        })
        .catch(error => {
          if (error.response.status === 400) {
            localStorage.removeItem('token')
            localStorage.removeItem('tenant')
          } else {
            this.$swal.fire(
              'Error',
              'Han ocurrido errores, por favor intente más tarde',
              'error'
            )
          }
        })
    },

    getColilla(funcionario) {
      axios({
        method: 'get',
        responseType: 'arraybuffer',
        url: `/api/${localStorage.getItem('tenant')}/nomina/colilla/funcionarios/${funcionario.id}/${
          this.nomina.inicio_periodo
        }/${this.nomina.fin_periodo}`,
      }).then(respuesta => {
        //Se realiza de esta manera para no exponer información en el link
        let blob = new Blob([respuesta.data], { type: 'application/pdf' })
        let link = document.createElement('a')
        link.href = window.URL.createObjectURL(blob)
        link.download = `${funcionario.nombres}_${funcionario.apellidos}.pdf`
        link.click()
      })
    },
  },
  computed: {
    inicioPeriodo() {
      return moment(this.nomina.inicio_periodo).format('DD/MM/YYYY')
    },
    finPeriodo() {
      return moment(this.nomina.fin_periodo).format('DD/MM/YYYY')
    },
  },
}
</script>

<style scoped>
.nomina-descargables,
.item-nomina {
  color: #4bb1f0;
}
.item-nomina {
  font-weight: bold;
}
.item-nomina:hover {
  text-decoration: underline;
}

.tabla-funcionarios {
  border-left: 2px solid #eee;
  border-right: 2px solid #eee;
}

.img-funcionario {
  width: 38px;
  border-radius: 50%;
}
#icono-descargables {
  color: #4bb1f0;
  font-size: 26px;
}
#editPayroll {
  color: #9370db;
  font-size: 14px;
  font-weight: bold;
  text-decoration: underline;
}
</style>
