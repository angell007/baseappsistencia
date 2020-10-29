<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="mb-2">
          <h1 class="font-weight-bold">Cuentas Contables</h1>
          <div class="float-sm-right text-zero">
            <button type="button" class="btn btn-link mr-1" @click="verCentrosCostos">
              <i class="simple-icon-eye"></i> Ver Centros de costos
            </button>
          </div>
        </div>

        <!-- Centros de costos-->
        <centros-lista ref="centrosCostos" modalReferencia="centrosLista"></centros-lista>
        <!-- Centros de costos-->

        <div class="separator mb-5"></div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="alert alert-secondary">
          <p
            class="font-weight-bold"
          >Recordar que el prefijo de cada cuenta contable de los centros de costos constituyen el código cuenta contable. Para ver los centros de costos ir a la opción "Ver Centros de costos"</p>
        </div>
      </div>
    </div>
    <div class="container" v-if="renderizar">
      <div class="row">
        <h2 class="pl-3 font-weight-bold">Salario y Subsidio de Transporte</h2>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <tabla
                :contrapartida="true"
                :datos="salarioSubsidioDatos"
                @mostrar="llenarFormulario($event,'formularioSalarioSubsidio','salarioSubsidio')"
                identificador="1"
              ></tabla>
            </div>
          </div>

          <!-- Modal-->
          <modal id="salarioSubsidio" ref="salarioSubsidio">
            <template slot="titulo">Salario y subsidio</template>
            <template slot="contenido">
              <actualizar-datos
                ref="formularioSalarioSubsidio"
                tablaAsociada="1"
                segmentoUrl="salario_subsidio"
                :contrapartida="true"
                @notificar="mostrarMensaje"
              ></actualizar-datos>
            </template>
          </modal>
          <!-- Modal-->
        </div>
      </div>

      <div class="row mt-4">
        <div class="col-12">
          <h3 class="font-weight-bold pl-3 titulo">Ingresos Constitutivos</h3>
        </div>
      </div>

      <div class="row mb-4">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <tabla
                :contrapartida="false"
                :datos="ingresosConstitutivosDatos"
                @mostrar="llenarFormulario($event,'formularioIngresos','ingresos')"
                identificador="2"
              ></tabla>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <h4 class="font-weight-bold pl-3 titulo">Ingresos No Constitutivos</h4>
        </div>
      </div>

      <div class="row mb-4">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <tabla
                :contrapartida="false"
                :datos="ingresosNoConstitutivosDatos"
                @mostrar="llenarFormulario($event,'formularioIngresos','ingresos')"
                identificador="3"
              ></tabla>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Ingresos-->
      <modal id="ingresos" ref="ingresos">
        <template slot="titulo">Ingresos C/NC</template>
        <template slot="contenido">
          <actualizar-ingresos
            ref="formularioIngresos"
            @notificar="mostrarMensaje"
            tablaAsociadaConst="2"
            tablaAsociadaNoConst="3"
          ></actualizar-ingresos>
        </template>
      </modal>
      <!-- Modal-->

      <div class="row">
        <div class="col-12">
          <h5 class="font-weight-bold pl-3 titulo">Licencias e incapacidades</h5>
        </div>
      </div>

      <div class="row mb-4">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <tabla
                :contrapartida="false"
                :datos="licenciasIncapacidadesDatos"
                identificador="4"
                @mostrar="llenarFormulario($event,'formularioLicencias','licencias')"
              ></tabla>
            </div>
          </div>
        </div>

        <!-- Modal Licencias e incapacidades-->
        <modal id="licencias" ref="licencias">
          <template slot="titulo">Licencias e incapacidades</template>
          <template slot="contenido">
            <actualizar-datos
              ref="formularioLicencias"
              tablaAsociada="4"
              segmentoUrl="licencias_incapacidades"
              :contrapartida="false"
              @notificar="mostrarMensaje"
            ></actualizar-datos>
          </template>
        </modal>

        <!-- Modal-->
      </div>

      <div class="row">
        <div class="col-12">
          <h6 class="font-weight-bold pl-3 titulo">Deducciones</h6>
        </div>
      </div>

      <div class="row mb-4">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <tabla
                :contrapartida="false"
                :datos="deduccionesDatos"
                @mostrar="llenarFormulario($event,'formularioDeducciones','deducciones')"
                identificador="5"
              ></tabla>
            </div>
          </div>
        </div>

        <!-- Modal Deducciones-->
        <modal id="deducciones" ref="deducciones">
          <template slot="titulo">Deducciones</template>
          <template slot="contenido">
            <actualizar-datos
              ref="formularioDeducciones"
              tablaAsociada="5"
              segmentoUrl="deducciones"
              :contrapartida="false"
              @notificar="mostrarMensaje"
            ></actualizar-datos>
          </template>
        </modal>
        <!-- Modal-->
      </div>

      <div class="row">
        <div class="col-12">
          <p class="font-weight-bold pl-3 titulo">Prestaciones sociales</p>
        </div>
      </div>

      <div class="row mb-4">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <tabla
                :contrapartida="true"
                :datos="prestacionesSocialesDatos"
                @mostrar="llenarFormulario($event,'formularioPrestaciones','prestaciones')"
                identificador="6"
              ></tabla>
            </div>
          </div>
        </div>

        <!-- Modal Prestaciones sociales-->
        <modal id="prestaciones" ref="prestaciones">
          <template slot="titulo">Prestaciones sociales</template>
          <template slot="contenido">
            <actualizar-datos
              ref="formularioPrestaciones"
              tablaAsociada="6"
              segmentoUrl="prestaciones_sociales"
              :contrapartida="true"
              @notificar="mostrarMensaje"
            ></actualizar-datos>
          </template>
        </modal>
        <!-- Modal-->
      </div>

      <div class="row">
        <div class="col-12">
          <p class="font-weight-bold pl-3 titulo">Seguridad social</p>
        </div>
      </div>

      <div class="row mb-4">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <tabla
                :contrapartida="true"
                :datos="seguridadSocialDatos"
                identificador="7"
                @mostrar="llenarFormulario($event,'formularioSeguridadSocial','seguridadSocial')"
              ></tabla>
            </div>
          </div>
        </div>

        <!-- Modal Prestaciones sociales-->
        <modal id="seguridadSocial" ref="seguridadSocial">
          <template slot="titulo">Seguridad social</template>
          <template slot="contenido">
            <actualizar-datos
              ref="formularioSeguridadSocial"
              tablaAsociada="7"
              segmentoUrl="seguridad_social"
              :contrapartida="true"
              @notificar="mostrarMensaje"
            ></actualizar-datos>
          </template>
        </modal>
        <!-- Modal-->
      </div>

      <div class="row">
        <div class="col-12">
          <p class="font-weight-bold pl-3 titulo">Liquidación</p>
        </div>
      </div>

      <div class="row mb-4">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <tabla
                :contrapartida="false"
                :datos="liquidacionDatos"
                identificador="8"
                @mostrar="llenarFormulario($event,'formularioLiquidacion','liquidacion')"
              ></tabla>
            </div>
          </div>
        </div>

        <!-- Modal Liquidación-->
        <modal id="liquidacion" ref="liquidacion">
          <template slot="titulo">Liquidación</template>
          <template slot="contenido">
            <actualizar-datos
              tablaAsociada="8"
              segmentoUrl="liquidacion"
              :contrapartida="false"
              ref="formularioLiquidacion"
              @notificar="mostrarMensaje"
            ></actualizar-datos>
          </template>
        </modal>
        <!-- Modal-->
      </div>

      <div class="row">
        <div class="col-12">
          <p class="font-weight-bold pl-3 titulo">Bancos y Caja</p>
        </div>
      </div>

      <div class="row mb-4">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <tabla
                identificador="9"
                :contrapartida="false"
                :datos="bancosCajaDatos"
                @mostrar="llenarFormulario($event,'formularioBancosCaja','bancosCaja')"
              ></tabla>
            </div>
          </div>
        </div>

        <!-- Modal Bancos-->
        <modal id="bancosCaja" ref="bancosCaja">
          <template slot="titulo">Bancos y Caja</template>
          <template slot="contenido">
            <actualizar-datos
              tablaAsociada="9"
              segmentoUrl="bancos_caja"
              :contrapartida="false"
              ref="formularioBancosCaja"
              @notificar="mostrarMensaje"
            ></actualizar-datos>
          </template>
        </modal>
        <!-- Modal-->
      </div>
    </div>
    <div class="overlay" v-else>
      <div class="container-spinner">
        <trinity-rings-spinner :animation-duration="600" :size="70" color="#fff"/>
        <p class="text-center font-weight-bold text-spinner">Cargando módulo...</p>
      </div>
    </div>
    <notifications group="notificaciones" position="bottom right"/>
  </div>
