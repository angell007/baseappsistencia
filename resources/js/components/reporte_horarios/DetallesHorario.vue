<template>
  <div class="mt-2" v-if="estadoActivo">
    <div class="col-12 pl-4">
      <table class="table table-sm table-bordered">
        <thead>
          <tr>
            <th>Fecha</th>
            <th style="width:20%">Entrada 1</th>
            <th style="width:20%">Salida 1</th>
            <th style="width:20%">Entrada 2</th>
            <th style="width:20%">Salida 2</th>
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
              <span class="custom-label" v-if="horario.hora_salida_uno!='00:00:00'" >{{horario.hora_salida_uno}} - </span>
              <a v-if="horario.hora_salida_uno!='00:00:00'" class="btn btn-link p-0">
                <i class="iconsmind-Celsius font-weight-bold"></i>
                {{horario.temp_dos}}
              </a>
              <span v-if="horario.hora_salida_uno=='00:00:00'">Sin Reportar</span>
            </td>
            <td>
              <span class="custom-label" v-if="horario.hora_entrada_dos&&horario.hora_entrada_dos!='00:00:00'">{{horario.hora_entrada_dos}} - </span>
              <a v-if="horario.hora_entrada_dos&&horario.hora_entrada_dos!='00:00:00'" class="btn btn-link p-0">
                <i class="iconsmind-Celsius font-weight-bold"></i>
                {{horario.temp_tres}}
              </a>
              <span v-if="!horario.hora_entrada_dos||horario.hora_entrada_dos=='00:00:00'">Sin Reportar</span>
            </td>
            <td>
              <span class="custom-label" v-if="horario.hora_salida_dos&&horario.hora_salida_dos!='00:00:00'">{{horario.hora_salida_dos}} - </span>
              <a v-if="horario.hora_salida_dos&&horario.hora_salida_dos!='00:00:00'" class="btn btn-link p-0">
                <i class="iconsmind-Celsius font-weight-bold"></i>
                {{horario.temp_cuatro}}
              </a>
              <span v-if="!horario.hora_salida_dos||horario.hora_salida_dos=='00:00:00'">Sin Reportar</span>
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
