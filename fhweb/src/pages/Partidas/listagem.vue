<template>
    <div>
        <div class="row q-pa-md">
            <div class="col-12 q-gutter-md">
                <div class="text-caption">Aqui você pode gerenciar as partidas cadastradas no sistema.</div>
            </div>
        </div>
        <div class="row q-pa-md justify-end">
            <div class="col-2">
                <q-btn color="primary" label="Nova partida" @click="incluirPartida" />
            </div>
        </div>
        <q-card flat>
            <q-table flat bordered :columns="partidas_header" :rows="partidas" row-key="id" v-model:pagination="pagination">
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
                        <q-td key="data_partida" :props="props">
                            {{ formatDate(props.row.data_partida)  }}
                        </q-td>
                        <q-td key="qtd_jogadores_time" :props="props">
                            {{ props.row.qtd_jogadores_time }}
                        </q-td>
                        <q-td key="times_gerados" :props="props">
                            {{ props.row.times_gerados }}
                        </q-td>
                        <q-td key="actions" :props="props">
                            <!-- <q-icon name="edit" class="icon icon-edit" @click="editarPartida(props.row)" /> -->
                            <q-icon name="delete" class="icon"
                                @click="partida_id = `${props.row.id}`, deletar_partida = true" />
                        </q-td>
                    </q-tr>
                </template>
            </q-table>
        </q-card>
    </div>
    <q-dialog v-model="deletar_partida" persistent transition-show="scale" transition-hide="scale">
        <q-card class="bg-primary text-white text-center" style="box-shadow:none">
            <q-card-section class="pb-3 card-section-title">
                <div class="text-h6">Cancelar partida</div>
            </q-card-section>
            <q-card-section class="q-pt-none card-confirmacao">
                Você deseja mesmo cancelar essa partida?
            </q-card-section>

            <q-card-actions align="center" class="bg-white text-primary botoes">
                <q-btn unelevated label="FECHAR" color="primary" v-close-popup /> <q-btn flat label="SIM"
                    @click="cancelarPartida" :loading="loading" />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script>
import { date } from 'quasar'

export default {
    name: 'PartidasListagem',
    data() {
        return {
            partidas_header: [
                { name: 'nome', label: 'Nome', field: 'nome', sortable: true, align: 'center', required: false, },
                { name: 'data_partida', label: 'Dt. Partida', field: 'data_partida', sortable: true, align: 'center' },
                { name: 'qtd_jogadores_time', label: 'Qtd. jogadores por time', field: 'qtd_jogadores_time', align: 'center' },
                { name: 'times_gerados', label: 'Times gerados', field: 'times_gerados', align: 'center' },
                { name: 'actions', label: '', field: 'actions', align: 'center' },
            ],
            partidas: [
            ],
            pagination: {
                rowsPerPage: 5
            },
            deletar_partida: false,
            loading: false,
            partida_id: null
        }
    },
    components: {
    },
    mounted() {
        this.carregarPartidas()
    },
    methods: {
        carregarPartidas() {
            let that = this

            that.$axios.get(that.$_pathAPI + '/partida')
                .then(function (response) {
                    that.partidas = response.data.data
                })
                .catch(function (error) {
                    console.log(error)
                })
        },
        formatDate(rawDate) {
            if (!rawDate) return ''
            // 2023-12-27T12:05:00.000000Z
            let y, m, d, h, min, s

            y = rawDate.substring(0, 4)
            m = rawDate.substring(5, 7)
            d = rawDate.substring(8, 10)
            h = rawDate.substring(11, 13)
            min = rawDate.substring(14, 16)
            s = rawDate.substring(17, 19)

            return `${d}/${m}/${y} ${h}:${min}`
        },
        incluirPartida() {
            this.$emit('incluir')
        },
        editarPartida(partida) {
            this.$emit('editar', partida)
        },
        cancelarPartida() {
            let that = this

            that.loading = true

            that.$axios.delete(that.$_pathAPI + '/partida/' + that.partida_id)
                .then(function (response) {
                    that.loading = false
                    that.deletar_jogador = false

                    that.jogador_id = null

                    that.carregarPartidas()
                })
                .catch(function (error) {
                    console.log(error)
                })

            this.deletar_jogador = false
        }
    }

}
</script>

<style lang="scss" scoped>
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