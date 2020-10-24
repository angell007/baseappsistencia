<template>
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <h1 class="font-weight-bold">Pago de Nómina</h1>
      </div>
      <div class="col-md-4 offset-4">
        <span class="font-weight-bold">Periodo de pago</span>:
        <i class="simple-icon-calendar"></i>
        <span class="font-weight-bold">{{inicioPeriodoPagoFormato}}</span> -
        <i class="simple-icon-calendar"></i>
        <span class="font-weight-bold">{{finPeriodoPagoFormato}}</span>
      </div>
    </div>

    <div class="row icon-cards">
      <div class="col-12">
        <div class="card-body">
          <div class="row">
            <card-concepto :concepto="nomina.salarios" icon="iconsmind-Money-2">Salarios (neto)</card-concepto>
            <card-concepto :concepto="nomina.provisiones" icon="iconsmind-Bag-Coins">Provisiones</card-concepto>
            <card-concepto
              :concepto="nomina.seguridad_social"
              icon="iconsmind-Ambulance"
            >Seg. Social</card-concepto>
            <card-concepto :concepto="nomina.parafiscales" icon="iconsmind-Mens">Parafiscales</card-concepto>
            <card-concepto :concepto="nomina.extras" icon="iconsmind-Clock-Forward">Extras</card-concepto>
            <card-concepto :concepto="nomina.ingresos" icon="iconsmind-Coins-3">Ingresos</card-concepto>
          </div>
        </div>
      </div>
    </div>

    <div class="row icon-cards">
      <div class="col-12">
        <div class="card-body">
          <div class="row d-flex justify-content-center"></div>
          <div class="row mt-1">
            <div class="col-md-8 offset-2">
              <p class="text-center font-weight-bold nomina-descargables">
                <i class="iconsmind-File-Excel" id="icono-descargables"></i>
                Resumen de Nómina
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row" v-if="renderizar">
      <div class="col-12">
        <h2 class="font-weight-bold">Lista de Funcionarios</h2>
        <div class="form-group row">
          <label
            for="centro_costos"
            class="custom-label col-form-label col-md-2 offset-3"
          >Filtro centro de costos</label>
          <select name="centro_costos" class="form-control custom-control col-md-4">
            <option value="seleccione">Seleccione</option>
          </select>
        </div>
        <div class="card">
          <div class="card-body">
            <table class="table table-striped tabla-funcionarios table-responsive">
              <thead>
                <tr class="text-center">
                  <th>Salario Base</th>
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
                      :src="`/storage/${funcionario.original.image}`"
                      class="img-funcionario"
                      alt="Imagen funcionario"
                    >
                    <p
                      class="item-nomina mb-2"
                    >{{funcionario.original.nombres}} {{funcionario.original.apellidos}}</p>
                  </td>
                  <td>
                    <div>
                      <a
                        href="#"
                        class="d-block item-nomina mb-2"
                        @click.prevent="mostrarModalExtrasRecargos(funcionario)"
                      >Extras y Recargos</a>

                      <!-- Modal-->
                      <div
                        class="modal fade"
                        :id="'modalExtrasRecargos' + funcionario.original.id"
                        tabindex="-1"
                        role="dialog"
                        style="display: none;"
                        aria-hidden="true"
                      >
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Extras y Recargos</h5>
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
                              <table
                                class="table table-sm table-bordered"
                                v-if="funcionario.original.horas_extras.length > 0"
                              >
                                <thead>
                                  <tr>
                                    <th>Horas Extras</th>
                                    <th>Valor sobre hora ordinaria</th>
                                    <th>Cantidad</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td>Diurna</td>
                                    <td>1,25</td>
                                    <td>
                                      <p>{{calcularTotalExtrasRecargos(funcionario).totalHed}}</p>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>Nocturna</td>
                                    <td>1,75</td>
                                    <td>
                                      <p>{{calcularTotalExtrasRecargos(funcionario).totalHen}}</p>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>Diurna Dominical</td>
                                    <td>2,0</td>
                                    <td>
                                      <p>{{calcularTotalExtrasRecargos(funcionario).totalHedfd}}</p>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>Noctr Dominical</td>
                                    <td>2,5</td>
                                    <td>
                                      <p>{{calcularTotalExtrasRecargos(funcionario).totalHedfn}}</p>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                              <p v-else>El funcionario no presenta horas extras</p>
                              <table
                                class="table table-sm table-bordered"
                                v-if="funcionario.original.horas_extras.length > 0"
                              >
                                <thead>
                                  <tr>
                                    <th style="width:32%">Recargos</th>
                                    <th>Valor sobre hora ordinaria</th>
                                    <th>Cantidad</th>
                                  </tr>
                                  <tr>
                                    <td>Nocturno</td>
                                    <td>0,35</td>
                                    <td>
                                      <p>{{calcularTotalExtrasRecargos(funcionario).totalRn}}</p>
                                    </td>
                                  </tr>

                                  <tr>
                                    <td>Dominical</td>
                                    <td>0,75</td>
                                    <td>
                                      <p>{{calcularTotalExtrasRecargos(funcionario).totalRf}}</p>
                                    </td>
                                  </tr>
                                </thead>
                              </table>
                              <p v-else>El funcionario no presenta recargos</p>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- Modal-->
                      <a
                        href="#"
                        class="d-block item-nomina mb-2"
                        @click.prevent="mostrarModalNovedades(funcionario)"
                      >Vacac, Incap y Lic</a>

                      <!--Modal-->
                      <div
                        class="modal fade"
                        :id="'modalNovedades' + funcionario.original.id"
                        tabindex="-1"
                        role="dialog"
                        style="display: none;"
                        aria-hidden="true"
                      >
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Novedades</h5>
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
                              <table
                                class="table table-sm table-bordered"
                                v-if="funcionario.original.novedades.length > 0"
                              >
                                <thead>
                                  <tr>
                                    <th>Concepto</th>
                                    <th>Fecha</th>
                                    <th>Días</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr
                                    v-for="(nov,index) in funcionario.original.novedades"
                                    :key="`A-${index}`"
                                  >
                                    <td>{{nov.novedad.concepto}}</td>
                                    <td>Del {{getFechaFormato(nov.fecha_inicio)}} al {{getFechaFormato(nov.fecha_fin)}}</td>
                                    <td>{{getDiasDiferencia(nov.fecha_inicio,nov.fecha_fin)}}</td>
                                  </tr>
                                </tbody>
                              </table>
                              <p v-else>No existen novedades para este funcionario.</p>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!--Modal-->
                      <a
                        href="#"
                        class="d-block item-nomina"
                        @click.prevent="mostrarModalIngresosP(funcionario)"
                      >Otros ingresos</a>
                      <!--Modal-->
                      <div
                        class="modal fade"
                        :id="'modalIngresosP' + funcionario.original.id"
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
                                :ref="'ingresoP'+funcionario.original.id"
                                :funcionarioProp="funcionario.original"
                              ></ingreso-prestacional>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!--Modal-->
                    </div>
                  </td>
                  <td>
                    <div>
                      <a
                        href="#"
                        class="d-block item-nomina"
                        @click.prevent="mostrarModalIngresosNP(funcionario)"
                      >Otros ingresos</a>

                      <!--Modal Ingresos NP-->
                      <div
                        class="modal fade"
                        :id="'modalIngresosNP' + funcionario.original.id"
                        tabindex="-1"
                        role="dialog"
                        style="display: none;"
                        aria-hidden="true"
                      >
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Otros Ingresos no constitutivos</h5>
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
                              <ingreso-no-prestacional
                                @cerrar="cerrarModalIngresosNP(funcionario)"
                                :ref="'ingresoNP'+funcionario.original.id"
                                :funcionarioProp="funcionario.original"
                              ></ingreso-no-prestacional>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!--Modal Ingresos NP-->
                    </div>
                  </td>

                  <td>
                    <div>
                      <a
                        href="#"
                        class="d-block item-nomina"
                        @click.prevent="mostrarModalDeducciones(funcionario)"
                      >Otras deducciones</a>
                      <!--Modal Deducciones-->
                      <div
                        class="modal fade"
                        :id="'modalDeducciones' + funcionario.original.id"
                        tabindex="-1"
                        role="dialog"
                        style="display: none;"
                        aria-hidden="true"
                      >
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Otras Deducciones</h5>
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
                              <deduccion
                                @cerrar="cerrarModalDeducciones(funcionario)"
                                :ref="'deduccion'+funcionario.original.id"
                                :funcionarioProp="funcionario.original"
                              ></deduccion>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!--Modal Deducciones-->
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
                  </td>
                </tr>
              </tbody>
            </table>
            <!-- Modal Extras y recargos-->
            <div></div>
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
import Overlay from '../../utiles/Overlay'
import CardConcepto from './reutilizables/CardConcepto'

