<template>
  <form @submit.prevent="actualizarSalario">
    <div class="form-group col-md-8">
      <label for="salario" class="custom-label">Salario</label>
      <money
        type="text"
        v-model="funcionarioEditar.salario"
        :class="'form-control custom-control'"
        name="salario"
        v-validate="'required|min_value:0|numeric'"
        data-vv-as="Salario"
      ></money>
      <small class="invalid" v-if="errors.has('salario')">{{errors.first('salario')}}</small>
    </div>
    <div class="form-group text-right">
      <button type="submit" class="btn btn-secondary raised">Actualizar</button>
    </div>
  </form>
</template>

<script>
export default {
  props: {
    funcionarioEditar: Object,
    salarioBase: [Number, String],
  },

  methods: {
    actualizarSalario() {
      this.funcionarioEditar.image='';
      delete this.funcionarioEditar["image"];
      this.mostarAlertaSalario().then(resultado => {
        if (resultado.value) {
          axios
            .post(
              `/api/${localStorage.getItem('tenant')}/funcionarios/${this.funcionarioEditar.id}/editar`,
              this.funcionarioEditar
            )
            .then(respuesta => {
              this.$emit('notificar', respuesta.data.message)
              modalEmitter.$emit('cerrar', 'datosSalario')
            })
            .catch(error => {
              this.$swal.fire(
                'Oops!',
                'Ha ocurrido un error, por favor intente más tarde',
                'error'
              )
            })
        }
      })
    },
    mostarAlertaSalario() {
      if (this.funcionarioEditar.salario < this.salarioBase) {
        return this.$swal.fire({
          title: '¿Está seguro(a)?',
          text: 'El salario del funcionario será inferior al salario mínimo',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, continuar!',
          cancelButtonText: 'Cancelar',
        })
      }
      return this.$swal(
        'Tenga en cuenta!',
        'Esto afectará los cálculos de nómina del periodo actual',
        'warning'
      )
    },
  },
}
</script>
