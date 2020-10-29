<template>
  <div class="container" v-if="renderizar">
    <h1 class="font-weight-bold">Historial de pagos</h1>
    <div class="row" v-if="!historialPagos.length">
      <div class="col-12">
        <div class="alert alert-secondary">
          <p
            class="font-weight-bold"
          >Aún no se ha realizado el primer pago de nómina, una vez hecho el pago podrá visualizar y filtrar el historial de pagos por periodo.</p>
        </div>
      </div>
    </div>
    <div class="row" v-else>
      <div class="col-md-12">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Periodo</th>
              <th>Salarios</th>
              <th>Retenciones</th>
              <th>Provisiones</th>
              <th>Seguridad social</th>
              <th>Parafiscales</th>
              <th>Costo total empresa</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="pago in historialPagos" :key="pago.id">
              <td class="custom-label">
                <a
                  href="#"
                  class="btn btn-link p-0"
                  @click.prevent="redirectToNomina(pago)"
                >{{formatFechas(pago)}}</a>
              </td>
              <td class="custom-label">{{pago.total_salarios | moneda}}</td>
              <td class="custom-label">{{pago.total_retenciones | moneda}}</td>
              <td class="custom-label">{{pago.total_provisiones | moneda}}</td>
              <td class="custom-label">{{pago.total_seguridad_social | moneda}}</td>
              <td class="custom-label">{{pago.total_parafiscales | moneda}}</td>
              <td class="custom-label">{{pago.costo_total | moneda}}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <overlay v-else></overlay>
</template>

<script>
import Overlay from '../utiles/Overlay'
export default {
  components: { Overlay },
  data() {
    return {
      historialPagos: [],
      renderizar: false,
    }
  },
  created() {
    this.getHistorialPagos()
  },

  methods: {
    getHistorialPagos() {
      axios.get(`/api/${localStorage.getItem('tenant')}/nomina/historial_pagos/nomina`).then(datos => {
        this.historialPagos = datos.data
        this.renderizar = true
      })
    },

    redirectToNomina(periodoPago) {
      this.$router.push({
        name: 'PagoNomina',
        params: {
          inicio: periodoPago.inicio_periodo,
          fin: periodoPago.fin_periodo,
        },
      })
    },
    formatFechas({ inicio_periodo, fin_periodo }) {
      const inicioPeriodo = moment(inicio_periodo).format('DD/MM/YYYY')
      const finPeriodo = moment(fin_periodo).format('DD/MM/YYYY')
      return `${inicioPeriodo} - ${finPeriodo}`
    },
  },
}
</script>

<style scoped>
thead,
tbody {
  text-align: center;
}
table tbody td {
  font-family: 'lato';
}
</style>
