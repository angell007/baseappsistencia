<template>
  <select class="form-control" v-model="turnoId" @change="actualizar" :style="{background: bgColor, color:'#fff'}">
    <option value="seleccione" style="background-color: #3c3c3c;">Seleccione</option>
    <option
      v-for="(turno,index) in turnos"
      :key="index"
      :value="turno.id"
      :style="{backgroundColor: turno.color, color: '#fff'}"
    >{{turno.nombre}} ({{ turno.hora_inicio_uno}} {{turno.hora_fin_uno}})</option>
  </select>
</template>

<script>
export default {
  props: {
    turnos: Array,
    id: Number,
    turno_id: Number,
    funcionario_id: Number,
    fecha: String,
    color: String,
  },

  data() {
    return {
      horarioId: this.id,
      turnoId: this.turno_id || 'seleccione',
      funcionarioId: this.funcionario_id,
      bgColor: this.color,
    
    };
  },

  methods: {
    actualizar() {
      this.$emit('actualizar',{'horarioId': this.horarioId,'turnoId':this.turnoId, 'funcionarioId':this.funcionarioId})
    },
  }
};
</script>

<style>
</style>
