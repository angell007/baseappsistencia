<template>
  <div class="container">
    <div class="row">
      <div class="col-12 list">
        <div class="mb-2">
          <h1 class="font-weight-bold">Turnos de la compañía</h1>

          <ul
            class="nav nav-tabs separator-tabs ml-0 mb-5"
            role="tablist"
            style="justify-content: center"
          >
            <li class="nav-item">
              <a
                class="nav-link active show"
                id="first-tab"
                data-toggle="tab"
                href="#first"
                role="tab"
                aria-controls="first"
                aria-selected="false"
              >Turnos fijos</a>
            </li>

            <li class="nav-item">
              <a
                class="nav-link"
                id="second-tab"
                data-toggle="tab"
                href="#second"
                role="tab"
                aria-controls="second"
                aria-selected="true"
              >Turnos Rotativos</a>
            </li>
          </ul>

          <div class="tab-content">
            <div
              class="tab-pane fade active show"
              id="first"
              role="tabpanel"
              aria-labelledby="first-tab"
            >
              <div class="row">
                <div class="col-12 list">
                  <turno-fijo></turno-fijo>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="second" role="tabpanel" aria-labelledby="second-tab">
              <div class="row">
                <div class="col-12">
                  <turno-rotativo></turno-rotativo>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import TurnoRotativo from './TurnoRotativo'
import TurnoFijo from './TurnoFijo'

export default {
  components: { TurnoRotativo, TurnoFijo },
}
</script>
