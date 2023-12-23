<template>
  <q-layout view="hHh LpR fFf">
    <q-header elevated>
      <q-toolbar>
        <q-btn flat dense round icon="menu" aria-label="Menu" @click="toggleLeftDrawer" />

        <q-toolbar-title>
          Futebol Hub
        </q-toolbar-title>

        <q-btn flat dense round icon="logout" aria-label="Logout" @click="logout" />

      </q-toolbar>
    </q-header>

    <Drawer :view="leftDrawerOpen" />

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
import MainMenuItem from 'components/MainMenuItem.vue'
import Drawer from 'components/Drawer.vue'


export default {
  name: 'MainLayout',
  data() {
    return {
      leftDrawerOpen: true,
    }
  },
  components: {
    MainMenuItem,
    Drawer
  },
  methods: {
    toggleLeftDrawer() {
      this.leftDrawerOpen = !this.leftDrawerOpen
    },
    logout() {
      let that = this

      let user = that.$q.sessionStorage.getItem('auth')

      that.$axios.post(that.$_pathWeb + '/logout', user)
        .then((res) => {
          // console.log(res)
          that.$q.sessionStorage.remove('auth')

          that.$router.push({ path: '/login' })
        })
        .catch((err) => {
          // console.log(err.response)
        })
    }
  },
  mounted() {

  }
}

</script>
