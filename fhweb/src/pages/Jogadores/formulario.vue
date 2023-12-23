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
                label="Posição"
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
        }
    },
    data() {
        return {
            posicoes: []
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

                    that.posicoes = []

                    response.data.data.forEach(posicao => {
                        that.posicoes.push({
                            label: posicao.nome,
                            value: posicao.id
                        })
                    });
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