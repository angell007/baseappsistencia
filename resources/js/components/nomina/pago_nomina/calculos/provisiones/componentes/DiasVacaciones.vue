<template>
  <div>
    <p class="text-center text-uppercase font-weight-bold text-muted mt-1">
      Cálculo días de vacaciones
      <i class="iconsmind-Plane"></i>
    </p>
    <p>
      <small>El valor 4.17% corresponde a 15 días hábiles de descanso remunerado por cada año cumplido de labor (15 días / 360 días = 0.041666667 = 4.17 % )</small>
    </p>
    <table class="table table-sm table-bordered">
      <thead>
        <tr>
          <th class="text-center">Días base vacaciones</th>
          <th class="text-center">% vacaciones = 15 días / 360</th>
          <th class="text-center">Días hábiles de vacaciones disfrutadas o compensadas en dinero</th>
          <th
            class="text-center"
          >x = ((Días trabajados * %) - Días hábiles de vacaciones disfrutadas o compensadas en dinero)</th>
          <th class="text-center">Vacaciones acumuladas en el periodo</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="text-center">{{diasVacaciones.dias_base_vacaciones}}</td>
          <td class="text-center">4.17%</td>
          <td class="text-center">{{diasVacaciones.dias_habiles_vacaciones}}</td>
          <td
            class="text-center"
          >({{diasVacaciones.dias_base_vacaciones}} * 4.17%) - {{diasVacaciones.dias_habiles_vacaciones}}</td>
          <td class="text-center">{{diasVacaciones.vacaciones_acumuladas_periodo}}</td>
        </tr>
      </tbody>
    </table>

    <p>
      <small>
        <i class="simple-icon-arrow-right"></i> Todos los meses tienen 30 días y un año tiene 360 días.
      </small>
      <small>Se toman los días trabajados (o en vacaciones o incapacidades) sin incluir los días de suspensión, licencia remunerada, no remunerada o abandono del puesto de trabajo ya que estas novedades no se tienen en cuenta para el cálculo de las vacaciones.</small>
    </p>
    <p>
      <small>
        <i class="simple-icon-arrow-right"></i> Los días hábiles de las vacaciones que empezaron en este periodo que el empleado haya disfrutado o le hayan sido compensadas en dinero, se descontarán de sus vacaciones acumuladas.
      </small>
    </p>
  </div>
</template>

<script>
export default {
  props: { diasVacaciones: Object },
  data() {
    return {}
  },
}
</script>

<style scoped>
p small {
  font-size: 12.5px;
  font-weight: bold;
}
p .iconsmind-Plane {
  font-size: 26px;
}
table thead,
tbody {
  font-size: 0.93rem;
  font-family: 'Lato', sans-serif;
  line-height: 1.9;
}
</style>
