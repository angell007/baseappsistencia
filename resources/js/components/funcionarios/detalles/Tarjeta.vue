<template>
  <div>
    <div class="card active">
      <div class="position-relative">
        <a href @click.prevent="redireccionar(identidad)">
          <img class="card-img-top" :src="rutaImagen" alt="Card image cap">
        </a>
        <span
          class="badge badge-pill badge-theme-2 position-absolute badge-top-left"
        >{{fecha_ingreso | lectura}}</span>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-12">
            <a href>
              <p class="list-item-heading mb-3">{{ nombreFormato}}</p>
            </a>
            <footer>
              <p class="text-muted text-small mb-0 font-weight-bold">{{cargo}}</p>
            </footer>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: [
    'id',
    'fecha_ingreso',
    'image',
    'nombres',
    'apellidos',
    'cargo',
    'identidad',
  ],
  data() {
    return {
      rutaImagen: '',
    }
  },
  created() {
    this.rutaImagen = `back/storage/app/public/${this.image}`
  },
  methods: {
    redireccionar(identidad) {
      this.$router.push({
        name: 'DetallesFuncionario',
        params: { id: identidad },
      })
    },
  },
  computed: {
    nombreFormato() {
      return this.nombres.split(' ')[0] + ' ' + this.apellidos.split(' ')[0]
    },
  },
}
</script>

<style scoped>
.card {
  min-height: 298px;
}
.list-item-heading {
  font-size: 0.85rem;
}
</style>
