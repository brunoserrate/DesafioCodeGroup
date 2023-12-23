<template>
    <q-drawer v-model="leftDrawerOpen" show-if-above bordered>
        <q-list>
            <!-- <q-item-label header> -->
                <!-- Menu -->
            <!-- </q-item-label> -->

            <MainMenuItem v-for="menu in menuListConst" :key="menu.menu" v-bind="menu" />
            
        </q-list>
    </q-drawer>
</template>

<script>
import MainMenuItem from 'components/MainMenuItem.vue'
export default {
    name: 'Drawer',
    props: {
        view: {
            type: Boolean
        }
    },
    data() {
        return {
            leftDrawerOpen: false,
            menuListConst: [
                {
                    menu: 'Jogadores',
                    icon: 'people',
                    caption: '',
                    link: '/jogadores',
                    submenus: []
                },
                {
                    menu: 'Partidas',
                    icon: 'sticky_note_2',
                    caption: '',
                    link: '/partidas',
                    submenus: [],
                },
            ],
            leftDrawerOpen: this.view
        }
    },
    components: {
        MainMenuItem
    },
    mounted() {

    },
    watch: {
        view() {
            this.leftDrawerOpen = this.view
        }
    }

}
</script>
  
<style lang="scss" scoped>

.drawer {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
</style>