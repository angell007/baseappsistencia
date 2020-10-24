<template>
  <table class="table table-sm table-bordered ml-3 mr-3 mt-1" v-if="mostrar">
    <thead>
      <tr>
        <th class="text-center">Fecha</th>
        <th class="text-center">Entrada turno</th>
        <th class="text-center">Entrada real</th>
        <th class="text-center">Tiempo retraso</th>
      </tr>
    </thead>

    <tbody>
      <tr v-for="(llegada,index) in llegadasTarde" :key="index">
        <td class="text-center custom-label">{{llegada.fecha}}</td>
        <td class="text-center custom-label">{{llegada.entrada_turno}}</td>
        <td class="text-center custom-label">{{llegada.entrada_real}}</td>
        <td
          class="text-center custom-label"
        >{{calcularTiempo(llegada.entrada_turno,llegada.entrada_real)}}</td>
      </tr>
    </tbody>
  </table>
</template>

<script>
export default {
  props: {
    llegadas_tarde: Array,
  },
  data() {
    return {
      llegadasTarde: this.llegadas_tarde,
      mostrar: false,
    }
  },
  updated() {
    this.llegadasTarde = this.llegadas_tarde
  },
  methods: {
    calcularTiempo(horaUno, horaDos) {
      let horaInicial = moment.utc(horaUno, 'HH:mm:ss')
      let horaFinal = moment.utc(horaDos, 'HH:mm:ss')

      if (horaFinal.isBefore(horaInicial)) {
        horaFinal.add(1, 'd')
      }

      let duracion = moment.duration(horaFinal.diff(horaInicial))

      return moment.utc(duracion.as('milliseconds')).format('HH:mm:ss')
    },
  },
}
</script>

<style scoped>
table thead tr th {
  font-size: 14px;
}
table tbody tr td {
  font-size: 14px;
}
</style>
