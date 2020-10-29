<template>
  <modal :id="modalReferencia" :ref="modalReferencia">
    <template slot="titulo">Centros de costos</template>
    <template slot="contenido">
      <div class="row">
        <div class="col-md-10 offset-1">
          <table class="table table-bordered table-striped table-sm">
            <thead>
              <tr>
                <th>Nombre</th>
                <th class="text-center">Prefijo</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(centro,index) in centrosCostosDatos" :key="index">
                <td class="custom-label">{{centro.nombre}}</td>
                <td class="text-center custom-label">{{centro.prefijo_cuenta_contable}}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </template>
  </modal>
</template>

<script>
import Modal from '../../utiles/Modal'
export default {
  props: {
    modalReferencia: String,
  },
  components: { Modal },
  data() {
    return {
      centrosCostosDatos: '',
    }
  },
  methods: {
    mostrarModal() {
      this.$refs[this.modalReferencia].mostrarModal()
    },

    getCentrosCostos() {
      if (!this.centrosCostosDatos.length) {
        axios.get(`/api/${localStorage.getItem('tenant')}/centros_costos/datos`).then(datos => {
          this.centrosCostosDatos = datos.data
          this.mostrarModal()
        })
      } else {
        this.mostrarModal()
      }
    },
  },
}
</script>

<style scoped>
</style>
