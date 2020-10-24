<template>
  <table class="table table-bordered table-striped table-sm">
    <thead>
      <tr>
        <th>Concepto</th>
        <th class="text-center">Cuenta Contable</th>
        <th class="text-center" v-if="contrapartida">Contrapartida</th>
        <th class="text-center">Estado</th>
        <th class="text-center">Acciones</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(dato,index) in datosEdicion" :key="index">
        <td class="custom-label">{{dato.concepto}}</td>
        <td class="text-center custom-label">{{dato.cuenta_contable}}</td>
        <td class="text-center custom-label" v-if="contrapartida">{{dato.contrapartida}}</td>
        <td class="text-center custom-label">{{dato.estado ? 'Activo' : 'Inactivo'}}</td>
        <td class="text-center custom-label">
          <a href="#" @click.prevent="$emit('mostrar', dato)">
            <i class="iconsmind-Pencil table-icon"></i>
          </a>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script>
export default {
  props: { contrapartida: Boolean, datos: Array, identificador: String },

  data() {
    return {
      datosEdicion: '',
    }
  },
  created() {
    this.datosEdicion = this.datos
    this.actualizarTabla()
  },
  methods: {
    /** Escuchar evento y actualizar tabla  */
    actualizarTabla() {
      const evento = `actualizarTabla${this.identificador}`
      eventEmitter.$on(evento, dato => {
        const item = this.datosEdicion.find(datoEdicion => {
          return datoEdicion.id === dato.id
        })
        const posicion = this.datosEdicion.indexOf(item)
        this.actualizarItemTabla(this.datosEdicion[posicion], dato)
      })
    },

    actualizarItemTabla(itemActual, nuevoItem) {
      for (let propiedad in itemActual) {
        itemActual[propiedad] = nuevoItem[propiedad]
      }
    },
  },
}
</script>

<style scoped>
.table-icon {
  font-weight: 700;
  margin: 0 10px;
  color: #2a93d5;
  font-size: 0.95rem;
}
.table thead th {
  width: 20%;
}
</style>
