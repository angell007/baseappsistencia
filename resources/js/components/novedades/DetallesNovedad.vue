<template>
  <div class="container-fluid" v-if="estadoActivo">
    <table class="table table-sm table-bordered">
      <thead>
        <tr>
          <th class="text-center">Fecha de reporte</th>
          <th class="text-center">Novedad</th>
          <th class="text-center">Observaciones</th>
          <th class="text-center">Fecha de inicio</th>
          <th class="text-center">Fecha de fin</th>
          <th class="text-center">Acciones</th>
        </tr>
      </thead>

      <tbody>
        <tr>
          <td class="text-center custom-label">{{formatoDeFecha(detalle.created_at)}}</td>
          <td class="text-center custom-label">{{detalle.novedad.concepto}}</td>
          <td class="text-center custom-label">{{detalle.observacion || 'Ninguna'}}</td>
          <td class="text-center custom-label">{{formatoDeFecha(detalle.fecha_inicio)}}</td>
          <td class="text-center custom-label">{{formatoDeFecha(detalle.fecha_fin)}}</td>
          <td class="text-center">
            <button
              class="btn btn-link btn-xs dropdown-toggle"
              type="button"
              data-toggle="dropdown"
            >Ver</button>
            <div class="dropdown-menu">
              <a
                class="dropdown-item font-weight-bold text-center"
                href="#"
                @click.prevent="editarNovedad"
              >Editar</a>
              <a
                class="dropdown-item font-weight-bold text-center"
                href="#"
                @click.prevent="eliminarNovedad"
              >Eliminar</a>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  props: {
    detalle: Object,
  },

  data() {
    return {
      estadoActivo: false,
      novedadDetalle: this.detalle,
      nombresNovedadesDatos: [],
    }
  },
  methods: {
    formatoDeFecha(fecha) {
      let nueva = moment(fecha).format('DD/MM/YYYY')
      return nueva
    },

    editarNovedad() {
      this.$emit('editar', this.detalle.id)
    },

    eliminarNovedad() {
      this.$emit('eliminar', this.detalle.id)
    },
  },
}
</script>

<style scoped>
th,
td {
  font-size: 13px;
}
.dropdown-menu {
  min-width: 8rem;
}
</style>
