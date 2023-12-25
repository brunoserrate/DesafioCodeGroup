<template>
    <div>
        <div class="row">
            <div class="col">
                <q-input v-model="form.nome" label="Nome" />
            </div>
            <div class="col">
                <q-input filled v-model="form.data_partida" mask="date" :rules="['date']">
                    <template v-slot:append>
                        <q-icon name="event" class="cursor-pointer">
                            <q-popup-proxy cover transition-show="scale" transition-hide="scale">
                                <q-date v-model="form.data_partida">
                                    <div class="row items-center justify-end">
                                        <q-btn v-close-popup label="Close" color="primary" flat />
                                    </div>
                                </q-date>
                            </q-popup-proxy>
                        </q-icon>
                    </template>
                </q-input>
            </div>
            <div class="col">
                <q-input v-model="form.qtd_jogadores_time" label="Jogadores por time" type="number" />
            </div>
        </div>

        <div class="row">
            <div class="col">
                <q-select filled v-model="jogadores_confirmados" :options="jogadores" label="Jogadores disponiveis" multiple
                    option-value="id" option-label="nome_posicao" map-options />
            </div>
        </div>

        <div class="row">
            <div class="col">
                <q-card-actions align="right">
                    <q-btn color="primary" label="Gerar times" @click="gerarTimes(false)" />
                    <q-btn color="primary q-ml-md" label="Gerar com todos jogadores" @click="gerarTimes(true)" />
                </q-card-actions>
            </div>
        </div>

        <div class="row" v-if="times.length > 0">
            <div class="col">
                <q-card flat>
                    <q-table flat bordered :columns="times_header" :rows="times" row-key="id"
                        v-model:pagination="pagination">
                        <template v-slot:header="props">
                            <q-tr :props="props">
                                <q-th v-for="col in props.cols" :key="col.name" :props="props" class="text-bold">
                                    {{ col.label }}
                                </q-th>
                            </q-tr>
                        </template>
                        <template v-slot:body="props">
                            <q-tr :props="props">
                                <q-td key="nome" :props="props">
                                    {{ props.row.nome }}
                                </q-td>
                                <q-td key="qtd_jogadores" :props="props">
                                    {{ props.row.qtd_jogadores }}
                                </q-td>
                                <q-td key="actions" :props="props">
                                    <q-icon name="edit" class="icon icon-edit" @click="editarTime(props.row)" />
                                </q-td>
                            </q-tr>
                        </template>
                    </q-table>
                </q-card>
            </div>
        </div>

        <div class="row" v-if="times.length > 0">
            <div class="col">
                <q-card-actions align="right">
                    <q-btn color="primary" label="Salvar" @click="salvarRegistro" />
                </q-card-actions>
            </div>
        </div>
    </div>
    <q-dialog v-model="editar_time" persistent transition-show="scale" transition-hide="scale">
        <q-card class="text-center" style="box-shadow:none">
            <q-card-section class="pb-3 card-section-title">
                <div class="text-h6">editar time</div>
            </q-card-section>
            <q-card-section class="q-pt-none card-confirmacao">
                <div class="row">
                    <div class="col">
                        <q-input v-model="form_time.nome" label="Nome" />
                    </div>
                    <div class="col">
                        <q-input v-model="form_time.qtd_jogadores" disabled label="Jogadores" type="number" />
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <q-table title="Jogadores" :rows="form_time.jogadores" :columns="jogadores_header" row-key="id" />
                    </div>
                </div>
            </q-card-section>

            <q-card-actions align="center" class="bg-white text-primary">
                <q-btn unelevated label="FECHAR" color="primary" v-close-popup /> <q-btn flat label="Salvar"
                    @click="salvarTime" :loading="loading" />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script>

