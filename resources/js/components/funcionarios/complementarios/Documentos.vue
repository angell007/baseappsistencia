<template>
  <div class="documents" v-if="funcionarioCreado">
    <p class="font-weight-bold">
      <small>Aquí podrá cargar los documentos que requiere tener del funcionario, como su contrato, afiliaciones hoja de vida, etc.</small>
    </p>
    <vue-dropzone
      id="upload"
      :options="getConfig(funcionarioIdentidad)"
      @vdropzone-complete="enCompletado"
    >
      <div class="dropzone-custom-content">
        <h3 class="dropzone-custom-title">Arrastre y agregue los documentos!</h3>
      </div>
    </vue-dropzone>
  </div>
</template>

<script>
import vueDropzone from 'vue2-dropzone'
export default {
  components: { vueDropzone },
  data() {
    return {
      id: '',
      funcionarioIdentidad: '',
      funcionarioCreado: false,
    }
  },

  created() {
    funcionarioEmitter.$on('creado', datos => {
      this.funcionarioCreado = datos.crear
      this.funcionarioIdentidad = datos.identidad
    })
  },

  mounted() {},

  methods: {
    enCompletado(file) {
      console.log(file)
    },
    getConfig(identidad) {
      return {
        url: `/api/funcionarios/${identidad}/documento/crear`,
        dictDefaultMessage: 'Agregar los documentos en esta zona',
        addRemoveLinks: true,
        maxFiles: 4,
        maxFilesize: 3,
        chunkSize: 500,
      }
    },
  },
}
</script>

<style scoped>
</style>
