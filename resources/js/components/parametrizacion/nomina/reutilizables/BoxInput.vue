<template>
  <input
    type="number"
    :step="patron"
    name="porcentaje"
    v-model="parametroDato.porcentaje"
    class="input-porcentaje custom-label"
    min="0"
    max="100"
    @input="validarPorcentaje"
    :disabled="deshabilitado"
  >
</template>

<script>
export default {
  props: ['patron', 'parametro'],
  data() {
    return {
      parametroDato: '',
      parametroInicialDato: '',
      deshabilitado: false,
    }
  },

  created() {
    this.parametroDato = this.parametro
  },

  methods: {
    validarPorcentaje() {
      if (
        this.parametroDato.porcentaje == '' ||
        this.parametroDato.porcentaje <= 0
      ) {
        this.parametroDato.porcentaje = 0
      }
    },
  },
}
</script>

<style>
.input-porcentaje {
  border-radius: 1px;
  outline: aliceblue;
  border: 1px solid;
  border-color: #807f7f;
  text-align: center;
  width: 120px;
  font-family: 'Lato';
}
.input-porcentaje:focus {
  border: 1px solid #2a93d5;
}
</style>