export default {
    name: 'PartidasFormulario',
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
            jogadores: [],
            jogadores_confirmados: [],
            times_header: [
                { name: 'nome', label: 'Nome', field: 'nome', sortable: true, align: 'center', required: false, },
                { name: 'qtd_jogadores', label: 'Qtd. jogadores', field: 'qtd_jogadores', align: 'center' },
                { name: 'actions', label: '', field: 'actions', align: 'center' },
            ],
            times: [],
            form_time: {
                nome: '',
                nome_original: '',
                qtd_jogadores: 0
            },
            jogadores_header: [
                { name: 'nome', label: 'Nome', field: 'nome', sortable: true, align: 'center', required: false, },
                { name: 'posicao_time_nome', label: 'Posicao', field: 'posicao_time_nome', align: 'center' },
            ],
            editar_time: false,
            loading: false
        }
    },
    mounted() {
        this.carregarJogadores()
    },
    methods: {
        carregarJogadores() {
            let that = this

            that.$axios.get(that.$_pathAPI + '/jogador')
                .then(function (response) {
                    let jogadores = []

                    response.data.data.forEach(jogador => {
                        jogadores.push({
                            id: jogador.id,
                            nome_posicao: jogador.nome + ' (' + jogador.posicao_time_nome + ')',
                            nome: jogador.nome,
                            posicao_time_id: jogador.posicao_time_id,
                            posicao_time_nome: jogador.posicao_time_nome,
                            nivel: jogador.nivel
                        })
                    })

                    that.jogadores = jogadores
                })
                .catch(function (error) {
                    console.log(error)
                })
        },
        gerarTimes(gerarComTodosJogadores) {
            let that = this

            let jogadoresConfirmados = that.jogadores_confirmados;

            if (gerarComTodosJogadores) {
                jogadoresConfirmados = that.jogadores
            }

            if (jogadoresConfirmados.length < 6) {
                that.$q.notify({
                    message: 'Selecione pelo menos 6 jogadores',
                    color: 'red-5',
                    textColor: 'white',
                    icon: 'warning',
                    position: 'top',
                    timeout: 2000
                })
                return
            }

            if (jogadoresConfirmados.length < (that.form.qtd_jogadores_time * 2)) {
                that.$q.notify({
                    message: 'Selecione mais jogadores (' + ((that.form.qtd_jogadores_time * 2) - that.jogadoresConfirmados.length) + ')',
                    color: 'red-5',
                    textColor: 'white',
                    icon: 'warning',
                    position: 'top',
                    timeout: 2000
                })
                return
            }

            let countGoleiros = 0

            jogadoresConfirmados.forEach(jogador => {
                if (jogador.posicao_time_id == 1) {
                    countGoleiros++
                }
            })

            if (countGoleiros < 2) {
                that.$q.notify({
                    message: 'Selecione pelo menos 2 goleiros',
                    color: 'red-5',
                    textColor: 'white',
                    icon: 'warning',
                    position: 'top',
                    timeout: 2000
                })
                return
            }

            that.times = [];

            let params = {
                jogadores: jogadoresConfirmados,
                qtd_jogadores_time: that.form.qtd_jogadores_time
            }

            that.$axios.post(that.$_pathAPI + '/partida/gerar-times', params)
                .then(function (response) {
                    that.times = response.data.data
                })
                .catch(function (error) {
                    console.log(error)
                })

        },
        salvarRegistro() {
            if (this.operacao == 'incluir') {
                this.incluirRegistro()
            } else {
                this.editarRegistro()
            }
        },
        editarRegistro() {
            let that = this

            let params = {
                nome: that.form.nome,
                posicao_time_id: that.form.posicao_id.value,
                nivel: that.form.nivel
            }

            that.$axios.put(that.$_pathAPI + '/partida/' + that.form.id, params)
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
                data_partida: that.form.data_partida,
                qtd_jogadores_time: that.form.qtd_jogadores_time,
                times: that.times
            }

            that.$axios.post(that.$_pathAPI + '/partida', params)
                .then(function (response) {
                    that.$q.notify({
                        message: 'Partida incluida com sucesso',
                        color: 'green-5',
                        textColor: 'white',
                        icon: 'done',
                        position: 'top',
                        timeout: 2000
                    })
                    that.$emit('cancelar')

                })
                .catch(function (error) {
                    console.log(error)
                })
        },
        editarTime(time) {
            this.form_time = {
                nome: time.nome,
                nome_original: time.nome,
                qtd_jogadores: time.qtd_jogadores,
                jogadores: time.jogadores
            }

            this.editar_time = true

        },
        cancelarEditarTime() {
            this.editar_time = false

            this.form_time = {
                nome: '',
                qtd_jogadores: 0
            }
        },
        salvarTime() {
            let that = this

            that.times.forEach(time => {
                if (time.nome == that.form_time.nome_original) {
                    time.nome = that.form_time.nome
                    time.qtd_jogadores = that.form_time.qtd_jogadores
                    time.jogadores = that.form_time.jogadores
                }
            })

            that.editar_time = false

        }

    }
}

</script>

<style lang="scss">
.icon {
    font-size: 17px;
    color: #1c1c1c;
    background-color: #c2c1c1;
    padding: 8px;
    border-radius: 5px;
    margin: 0 3px;
    cursor: pointer;
    transition: background-color 0.3s ease;

    &:hover {
        background-color: #a0a0a0;
    }
}
</style>