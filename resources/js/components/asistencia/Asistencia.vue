<template>
    <div style="width:100%;height:100%;">
        <div v-show="vista" id="asistencia" class="container-fluid" style="height:100%;">
            <div class="card-border-asistencia">
                <video ref="video" id="video-asistencia" width="100%" height="100%" autoplay></video>
            </div>
            <div class="logo-border-asistencia">
                <div class="logo-asistencia">

                </div>
                <div class="indicadores-asistencia">
                    <div class="temperatura-asistencia">
                        <h1 class="detalle-temperatura"><i class="iconsmind-Celsius"></i> {{temp}}</h1>
                    </div>
                    <div class="hora-asistencia">
                        <h1 class="detalle-hora"><i class="iconsmind-Clock float-left"></i> {{time}}</h1>
                    </div>
                </div>
            </div>
            <button class="boton-captura" id="snap" v-on:click="capture()"></button>
            <canvas ref="canvas" id="canvas" width="640" height="480"></canvas>
        </div>
        <div v-show="!vista" class="reconocimiento">
            <img class="img-reconocimiento" v-bind:src="'/img/cargando-reconocimiento-geneticapp.gif'"  />
        </div>
    </div>
</template>

<script>
export default {
    name: 'asistencia',
    data() {
        return {
            video: {},
            canvas: {},
            time: moment().format('LTS'),
            vista: true,
            temp : 0.0
        }
    },
    mounted() {
        this.video = this.$refs.video;
        if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ video: true }).then(stream => {
                this.video.srcObject = stream
                this.video.setAttribute('crossorigin', 'anonymous');
                this.video.play();
            }).catch(function(error) {
                alert('No se puede acceder a la Cámara : ' + error.name + " " + error.message);
            });
        }
        setInterval(()=>{
            var precision = 10; // 2 decimals
            this.time = moment().format('LTS');
        },1000)
        
    },
    methods: {
        capture() {
            this.canvas = this.$refs.canvas;
            var context = this.canvas.getContext("2d").drawImage(this.video, 0, 0, 640, 480);
            var img = canvas.toDataURL("image/png");
            this.video.pause();
            this.CambiaVista();
            axios.post(`/api/${localStorage.getItem('tenant')}/asistencia/validar`, { imagen : img, temperatura: this.temp })
                .then(respuesta => {
                    this.CambiaVista();
                    this.$swal.fire(respuesta.data);
                })
                .catch(error => {
                    this.CambiaVista();
                    this.$swal.fire(
                    'Oops!',
                    'Han ocurrido errores, por favor intentar más tarde',
                    'error'
                    )
                })
        },
        CambiaVista(){
            this.vista = !this.vista;
            if(this.vista){
                this.video.play();
            }
        },
        genRand(min, max, decimalPlaces) {
            var rand = Math.random()*(max-min) + min;
            var power = Math.pow(10, decimalPlaces);
            return Math.floor(rand*power) / power;
        }
    },

}
</script>

<style>

</style>
