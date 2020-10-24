<template>
  <select
    class="form-control custom-control"
    v-model="turno"
    :style="{backgroundColor: withColor, color: '#FFF'}"
    @change="changeColor"
  >
    <option value="seleccione">Seleccione</option>
    <option
      v-for="turno in turnos"
      :key="turno.id"
      :value="turno.id"
      :style="{backgroundColor: turno.color, color: '#FFF'}"
    >{{turno.nombre}} ({{ turno.hora_inicio_uno}} {{turno.hora_fin_uno}})</option>
  </select>
</template>

<script>
export default {
  props: {
    turnos: Array,
  },

  data() {
    return {
      turno: 'seleccione',
      active: false,
      withColor: '#9da4ad',
    }
  },
  methods: {
    changeColor() {
      if (this.turno === 'seleccione') {
        this.withColor = '#9da4ad'
        return
      }

      this.withColor = this.turnos.find(turno => {
        return turno.id === this.turno
      }).color
    },
  },
}
</script>

