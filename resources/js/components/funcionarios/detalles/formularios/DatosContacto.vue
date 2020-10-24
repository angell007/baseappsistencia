<template>
  <div v-if="mostrarModal">
    <transition name="modal">
      <div class="modal-mask">
        <div class="modal-wrapper">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Edición Datos de Contacto de Emergencia</h5>
                <button
                  type="button"
                  class="close"
                  data-dismiss="modal"
                  aria-label="Close"
                  @click="mostrarModal = false"
                >
                  <span aria-hidden="true">×</span>
                </button>
              </div>
              <div class="modal-body">
                <form @submit.prevent>
                  <div class="form-row">
                    <div class="form-group col-md-4">
                      <label for="nombre_completo">Nombre completo</label>
                      <input
                        type="text"
                        name="nombre_completo"
                        class="form-control"
                        id="nombre_completo"
                       
                        v-model="funcionarioEditar.contactos_emergencia.nombre_completo"
                      >
                    </div>
                    <div class="form-group col-md-4">
                      <label for="parentesco">Parentesco</label>
                      <input
                        type="text"
                        name="parentesco"
                        class="form-control"
                        id="parentesco"
                        v-model="funcionarioEditar.contactos_emergencia.parentesco"
                      >
                    </div>
                    <div class="form-group col-md-4">
                      <label for="telefono">Teléfono</label>
                      <input
                        type="text"
                        name="telefono"
                        class="form-control"
                        id="telefono"
                        placeholder="Teléfono"
                        v-model="funcionarioEditar.contactos_emergencia.telefono"
                      >
                    </div>
                  </div>

                  <div class="form-row">
                    <div class="form-group col-md-4">
                      <label for="celular">Celular</label>
                      <input
                        type="text"
                        name="celular"
                        class="form-control"
                        id="celular"
                        v-model="funcionarioEditar.contactos_emergencia.celular"
                      >
                    </div>
                    <div class="form-group col-md-8">
                      <label for="direccion">Dirección de residencia</label>
                      <input
                        type="text"
                        name="direccion"
                        class="form-control"
                        id="direccion"
                        v-model="funcionarioEditar.contactos_emergencia.direccion"
                      >
                    </div>
                  
                  </div>

                  <button type="submit" class="btn btn-secondary btn-sm d-block mt-3" @click="guardarDatosContacto">Guardar</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
export default {
  props: {
      funcionarioEditar: Object
  },
  data() {
    return {
      mostrarModal: false,
    };
  },

  mounted() {
     
  },

  methods: {
      guardarDatosContacto() {
         
          axios.put(`/funcionarios/${this.funcionarioEditar.id}/contacto/${this.funcionarioEditar.contactos_emergencia.id}/editar`, this.funcionarioEditar.contactos_emergencia).then(respuesta => {
            this.$emit('mensaje',  respuesta.data.message)
            this.mostrarModal = false

              
          })
          .catch(error => {
            console.log(error.response.data)
          })

      }
  }
};
</script>

<style>
</style>
