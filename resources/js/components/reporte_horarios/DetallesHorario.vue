<template>
  <div class="mt-2" v-if="estadoActivo">
    <div class="col-12 pl-4">
      <table class="table table-sm table-bordered">
        <thead>
          <tr>
            <th>Fecha</th>
            <th>Entrada 1</th>
            <th>Salida 1</th>
            <th>Entrada 2</th>
            <th>Salida 2</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(horario, index) in horarios" :key="index">
            <td>
              <span class="custom-label text-center">{{horario.fecha}}</span>
            </td>
            <td>
              <span class="custom-label">{{horario.hora_entrada_uno}} - </span>
              <a class="btn btn-link p-0">
                <i class="iconsmind-Celsius font-weight-bold"></i>
                {{horario.temp_uno}}
              </a>
            </td>
            <td>
              <span class="custom-label">{{horario.hora_salida_uno}} - </span>
              <a class="btn btn-link p-0">
                <i class="iconsmind-Celsius font-weight-bold"></i>
                {{horario.temp_dos}}
              </a>
            </td>
            <td>
              <span class="custom-label">{{horario.hora_entrada_dos || 'No presentó entrada'}} - </span>
              <a class="btn btn-link p-0">
                <i class="iconsmind-Celsius font-weight-bold"></i>
                {{horario.temp_tres}}
              </a>
            </td>
            <td>
              <span class="custom-label">{{horario.hora_salida_dos || 'No presentó salida'}} - </span>
              <a class="btn btn-link p-0">
                <i class="iconsmind-Celsius font-weight-bold"></i>
                {{horario.temp_cuatro}}
              </a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    horarios: Array,
    index: Number,
  },
  data() {
    return {
      estadoActivo: false,
    }
  },
}
</script>

<style scoped>
th {
  font-size: 14px;
}
td,
th {
  text-align: center;
}
a > i {
  color: #2a93d5;
}
</style>
