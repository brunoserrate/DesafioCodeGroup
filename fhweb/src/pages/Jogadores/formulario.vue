<template>
    <div>
        <q-form class="q-gutter-md">
            <q-input
                filled
                v-model="form.nome"
                label="Nome"
                lazy-rules
                :rules="[val => !!val || 'Campo obrigatório']"
            />
            <!-- Dropdown -->
            <q-select
                filled
                v-model="form.posicao_id"
                :options="posicoes"
                type="number"
                label="Posição"
                option-value="id"
                option-label="nome"
                emit-value
                map-options

                lazy-rules
                :rules="[val => !!val || 'Campo obrigatório']"
            />
            <q-input
                filled
                v-model="form.nivel"
                label="Nível"
                lazy-rules
                :rules="[val => !!val || 'Campo obrigatório']"
            />
            <q-card-actions align="right">
                <q-btn
                    flat
                    label="Cancelar"
                    @click="$emit('cancelar')"
                />
                <q-btn
                    color="primary"
                    label="Salvar"
                    @click="incluirRegistro"
                />
            </q-card-actions>
        </q-form>
    </div>
</template>

<script>

export default {
    name: 'JogadoresFormulario',
    props: {
        form: {
            type: Object,
            required: false
        },
        operacao: {
            type: String,
            required: false
        }
    },
    data() {
        return {
            posicoes: [],
            posicao_id: null
        }
    },
    mounted() {
        this.carregarPosicoes()
    },
    methods: {
        carregarPosicoes() {
            let that = this

            that.$axios.get(that.$_pathAPI + '/posicao_time')
                .then(function (response) {

                    that.posicoes = response.data.data
                })
                .catch(function (error) {
                    console.log(error)
                })
        },
        salvarRegistro(){
            if (this.operacao == 'incluir') {
                this.incluirRegistro()
            } else {
                this.editarRegistro()
            }
        },
        editarRegistro(){
            let that = this

            let params = {
                nome: that.form.nome,
                posicao_time_id: that.form.posicao_id.value,
                nivel: that.form.nivel
            }

            console.log(params)

            that.$axios.put(that.$_pathAPI + '/jogador/' + that.form.id, params)
                .then(function (response) {
                    that.$emit('cancelar')
                })
                .catch(function (error) {
                    console.log(error)
                })
        },
        incluirRegistro() {
            let that = this

            let params = {
                nome: that.form.nome,
                posicao_time_id: that.form.posicao_id.value,
                nivel: that.form.nivel
            }

            that.$axios.post(that.$_pathAPI + '/jogador', params)
                .then(function (response) {
                    that.$emit('cancelar')
                })
                .catch(function (error) {
                    console.log(error)
                })
        }

    }
}

</script>