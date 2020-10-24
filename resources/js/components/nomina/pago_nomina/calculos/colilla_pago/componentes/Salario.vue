<template>
  <div>
    <p class="text-center text-uppercase font-weight-bold text-muted mt-3">
      Salario Base y Subsidio
      <i class="iconsmind-Money-2"></i>
    </p>
    <table class="table table-sm table-bordered table-striped">
      <thead>
        <tr>
          <th>Item</th>
          <th class="text-center">Valor/Periodo</th>
          <th class="text-center">Días trabajados</th>
          <th class="text-center">Fórmula = Valor mensual * días trabajados / Periodo días</th>
          <th class="text-center">Valor</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Salario</td>
          <td class="text-center">{{funcionario.salario | moneda}}</td>
          <td class="text-center">{{salarioDatos.dias_trabajados}}</td>
          <td
            class="text-center"
          >{{funcionario.salario | moneda}} * {{salarioDatos.dias_trabajados}} / 30</td>
          <td class="text-center">{{salarioDatos.salario | moneda}}</td>
        </tr>
        <tr v-if="funcionario.subsidio_transporte">
          <td>Auxilio de transporte</td>
          <td class="text-center">{{datosEmpresa.auxilio_transporte | moneda}}</td>
          <td class="text-center">{{salarioDatos.dias_trabajados}}</td>
          <td
            class="text-center"
          >{{datosEmpresa.auxilio_transporte | moneda}} * {{salarioDatos.dias_trabajados}} / 30</td>
          <td class="text-center">{{salarioDatos.auxilio_transporte | moneda}}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  props: {
    datosEmpresa: Object,
    funcionario: Object,
    salarioDatos: Object,
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
p i {
  font-size: 28px;
}
</style>
