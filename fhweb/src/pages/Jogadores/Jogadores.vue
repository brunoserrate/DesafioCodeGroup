<template>
    <q-page>
        <q-toolbar>
            <q-btn flat round dense icon="arrow_back" @click="$router.push('/')">
                <q-tooltip>Retornar</q-tooltip>
            </q-btn>
            <q-toolbar-title>
                Jogadores
            </q-toolbar-title>

          </q-toolbar>


        <listagem
          v-if="operacao == 'listagem'"
          @editar="editar"
          @incluir="incluir"
        />

        <formulario
          v-else
          :form="form"
          @cancelar="cancelar"
        />


    </q-page>
</template>

<script>
import Listagem from './listagem.vue'
import Formulario from './formulario.vue'

export default {
  name: 'Jogadores',
  data() {
    return {
      form: {
        nome: '',
        posicao: '',
        nivel: '',
      },
      operacao: 'listagem'
    }
  },
  components: {
    Listagem,
    Formulario
  },
  mounted() {
  },
  methods: {
    editar(jogador) {
      this.form = jogador

      this.operacao = 'edicao'
    },
    cancelar() {
      this.operacao = 'listagem'
    },
    incluir() {
      this.operacao = 'incluir'
      this.form = {
        nome: '',
        posicao: '',
        nivel: '',
      }
    }
  }
}

</script>