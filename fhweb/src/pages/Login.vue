<template>
    <q-page class="flex flex-center bg-grey-5 login">
        <q-card class="bg-grey-2 card-login" flat>
            <q-card-title>
                <div class="row row-card-title pb-4">
                    <div class="col-12 d-flex justify-content-center">
                        <p>Futebol <span>Hub</span></p>
                    </div>
                    <div class="col-12 subtitle d-flex justify-content-center">
                        Seja bem-vindo de volta! Faça o seu login para continuar
                    </div>
                </div>
            </q-card-title>

            <q-card-main>
                <div class="row gutter-lg q-mb-md">
                    <div class="col-12 username">
                        <q-input v-model="form.username" label="E-mail" filled @keyup.enter="autenticar" class="inputs" color="transparent" label-color="primary" />
                    </div>
                </div>
                <div class="row gutter-lg q-mb-md">
                    <div class="col-12 password">
                        <q-input v-model="form.password" label="Senha" type="password" filled @keyup.enter="autenticar" class="inputs" color="transparent" label-color="primary"/>
                    </div>
                </div>
                <div class="row gutter-lg pt-4">
                    <div class="col-12 column items-center">
                        <q-btn color="primary" label="Entrar" unelevated @click="autenticar" :loading="autenticando" class="botao-entrar"/>
                    </div>
                </div>
            </q-card-main>
        </q-card>
    </q-page>
</template>

<script>
import { defineComponent } from 'vue'

export default defineComponent({
    name: 'IndexPage',
    data() {
        return {
            form: {
                username: '',
                password: ''
            },
            autenticando: false
        }
    },
    methods: {
        autenticar() {
            let that = this

            let params = {
                email: this.form.username,
                password: this.form.password
            }

            that.$axios.post(that.$_pathWeb + '/login', params)
                .then(function (response) {

                    that.$q.sessionStorage.set('auth', JSON.stringify( response.data.data ))

                    that.$q.notify({
                        color: 'positive',
                        message: 'Login efetuado com sucesso!',
                        position: 'top'
                    })
                    that.$router.push({ path: '/' , replace: true})

                    // console.log("Logado")
                })
                .catch(function (error) {
                    that.$q.notify({
                        color: 'negative',
                        message: 'Usuário ou senha inválidos!',
                        position: 'top'
                    })

                    // console.log(error)
                })
        }
    }
})
</script>
<style lang="scss" scoped>
    @import '../css/pages/Login.scss'
</style>