</template>

<script>
import { TrinityRingsSpinner } from 'epic-spinners'
import ActualizarIngresos from './formularios/ActualizarIngresos'
import ActualizarDatos from './formularios/ActualizarDatos'
import CentrosLista from './CentrosLista'
import Modal from '../../utiles/Modal'
import Tabla from './reutilizables/Tabla'

export default {
  components: {
    TrinityRingsSpinner,
    ActualizarIngresos,
    ActualizarDatos,
    CentrosLista,
    Modal,
    Tabla,
  },
  data() {
    return {
      renderizar: false,
      BASE_URL: `/api/${localStorage.getItem('tenant')}/parametrizacion`,
      salarioSubsidioDatos: [],
      ingresosConstitutivosDatos: [],
      ingresosNoConstitutivosDatos: [],
      licenciasIncapacidadesDatos: [],
      deduccionesDatos: [],
      prestacionesSocialesDatos: [],
      seguridadSocialDatos: [],
      liquidacionDatos: [],
      bancosCajaDatos: [],
      centrosCostosDatos: [],
    }
  },
  created() {
    this.getAllDatos()
  },
  methods: {
    getAllDatos() {
      axios
        .all([
          this.cargarSalarioSubsidio(),
          this.cargarIngresosConstitutivos(),
          this.cargarIngresosNoConstitutivos(),
          this.cargarLicenciasIncapacidades(),
          this.cargarDeducciones(),
          this.cargarPrestacionesSociales(),
          this.cargarSeguridadSocial(),
          this.cargarLiquidacion(),
          this.cargarBancosCaja(),
        ])
        .then(
          axios.spread(
            (
              salarioSubsidio,
              ingresoConstitutivos,
              ingresoNoConstitutivos,
              licencias,
              deducciones,
              prestaciones,
              seguridadSocial,
              liquidacion,
              bancos
            ) => {
              this.salarioSubsidioDatos = salarioSubsidio.data
              this.ingresosConstitutivosDatos = ingresoConstitutivos.data
              this.ingresosNoConstitutivosDatos = ingresoNoConstitutivos.data
              this.licenciasIncapacidadesDatos = licencias.data
              this.deduccionesDatos = deducciones.data
              this.prestacionesSocialesDatos = prestaciones.data
              this.seguridadSocialDatos = seguridadSocial.data
              this.liquidacionDatos = liquidacion.data
              this.bancosCajaDatos = bancos.data
              this.renderizar = true
            }
          )
        )
    },
    cargarSalarioSubsidio() {
      return axios.get(`${this.BASE_URL}/salario_subsidio/datos`)
    },
    cargarIngresosConstitutivos() {
      return axios.get(`${this.BASE_URL}/ingresos_constitutivos/datos`)
    },
    cargarIngresosNoConstitutivos() {
      return axios.get(`${this.BASE_URL}/ingresos_no_constitutivos/datos`)
    },
    cargarLicenciasIncapacidades() {
      return axios.get(`${this.BASE_URL}/licencias_incapacidades/datos`)
    },
    cargarDeducciones() {
      return axios.get(`${this.BASE_URL}/deducciones/datos`)
    },
    cargarPrestacionesSociales() {
      return axios.get(`${this.BASE_URL}/prestaciones_sociales/datos`)
    },
    cargarSeguridadSocial() {
      return axios.get(`${this.BASE_URL}/seguridad_social/datos`)
    },
    cargarLiquidacion() {
      return axios.get(`${this.BASE_URL}/liquidacion/datos`)
    },
    cargarBancosCaja() {
      return axios.get(`${this.BASE_URL}/bancos_caja/datos`)
    },

    llenarFormulario(item, refFormulario, refModal) {
      this.$refs[refFormulario].datos = Object.assign({}, item)
      this.$refs[refModal].mostrarModal()
    },

    verCentrosCostos() {
      this.$refs.centrosCostos.getCentrosCostos()
    },

    mostrarMensaje(mensaje) {
      setTimeout(
        () =>
          this.$notify({
            group: 'notificaciones',
            title: 'Notificación Importante',
            text: mensaje,
          }),
        600
      )
    },
  },
}
</script>

<style scoped>
.titulo {
  font-size: 1.4rem;
}
</style>
