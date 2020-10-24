<template>
  <transition name="fade">
    <div class="sidebar" v-if="sidebarVisible">
      <div class="main-menu" :class="{shadow: !submenu}">
        <vue-custom-scrollbar class="scroll-area" :settings="settings">
          <ul class="list-unstyled">
            <li :class="{active: active === 'Tablero'}" @click="setDefault">
              <router-link to="/tablero">
                <i class="iconsmind-Shop-4"></i> Tablero
              </router-link>
            </li>
            <li
              v-for="(item,index) in menuItems"
              :key="index"
              :class="{active: item.item === active}"
            >
              <a
                href="#"
                @click.prevent="mostrarSubmenu(item.item)"
                @dblclick.prevent="submenu = false"
              >
                <i :class="item.icon"></i>
                {{item.item}}
              </a>
            </li>
          </ul>
        </vue-custom-scrollbar>
      </div>

      <transition
        name="custom-classes-transition"
        enter-active-class="animated slideInLeft faster"
        leave-active-class="animated slideOutLeft faster"
      >
        <div class="sub-menu" v-if="submenu">
          <div class>
            <ul class="list-unstyled" v-for="(subItem, index) in submenuItems" :key="index">
              <template v-if="active === subItem.item">
                <li
                  v-for="(item, index) in subItem.listItems"
                  :key="`${index}-A`"
                  @click="submenu = false"
                >
                  <router-link :to="item.url">
                    <i :class="item.icon"></i>
                    {{item.item}}
                  </router-link>
                </li>
              </template>
            </ul>
          </div>
        </div>
      </transition>

    </div>

  </transition>

</template>

<script>
import menuSidebar from './MenuSidebar'
import vueCustomScrollbar from 'vue-custom-scrollbar'

export default {
  components: { vueCustomScrollbar },
  data() {
    return {
      submenu: false,
      menuItems: [],
      submenuItems: [],
      active: 'Tablero',
      sidebarVisible: true,
      settings: {
        maxScrollbarLength: 60,
      },
    }
  },
  created() {
    this.menuItems = menuSidebar.menuItems
    this.submenuItems = menuSidebar.submenuItems
    eventEmitter.$on('ocultarSidebar', () => {
      this.sidebarVisible = !this.sidebarVisible
    })
  },
  methods: {
    mostrarSubmenu(target) {
      this.submenu = true
      this.active = target
    },
    setDefault() {
      this.submenu = false
      this.active = 'Tablero'
    },
  },
}
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter,
.fade-leave-to {
  opacity: 0;
}
.shadow {
  box-shadow: 0 3px 30px rgba(0, 0, 0, 0.1), 0 3px 20px rgba(0, 0, 0, 0.1);
}
.scroll-area {
  position: relative;
  margin: auto;
  width: inherit;
  height: 90vh;
}
</style>
