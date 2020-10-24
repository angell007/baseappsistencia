<template>
    <div class="container" v-if="renderizarTablero">
            <div class="row app-row" style="padding-right:0px;">
               <div class="col-12 chat-app">
                  <div class="d-flex flex-row justify-content-between mb-3 chat-heading-container">
                     <div class="d-flex flex-row chat-heading">
                        <a class="d-flex" href="#">
                            <img alt="Imagen" src="/img/robot.jpg" class="img-thumbnail border-0 rounded-circle ml-0 mr-4 list-thumbnail align-self-center small"></a>
                        <div class="d-flex min-width-zero">
                           <div class="card-body pl-0 align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero">
                              <div class="min-width-zero">
                                 <a href="#">
                                    <p class="list-item-heading mb-1 truncate">{{ticket.cliente}}</p>
                                 </a>
                                 <p class="mb-0 text-muted text-small">{{ticket.tipo}}</p>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="separator mb-5"></div>
                  <div class="scroll">
                     <div class="scroll-content">
                        <div  v-for="(mensaje,index) in mensajes" :key="index">
                            <div class="card d-inline-block mb-3 mr-2" v-bind:class="[mensaje.tipo == 'Cliente' ? 'float-left' : 'float-right']"     >
                            <div class="position-absolute pt-1 pr-2 r-0"><span class="text-extra-small text-muted">{{mensaje.fecha}}</span></div>
                            <div class="card-body">
                                <div class="d-flex flex-row pb-2">

                                    <div class="d-flex flex-grow-1 min-width-zero">
                                        <div class="m-2 pl-0 align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero">
                                        <div class="min-width-zero">
                                            <p class="mb-0 truncate list-item-heading">{{mensaje.persona}}</p>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="chat-text-left">
                                    <p class="mb-0 text-semi-muted">{{mensaje.mensaje}}</p>
                                </div>
                            </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>

<overlay v-else></overlay>
</template>

<script>
import Overlay from '../../utiles/Overlay'
export default {
    components: {
        Overlay
    },
    data() {
        return {
            ticket:{},
            mensajes: [],
            renderizarTablero: false,
        }
    },
    created() {
        this.getAllDatos()
    },
    methods: {
        getAllDatos() {
            axios
                .all([
                this.getDetallesTicket(),
                this.getMensajes()
                ])
                .then(
                axios.spread(
                    (
                    TicketsDatos,
                    MensajesDatos,
                    ) => {

                    this.ticket = TicketsDatos.data[0]
                    this.mensajes = MensajesDatos.data
                    this.renderizarTablero = true
                    console.log(this.ticket);
                    }
                )
                )
        },
        getDetallesTicket() {
            let id= this.$route.params.id
            return axios.get('/api/administrativo/ticket/'+id)
        },
        getMensajes() {
            let id= this.$route.params.id
            return axios.get('/api/administrativo/mensajesticket/'+id)
        }
    }


}
</script>

<style>

</style>
