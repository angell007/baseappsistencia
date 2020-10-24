<template>
  <div>
    <p class="text-center text-uppercase font-weight-bold text-muted mt-4">
      Resumen del pago
      <i class="iconsmind-Coins"></i>
    </p>
    <p
      class="text-center font-weight-bold mt-2"
    >Total pago Segurida social y parafiscales: {{seguridadDatos.valor_total | moneda}}</p>
    <p class="text-center font-weight-bold mt-2">Seguridad social</p>

    <div class="row">
      <div class="col-md-12">
        <table class="table table-sm table-bordered table-striped">
          <thead>
            <tr>
              <th>Concepto</th>
              <th class="text-center">% Empresa</th>
              <th class="text-center">IBC</th>
              <th class="text-center">x = IBC * % Empresa</th>
              <th class="text-center">Valor</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item,index) in seguridad" :key="`H-${index}`">
              <td>{{item.concepto}}</td>
              <td class="text-center">{{item.porcentaje * 100}}%</td>
              <td class="text-center">{{item.ibc | moneda}}</td>
              <td class="text-center">{{item.ibc | moneda}} * {{item.porcentaje * 100}}%</td>
              <td class="text-center" v-if="item.valor > 0">{{item.valor | moneda}}</td>
              <td class="text-center" v-else>${{item.valor}}</td>
            </tr>

            <tr>
              <td class="font-weight-bold">Seguridad social</td>
              <td></td>
              <td></td>
              <td></td>
              <td
                class="text-center font-weight-bold"
              >{{seguridadDatos.valor_total_seguridad | moneda}}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <p>
      <small>Tenga en cuenta que la empresa podría estar exenta de pago de Aportes a Salud si en la configuración general de la compañía "aplica para Ley 1607 de 2012".</small>
    </p>

    <p class="text-center font-weight-bold mt-2">Parafiscales</p>
    <table class="table table-sm table-bordered table-striped">
      <thead>
        <tr>
          <th>Concepto</th>
          <th class="text-center">% Empresa</th>
          <th class="text-center">IBC</th>
          <th class="text-center">x = IBC * % Empresa</th>
          <th class="text-center">Valor</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item,index) in parafiscales" :key="`I-${index}`">
          <td>{{item.concepto}}</td>
          <td class="text-center">{{item.porcentaje * 100}}%</td>
          <td class="text-center">{{item.ibc | moneda}}</td>
          <td class="text-center">{{item.ibc | moneda}} * {{item.porcentaje * 100}}%</td>
          <td class="text-center" v-if="item.valor > 0">{{item.valor | moneda}}</td>
          <td class="text-center" v-else>${{item.valor}}</td>
        </tr>

        <tr>
          <td class="font-weight-bold">Parafiscales</td>
          <td></td>
          <td></td>
          <td></td>
          <td
            class="text-center font-weight-bold"
          >{{seguridadDatos.valor_total_parafiscales | moneda}}</td>
        </tr>
      </tbody>
    </table>

    <p>
      <small>Tenga en cuenta que la empresa podría estar exenta de pago de Aportes a Sena e ICBF si en la configuración general de la compañía "aplica para Ley 1607 de 2012".</small>
    </p>
  </div>
</template>

<script>
export default {
  props: {
    seguridadDatos: Object,
    ibcSeguridad: Number,
    porcentajesDatos: Object,
  },
  data() {
    return {
      seguridad: [],
      parafiscales: [],
      ibc: {},
    }
  },
  created() {
    this.crearObjetoIbc()
    this.organizarDatos(this.seguridadDatos.seguridad_social, this.seguridad)
    this.organizarDatos(this.seguridadDatos.parafiscales, this.parafiscales)
  },
  methods: {
    crearObjetoIbc() {
      this.ibc.salud = this.ibcSeguridad
      this.ibc.pension = this.ibcSeguridad
      this.ibc.riesgos = this.seguridadDatos.ibc_riesgos['IBC Riesgos']
      this.ibc.sena = this.seguridadDatos.ibc_parafiscales['IBC Parafiscales']
      this.ibc.icbf = this.seguridadDatos.ibc_parafiscales['IBC Parafiscales']
      this.ibc.caja_compensacion = this.seguridadDatos.ibc_parafiscales[
        'IBC Parafiscales'
      ]
    },

    obtenerPrefijo(prefijo, objeto = {}) {
      for (let propiedad in objeto) {
        let prefijoPropiedad = propiedad.slice(0, 4).toLowerCase()
        if (prefijoPropiedad === prefijo) {
          return objeto[propiedad]
        }
      }
    },

    organizarDatos(objetoSeguridad, arrayAllenar = []) {
      for (let prop in objetoSeguridad) {
        let objeto = Object.create(null)
        let prefijo = prop.slice(0, 4).toLowerCase()
        objeto['porcentaje'] = this.obtenerPrefijo(
          prefijo,
          this.porcentajesDatos
        )
        objeto['ibc'] = this.obtenerPrefijo(prefijo, this.ibc)
        objeto['concepto'] = prop
        objeto['valor'] = objetoSeguridad[prop]
        arrayAllenar.push(objeto)
      }
    },
  },
}
</script>

<style scoped>
p small {
  font-size: 12.5px;
  font-weight: bold;
}

table thead,
tbody {
  font-size: 0.93rem;
  font-family: 'Lato', sans-serif;
  line-height: 1.9;
}
p i {
  font-size: 26px;
}
</style>
