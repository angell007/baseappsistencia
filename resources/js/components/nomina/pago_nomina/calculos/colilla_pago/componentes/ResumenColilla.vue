<template>
  <div>
    <h2 class="text-center" style="line-height:35px;">Total a neto a pagar:<br>{{netoApagar | moneda}}</h2>
    <p class="text-center text-uppercase font-weight-bold text-muted mt-3">Resumen del pago</p>

    <div class="row icon-cards-row">
      <div class="col-md-3 col-lg-2 col-sm-4 col-6 mb-4" v-if="salarioDatos.salario > 0">
        <div>
          <div class="text-center">
            <i class="iconsmind-Money-2"></i>
            <p class="card-text font-weight-semibold mb-0" style="height:18px;">Salario</p>
            <p class="lead text-center">{{salarioDatos.salario | moneda}}</p>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-lg-2 col-sm-4 col-6 mb-4">
        <div>
          <div class="text-center">
            <i class="iconsmind-Clock-Forward"></i>
            <p class="card-text font-weight-semibold mb-0" style="height:18px;">Horas extras y recargos</p>
            <p
              class="lead text-center"
              v-if="horasExtrasDatos.valor_total"
            >{{horasExtrasDatos.valor_total | moneda}}</p>
            <p class="lead text-center" v-else>COP 0</p>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-lg-2 col-sm-4 col-6 mb-4">
        <div>
          <div class="text-center">
            <i class="iconsmind-Bell-2"></i>
            <p class="card-text font-weight-semibold mb-0" style="height:18px;">Novedades</p>
            <p
              class="lead text-center"
              v-if="novedadesDatos.valor_total > 0"
            >{{novedadesDatos.valor_total | moneda}}</p>
            <p class="lead text-center" v-else>COP 0</p>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-lg-2 col-sm-4 col-6 mb-4">
        <div>
          <div class="text-center">
            <i class="iconsmind-Financial"></i>
            <p class="card-text font-weight-semibold mb-0" style="height:18px;">Ingresos adicionales</p>
            <p
              class="lead text-center"
              v-if="ingresosDatos.valor_total > 0"
            >{{ingresosDatos.valor_total | moneda}}</p>
            <p class="lead text-center"  v-else>COP 0</p>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-lg-2 col-sm-4 col-6 mb-4" v-if="retencionesDatos.valor_total > 0">
        <div>
          <div class="text-center">
            <i class="iconsmind-Token-"></i>
            <p class="card-text font-weight-semibold mb-0" style="height:18px;">Retenciones</p>
            <p class="lead text-center" >{{retencionesDatos.valor_total | moneda}}</p>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-lg-2 col-sm-4 col-6 mb-4">
        <div>
          <div class="text-center">
            <i class="iconsmind-Basket-Coins"></i>
            <p class="card-text font-weight-semibold mb-0">Deducciones</p>
            <p
              class="lead text-center"
              v-if="deduccionesDatos.valor_total > 0"
            >{{deduccionesDatos.valor_total | moneda}}</p>
            <p class="lead text-center" v-else>COP 0</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    salarioDatos: Object,
    horasExtrasDatos: Object,
    novedadesDatos: Object,
    ingresosDatos: Object,
    retencionesDatos: Object,
    deduccionesDatos: Object,
    netoApagar: Number,
  },
}
</script>

<style scoped>
p small {
  font-size: 13.5px;
  font-weight: bold;
}
p i {
  font-size: 26px;
}
.icon-cards-row {
  display: flex;
  justify-content: center;
}

.icon-cards-row i {
  font-size: 36px;
  line-height: 66px;
  color: #2a93d5;
}
.lead {
  color: #2a93d5;
  font-size: 16px;
}
</style>
