<template>
  <div>
    <div class="card active">
      <div class="position-relative imagen-persona">
        <a href @click.prevent="redireccionar(identidad)">
          <img class="card-img-top" :src="rutaImagen" alt="">
        </a>
        <span
          class="badge badge-pill badge-theme-2 position-absolute badge-top-left"
        >{{fecha_ingreso | lectura}}</span>
      </div>
      <div class="card-body p-3">
        <div class="row">
          <div class="col-12">
            <a href @click.prevent="redireccionar(identidad)">
              <p class="list-item-heading mb-1">{{ nombres.split(' ')[0] }}<br>{{ apellidos.split(' ')[0] }}</p>
              <p class="text-muted text-small mb-0 font-weight-bold">{{cargo}}</p>
            </a>
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
    if(this.image){
            this.rutaImagen = `${this.image}`

      // this.rutaImagen = `back/storage/app/public/${this.image}`
    }else{
      this.rutaImagen = `/img/robot.jpg`
    }
    
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
      return this.nombres.split(' ')[0] + '<br>' + this.apellidos.split(' ')[0]
    },
  },
}
</script>

<style scoped>
.card {
  /*min-height: 298px;*/
}
.list-item-heading {
  font-size: 0.85rem;
}
.imagen-persona{
  border-bottom: 1px solid #ccc;
}
</style>
