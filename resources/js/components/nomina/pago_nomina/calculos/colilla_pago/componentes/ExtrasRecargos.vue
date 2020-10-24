<template>
  <div v-if="horasExtrasDatos.valor_total > 0">
    <p class="text-center text-uppercase font-weight-bold text-muted mt-3">
      Horas Extras y recargos
      <i class="iconsmind-Clock-Forward"></i>
    </p>
    <table class="table table-sm table-striped table-bordered">
      <thead>
        <tr>
          <th>Concepto</th>
          <th class="text-center">Valor sobre hora</th>
          <th class="text-center">Cantidad de horas</th>
          <th
            class="text-center"
          >x = Salario Promedio * Valor sobre hora * horas / (30 días * 8 horas)</th>
          <th style="width:9.5%" class="text-center">Valor</th>
        </tr>
      </thead>

      <tbody>
        <tr v-if="horasExtrasDatos.horas_reportadas.hed > 0">
          <td>Hora extra diurna</td>
          <td class="text-center">{{porcentajesExtrasDatos.hed}}</td>
          <td class="text-center">{{horasExtrasDatos.horas_reportadas.hed}}</td>
          <td
            class="text-center"
          >{{funcionario.salario | moneda}} * {{porcentajesExtrasDatos.hed}} * {{horasExtrasDatos.horas_reportadas.hed}} / (30 * 8)</td>
          <td class="text-center">{{horasExtrasDatos.horas_extras_totales.hed | moneda}}</td>
        </tr>

        <tr v-if="horasExtrasDatos.horas_reportadas.hen > 0">
          <td>Hora extra nocturna</td>
          <td class="text-center">{{porcentajesExtrasDatos.hen}}</td>
          <td class="text-center">{{horasExtrasDatos.horas_reportadas.hen}}</td>
          <td
            class="text-center"
          >{{funcionario.salario | moneda}} * {{porcentajesExtrasDatos.hen}} * {{horasExtrasDatos.horas_reportadas.hen}} / (30 * 8)</td>
          <td class="text-center">{{horasExtrasDatos.horas_extras_totales.hen | moneda}}</td>
        </tr>

        <tr v-if="horasExtrasDatos.horas_reportadas.hedfd > 0">
          <td>Hora extra diurna dom/fest</td>
          <td class="text-center">{{porcentajesExtrasDatos.hedfd}}</td>
          <td class="text-center">{{horasExtrasDatos.horas_reportadas.hedfd}}</td>
          <td
            class="text-center"
          >{{funcionario.salario | moneda}} * {{porcentajesExtrasDatos.hedfd}} * {{horasExtrasDatos.horas_reportadas.hedfd}} / (30 * 8)</td>
          <td class="text-center">{{horasExtrasDatos.horas_extras_totales.hedfd | moneda}}</td>
        </tr>

        <tr v-if="horasExtrasDatos.horas_reportadas.hedfn > 0">
          <td>Hora extra nocturna dom/fest</td>
          <td class="text-center">{{porcentajesExtrasDatos.hedfn}}</td>
          <td class="text-center">{{horasExtrasDatos.horas_reportadas.hedfn}}</td>
          <td
            class="text-center"
          >{{funcionario.salario | moneda}} * {{porcentajesExtrasDatos.hedfn}} * {{horasExtrasDatos.horas_reportadas.hedfn}} / (30 * 8)</td>
          <td class="text-center">{{horasExtrasDatos.horas_extras_totales.hedfn | moneda}}</td>
        </tr>

        <tr v-if="horasExtrasDatos.horas_reportadas.rn > 0">
          <td>Recargo nocturno</td>
          <td class="text-center">{{porcentajesExtrasDatos.rn}}</td>
          <td class="text-center">{{horasExtrasDatos.horas_reportadas.rn}}</td>
          <td
            class="text-center"
          >{{funcionario.salario | moneda}} * {{porcentajesExtrasDatos.rn}} * {{horasExtrasDatos.horas_reportadas.rn}} / (30 * 8)</td>
          <td class="text-center">{{horasExtrasDatos.horas_extras_totales.rn | moneda}}</td>
        </tr>
        <tr v-if="horasExtrasDatos.horas_reportadas.rf > 0">
          <td>Recargo dom/fest</td>
          <td class="text-center">{{porcentajesExtrasDatos.rf}}</td>
          <td class="text-center">{{horasExtrasDatos.horas_reportadas.rf}}</td>
          <td
            class="text-center"
          >{{funcionario.salario | moneda}} * {{porcentajesExtrasDatos.rf}} * {{horasExtrasDatos.horas_reportadas.rf}} / (30 * 8)</td>
          <td class="text-center">{{horasExtrasDatos.horas_extras_totales.rf | moneda}}</td>
        </tr>

        <tr class="fila-total">
          <td>Total pago por horas</td>
          <td></td>
          <td></td>
          <td></td>
          <td class="text-center">{{horasExtrasDatos.valor_total | moneda}}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  props: {
    horasExtrasDatos: Object,
    porcentajesExtrasDatos: Object,
    funcionario: Object,
  },
}
</script>

<style scoped>
table thead,
tbody {
  font-size: 0.95rem;
  font-family: 'Lato', sans-serif;
  line-height: 1.9;
}
.fila-total {
  background-color: #eeeeee;
  font-weight: bold;
  color: #1b1a1a;
}
p i {
  font-size: 28px;
}
</style>
