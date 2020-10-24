<template>
  <div class="modal fade" :id="id" tabindex="-1" role="dialog">
    <div class="modal-dialog" :class="{'modal-lg': esLg}" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            <slot name="titulo"></slot>
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <slot name="contenido"></slot>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: { id: String, esLg: Boolean },
  created() {
    modalEmitter.$on('cerrar', instancia => {
      if (instancia === this.id) {
        this.ocultarModal()
      }
    })
  },
  methods: {
    mostrarModal() {
      let idModal = `#${this.id}`
      $(idModal).modal({
        backdrop: 'static',
        keyboard: false,
      })
    },

    ocultarModal() {
      let idModal = `#${this.id}`
      $(idModal).modal('hide')
    },
  },
}
</script>

<style scoped>
h5.modal-title {
  color: #2a93d5;
  font-weight: bold;
  font-size: 1.25rem;
}
.modal.fade {
  opacity: 1;
}
.modal.fade .modal-dialog {
  -webkit-transform: translate(0);
  -moz-transform: translate(0);
  transform: translate(0);
}
</style>