export default {
  components: {
    IngresoPrestacional,
    IngresoNoPrestacional,
    Deduccion,
    Overlay,
    CardConcepto,
  },
  data() {
    return {
      nomina: '',
      funcionarios: [],
      renderizar: false,
    }
  },

  created() {
    this.getPagoNomina()
  },

  methods: {
    getPagoNomina() {
      axios.get('/api/nomina/pago').then(datos => {
        this.nomina = datos.data
        this.cargarDatosFuncionarios()
      })
    },

    cargarDatosFuncionarios(fechaInicio, fechaFin) {
      axios.get('/api/nomina/pago/funcionarios/').then(datos => {
        this.funcionarios = datos.data
        this.renderizar = true
      })
    },

    mostrarModalExtrasRecargos(funcionario) {
      let elemento = `#modalExtrasRecargos${funcionario.original.id}`

      $(elemento).modal({
        backdrop: 'static',
        keyboard: false,
      })
    },

    mostrarModalNovedades(funcionario) {
      let elemento = `#modalNovedades${funcionario.original.id}`

      $(elemento).modal({
        backdrop: 'static',
        keyboard: false,
      })
    },
    mostrarModalIngresosP(funcionario) {
      let elemento = `#modalIngresosP${funcionario.original.id}`
      let elementoRef = `ingresoP${funcionario.original.id}`
      //Llamar método de la referencia hija ingreso-prestacional
      this.$refs[elementoRef][0].borrarDatos()
      this.$refs[elementoRef][0].getIngresosPrestacionales()
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

    getFechaFormato(fecha) {
      return moment(fecha).format('DD/MM/YYYY')
    },

    getDiasDiferencia(fechaUno, fechaDos) {
      return moment
        .duration(moment(fechaDos).diff(moment(fechaUno)))
        .add(1, 'd')
        .as('days')
    },

    calcularTotalExtrasRecargos(funcionario) {
      let totalHed = 0
      let totalHen = 0
      let totalHedfd = 0
      let totalHedfn = 0
      let totalRn = 0
      let totalRf = 0
      funcionario.original.horas_extras.forEach(function(hora) {
        totalHed += hora.hed
        totalHen += hora.hen
        totalHedfd += hora.hedfd
        totalHedfn += hora.hedfn
        totalRn += hora.rn
        totalRf += hora.rf
      })

      return {
        totalHed,
        totalHen,
        totalHedfd,
        totalHedfn,
        totalRn,
        totalRf,
      }
    },
  },
  computed: {
    inicioPeriodoPagoFormato() {
      return moment(this.nomina.inicio_periodo).format('DD/MM/YYYY')
    },

    finPeriodoPagoFormato() {
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
</style>
