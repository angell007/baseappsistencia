<template>
  <div class="col-md-2 col-xs-12 mb-2">
    <div class="card">
      <div class="card-body text-center" style="padding:10px;">
        <i :class="icon"></i>
        <p class="card-text mb-0">
          <slot></slot>
        </p>
        <p v-if="concepto > 0" class="lead card-item-nomina text-center">{{concepto | moneda}}</p>
        <p v-else class="lead card-item-nomina text-center">$0</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: { concepto: [Number, String], icon: String },
}
</script>

<style scoped>
.card-item-nomina {
  font-family: 'Lato', sans-serif;
  font-size: 1.0rem;
}
.card i {
  font-size: 36px;
  line-height: 66px;
  color: #4bb1f0;
}
</style>
