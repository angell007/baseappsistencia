<template>
   <div class="container-fluid">
      <div class="row">
        <div class="col-12">
            <div class="card">
              <div class="card-body">
                   <form @submit.prevent>
                  <div class="form-row">
                    <div class="form-group col-md-3">
                      <label for="nombre_empresa">Nombre de la Empresa</label>
                      <input
                        type="text"
                        name="nombre_empresa"
                        class="form-control"
                        id="nombre_empresa"
                        placeholder="nombre_empresa"
                        
                      >
                    </div>
                    <div class="form-group col-md-3">
                      <label for="cargo">Cargo</label>
                      <input
                        type="text"
                        name="cargo"
                        class="form-control"
                        id="cargo"
                        placeholder="cargo"
                        v-model="funcionarioEditar.cargo"
                      >
                    </div>
                    <div class="form-group col-md-3">
                      <label for="fecha_ingreso">Fecha de ingreso</label>
                      <input
                        type="text"
                        name="fecha_ingreso"
                        class="form-control"
                        id="fecha_ingreso"
                        placeholder="Fecha de ingreso"
                       
                      >
                    </div>
                    <div class="form-group col-md-3">
                      <label for="fecha_retiro">Fecha de retiro</label>
                      <input
                        type="text"
                        name="fecha_retiro"
                        class="form-control"
                        id="fecha_retiro"
                        placeholder="Fecha de retiro"
                        
                      >
                    </div>
                  </div>

                   <div class="form-group col-md-12">
                      <label for="email">Labores</label>

                      <textarea name="labores" id="labores" cols="30" rows="10"></textarea>
                      
                    </div>
                  

                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="nombre_jefe">Nombre del Jefe Inmediato</label>
                      <input
                        type="text"
                        name="nombre_jefe"
                        class="form-control"
                        id="nombre_jefe"
                       
                      >
                    </div>
                    <div class="form-group col-md-6">
                      <label for="telefono_empresa">Telefono de la empresa</label>
                      <input
                        type="text"
                        name="telefono_empresa"
                        class="form-control"
                        id="telefono_empresa"
                        
                      >
                    </div>
                 
                  </div>

                  <button type="submit" class="btn btn-secondary btn-sm d-block mt-3" @click="guardarDatosExperiencia">Guardar</button>
                </form>
              </div>
            </div>
        </div>
      </div>
   </div>
</template>

<script>
export default {
 
  data() {
    return {
     
    };
  },

  mounted() {
   
     
  },

  methods: {
      guardarDatosExperiencia() {
          axios.put(`/api/${localStorage.getItem('tenant')}/funcionarios/${this.funcionarioEditar.id}/editar`, this.funcionarioEditar).then(respuesta => {
            this.$emit('mensaje',  respuesta.data.message)
             
          })
          .catch(error => {
              console.log(error.response.data)
          })
      },
  }
};
</script>

<style>
</style>
