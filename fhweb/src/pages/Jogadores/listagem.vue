<template>
  <div>
    <div class="row q-pa-md">
      <div class="col-12 q-gutter-md">
        <div class="text-caption">Aqui você pode gerenciar os jogadores cadastrados no sistema.</div>
      </div>
    </div>
    <div class="row q-pa-md justify-end">
      <div class="col-2">
        <q-btn color="primary"
         label="Novo jogador" @click="incluirJogador"/>
      </div>
    </div>
    <q-card flat>
      <q-table flat bordered :columns="jogadores_header" :rows="jogadores" row-key="id" v-model:pagination="pagination">
        <template v-slot:header="props">
          <q-tr :props="props">
            <q-th v-for="col in props.cols" :key="col.name" :props="props" class="text-bold">
              {{ col.label }}
            </q-th>
          </q-tr>
        </template>
        <template v-slot:body="props">
          <q-tr :props="props" @click="onRowClick(props.row)">
            <q-td key="nome" :props="props">
              {{ props.row.nome }}
            </q-td>
            <q-td key="posicao" :props="props">
              {{ props.row.posicao_time_nome }}
            </q-td>
            <q-td key="nivel" :props="props">
              {{ props.row.nivel }}
            </q-td>
            <q-td key="actions" :props="props">
              <q-icon name="edit" class="icon icon-edit" @click="toEdit(props.row.id)" />
              <q-icon name="delete" class="icon icon-delete"
                @click="cliente_id = `${props.row.id}`, deletar_jogador = true" />
            </q-td>
          </q-tr>
        </template>
      </q-table>
    </q-card>
  </div>
  <q-dialog v-model="deletar_jogador" persistent transition-show="scale" transition-hide="scale">
    <q-card class="bg-primary text-white text-center" style="box-shadow:none">
      <q-card-section class="pb-3 card-section-title">
        <div class="text-h6">Deletar jogador</div>
      </q-card-section>
      <q-card-section class="q-pt-none card-confirmacao">
        Você deseja mesmo deletar esse jogador?
      </q-card-section>

      <q-card-actions align="center" class="bg-white text-primary botoes">
        <q-btn unelevated label="FECHAR" color="primary" v-close-popup /> <q-btn flat label="SIM" @click="deletarJogador"
          :loading="loading" />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script>
export default {
  name: 'JogaodresListagem',
  data() {
    return {
      jogadores_header: [
        { name: 'nome', label: 'Nome', field: 'nome', sortable: true, align: 'center', required: false, },
        { name: 'posicao', label: 'Posicão', field: 'posicao_time_nome', sortable: true, align: 'center' },
        { name: 'nivel', label: 'Nível', field: 'nivel', align: 'center' },
        { name: 'actions', label: '', field: 'actions', align: 'center' },
      ],
      jogadores: [
      ],
      pagination: {
        rowsPerPage: 5
      },
      deletar_jogador: false,
      loading: false,
      cliente_id: null
    }
  },
  components: {
  },
  mounted() {
    this.carregarJogadores()
  },
  methods: {
    carregarJogadores() {
      let that = this

      that.$axios.get(that.$_pathAPI + '/jogador')
        .then(function (response) {
          that.jogadores = response.data.data
        })
        .catch(function (error) {
          console.log(error)
        })
    },
    incluirJogador() {
      this.$emit('incluir')
    },
    editarJogador(jogador) {
      this.$emit('editar', jogador)
    },
    deletarJogador() {
      try {
        this.deletar_jogador = false
      } catch (error) {

      }
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

.icon-delete {}
</style>