<template>
    <div style="margin-top:25px;">
        <div class="row">
            <div class="col-md-5">
            <div class="form-group">
                <label for="fecha_inicio" class="custom-label">Fecha de Inicio</label>
                <input
                type="date"
                name="fecha_inicio"
                v-model="fecha_inicio"
                class="form-control custom-control"
                >
            </div>
            </div>
            <div class="col-md-5">
            <div class="form-group">
                <label for="fecha_fin" class="custom-label">Fecha de Fin</label>
                <input
                type="date"
                name="fecha_fin"
                v-model="fecha_fin"
                class="form-control custom-control"
                >
            </div>
            </div>
            <div class="col-md-2 pt-4 text-center">
            <button
                class="btn btn-outline-secondary default btn-xs mt-2 w-100"
                @click="filtrarIndicadores(fecha_inicio,fecha_fin)"
            >
                <i class="iconsmind-Search-People"></i> Filtrar
            </button>
            </div>
        </div>
        <section  v-if="renderizarContenido">
        <div class="row pt-4">
            <div class="col-md-6" v-for="(indicador, index) in Indicadores" :key="`${index}-grafica`">
                <torta
                    v-if="indicador.Tipo=='simple'||indicador.Tipo=='simple-dos'"
                    :datos="indicador.Respuestas"
                    :pregunta="indicador.Pregunta"
                    graficaCategoria="Respuesta"
                    graficaValor="Cantidad"
                    ref="grafica"

                ></torta>
            </div>
        </div>
        </section>
        <overlay v-else></overlay>

    </div>
</template>

<script>
am4core.useTheme(am4themes_animated)
import Torta from '../graficas/torta'
import Overlay from '../../utiles/Overlay'
export default {
    components: { Overlay, 'torta': Torta },
    props: {
        encuesta: Number
    },
    data() {
        return {
            fecha_inicio: moment().format(moment.HTML5_FMT.DATE),
            fecha_fin: moment().format(moment.HTML5_FMT.DATE),
            Indicadores: [],
            renderizarContenido : false
        }
    },
    created() {
        this.cargarIndicadores(this.fecha_inicio, this.fecha_fin)
    },
    methods: {
        cargarIndicadores(fechaInicio, fechaFin) {
        axios
            .get(`/api/${localStorage.getItem('tenant')}/encuestas/indicadores/${this.encuesta}/${fechaInicio}/${fechaFin}`)
            .then(datos => {
                this.Indicadores = datos.data;
                this.renderizarContenido = true;
            })
        },
        filtrarIndicadores(fechaInicio, fechaFin) {
        axios
            .get(`/api/${localStorage.getItem('tenant')}/encuestas/indicadores/${this.encuesta}/${fechaInicio}/${fechaFin}`)
            .then(datos => {
                this.Indicadores = datos.data;
                this.renderizarContenido = true;
            })
        }
    }

}
</script>

<style>

</style>
