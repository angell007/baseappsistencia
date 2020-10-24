<template>
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <table class="table table-bordered table-striped table-sm">
          <thead>
            <tr>
              <th style="width:50%">Concepto</th>
              <th class="text-center">Porcentaje para cálculo</th>
              <th class="text-center">Confirmar</th>
            </tr>
          </thead>
          <tbody>
            <slot></slot>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
export default {}
</script>

<style>
</style>
