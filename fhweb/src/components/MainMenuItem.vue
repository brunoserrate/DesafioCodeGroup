<template>
    <div>
        <q-expansion-item
            v-if="submenus.length > 0"
            :label="menu"
            :icon="icon"
            :expand-separator="true"
            :content-inset-level="0.25"
        >

            <q-item
                v-for="submenu in submenus"
                :key="submenu.title"
                clickable
                :to="submenu.link"
            >
                <q-item-section
                    v-if="submenu.icon"
                    avatar
                >
                    <q-icon :name="submenu.icon" class="icon"/>
                </q-item-section>
                <q-item-section>
                    <q-item-label>{{ submenu.title }}</q-item-label>
                    <q-item-label caption>{{ submenu.caption }}</q-item-label>
                </q-item-section>
            </q-item>
        </q-expansion-item>

        <q-item
            v-else
            clickable
            tag="a"
            :to="link"
        >
            <q-item-section
                v-if="icon"
                avatar
            >
                <q-icon :name="icon" />
            </q-item-section>

            <q-item-section>
                <q-item-label>{{ menu }}</q-item-label>
                <q-item-label caption>{{ caption }}</q-item-label>
            </q-item-section>
        </q-item>

    </div>
</template>

<script>
import { defineComponent } from 'vue'

export default defineComponent({
    name: 'MainMenuItem',
    props: {
        menu: {
            type: String,
            required: true
        },

        icon: {
            type: String,
            default: ''
        },

        caption: {
            type: String,
            default: ''
        },

        link: {
            type: String,
            default: '#'
        },

        submenus: {
            type: Array,
            required: true
        }
    }
})

</script>

<style lang="scss" scoped>
</style>