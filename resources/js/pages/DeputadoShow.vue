<template>
    <div>
        <!-- Cabeçalho -->
        <div class="row mb-3">
            <div class="col-sm-12">
                <div class="profile-user-box">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div class="d-flex align-items-center">
                            <img :src="deputado.url_foto" alt="Foto" class="avatar-xl rounded-circle me-3" />
                            <div>
                                <h4 class="mt-1 mb-1 font-18">{{ deputado.nome }}</h4>
                                <p class="font-13 text-muted mb-0">{{ deputado.sigla_partido }}, {{ deputado.sigla_uf }}</p>
                            </div>
                        </div>
                        <router-link :to="{ name: 'deputados' }" class="btn btn-success rounded-pill waves-effect waves-light d-flex align-items-center">
                            <span class="btn-label"><i class="mdi mdi-arrow-left" data-lucide="arrow-left"></i></span> Voltar para listagem
                        </router-link>
                    </div>
                </div>
            </div>
        </div>

        <!-- Conteúdo -->
        <div class="row">
            <!-- Coluna esquerda -->
            <div class="col-xl-4">
                <!-- Informações Pessoais -->
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mt-0 mb-4">Informações Pessoais</h4>
                        <p><strong>Nome completo:</strong> {{ deputado.nome_civil }}</p>
                        <p><strong>Idade:</strong> {{ idadeDeputado }}</p>
                        <p><strong>Email:</strong> {{ deputado.email }}</p>

                        <p><strong>Profissões:</strong></p>
                        <ul v-if="deputado.profissoes?.length">
                            <li v-for="(prof, i) in deputado.profissoes" :key="i">{{ prof.descricao }}</li>
                        </ul>
                        <p v-else class="text-muted">Nenhuma profissão registrada.</p>

                        <p><strong>Ocupações:</strong></p>
                        <ul v-if="deputado.ocupacoes?.length">
                            <li v-for="(ocup, i) in deputado.ocupacoes" :key="i">
                                {{ ocup.titulo }} <span v-if="ocup.entidade">— {{ ocup.entidade }}</span>
                            </li>
                        </ul>
                        <p v-else class="text-muted">Nenhuma ocupação registrada.</p>
                    </div>
                </div>
                <!-- Outros Deputados do Estado -->
                <div v-if="outrosDeputados.length" class="card">
                    <div class="card-body">
                        <h4 class="header-title mt-0 mb-4">Outros Deputados de {{ deputado.sigla_uf }}</h4>
                        <ul class="list-unstyled mb-0">
                            <li v-for="outro in outrosDeputados" :key="outro.id" class="mb-2">
                                <router-link :to="{ name: 'deputado.show', params: { id: outro.id } }" class="d-flex align-items-center text-decoration-none">
                                    <img :src="outro.url_foto" class="rounded-circle me-2" height="36" width="36" />
                                    <span>{{ outro.nome }}</span>
                                </router-link>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Coluna direita -->
            <div class="col-xl-8">
                <!-- Cards -->
                <div class="row">
                    <div v-for="card in cards" :key="card.label" class="col-md-4">
                        <div class="card widget-box-four">
                            <div class="card-body">
                                <h4 class="mt-0 font-16 mb-1 fw-semibold">{{ card.label }}</h4>
                                <p class="fs-secondary text-muted">Dados calculados</p>
                                <h3 class="mb-0 mt-4 fw-semibold">{{ card.value }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gráfico -->
                <div v-if="pizzaData.length" class="card my-3">
                    <div class="card-body">
                        <h4 class="mb-3">Distribuição por Tipo de Despesa</h4>
                        <div style="height: 300px;">
                            <canvas id="despesaChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Filtro -->
                <div class="row mb-2">
                    <div class="col-md-6">
                        <input v-model="search" class="form-control" placeholder="Buscar por tipo ou fornecedor..." />
                    </div>
                </div>

                <!-- Tabela -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Tipo</th>
                                    <th>Fornecedor</th>
                                    <th>Valor</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="despesa in despesasFiltradas" :key="despesa.id">
                                    <td>{{ formatarData(despesa.data_documento) }}</td>
                                    <td>{{ despesa.tipo_despesa }}</td>
                                    <td>{{ despesa.nome_fornecedor }}</td>
                                    <td>R$ {{ formatarValor(despesa.valor_documento) }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginação -->
                        <div v-if="pagination.last_page > 1" class="d-flex justify-content-center mt-3">
                            <div class="pagination-wrapper">
                                <ul class="pagination mb-0">
                                    <li :class="{ disabled: currentPage === 1 }" class="page-item">
                                        <a class="page-link" @click="changePage(currentPage - 1)">Anterior</a>
                                    </li>

                                    <li
                                        v-for="page in visiblePages"
                                        :key="page"
                                        :class="{ active: page === currentPage }"
                                        class="page-item"
                                    >
                                        <button class="page-link" @click="changePage(page)">{{ page }}</button>
                                    </li>

                                    <li :class="{ disabled: currentPage === pagination.last_page }" class="page-item">
                                        <a class="page-link" @click="changePage(currentPage + 1)">Próximo</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import Chart from 'chart.js/auto';

export default {
    data() {
        return {
            deputado: {},
            idadeDeputado: '',
            despesas: [],
            pizzaData: [],
            pagination: {},
            currentPage: 1,
            totalMes: 0,
            mediaMensal: 0,
            totalAno: 0,
            search: '',
            chart: null,
            outrosDeputados: []
        };
    },
    computed: {
        despesasFiltradas() {
            return this.despesas.filter(d =>
                d.tipo_despesa?.toLowerCase().includes(this.search.toLowerCase()) ||
                d.nome_fornecedor?.toLowerCase().includes(this.search.toLowerCase())
            );
        },
        cards() {
            return [
                { label: 'Total Gasto', value: `R$ ${this.formatarValor(this.totalMes)}` },
                { label: 'Gasto Médio Mensal', value: `R$ ${this.formatarValor(this.mediaMensal)}` },
                { label: 'Transações', value: this.totalAno }
            ];
        }
    },
    methods: {
        async fetchData() {
            const id = this.$route.params.id;
            const resDeputado = await axios.get(`/api/deputados/${id}`);
            this.deputado = resDeputado.data;

            this.calcularIdade();
            await this.fetchDespesas(id);
            await this.fetchOutrosDeputados();
        },
        async fetchDespesas(id) {
            const resDespesas = await axios.get(`/api/deputados/${id}/despesas?page=${this.currentPage}`);
            const resposta = resDespesas.data;
            this.despesas = resposta.despesas.data || [];
            this.pagination = resposta.despesas || {};
            this.totalMes = resposta.totalMes || 0;
            this.mediaMensal = resposta.mediaMensal || 0;
            this.totalAno = resposta.totalAno || 0;
            this.pizzaData = resposta.pizza || [];
            this.$nextTick(() => this.renderChart());
        },
        async fetchOutrosDeputados() {
            if (!this.deputado?.sigla_uf) return;

            try {
                const res = await axios.get(`/api/deputados?uf=${this.deputado.sigla_uf}`);

                const todos = Array.isArray(res.data.data) ? res.data.data : res.data;

                this.outrosDeputados = todos
                    .filter(d => d.id !== this.deputado.id)
                    .slice(0, 5);
            } catch (e) {
                console.error('Erro ao buscar deputados do mesmo estado:', e);
                this.outrosDeputados = [];
            }
        },
        calcularIdade() {
            const data = this.deputado.data_nascimento;
            if (!data) return this.idadeDeputado = 'Não informada';
            const nascimento = new Date(data);
            const hoje = new Date();
            let idade = hoje.getFullYear() - nascimento.getFullYear();
            if (
                hoje.getMonth() < nascimento.getMonth() ||
                (hoje.getMonth() === nascimento.getMonth() && hoje.getDate() < nascimento.getDate())
            ) {
                idade--;
            }
            this.idadeDeputado = `${idade} anos`;
        },
        renderChart() {
            if (this.chart) this.chart.destroy();
            const labels = this.pizzaData.map(p => p.tipo_despesa);
            const valores = this.pizzaData.map(p => p.total);
            const cores = [
                '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e',
                '#e74a3b', '#858796', '#20c9a6', '#fd7e14',
                '#6f42c1', '#d63384', '#198754'
            ];
            const ctx = document.getElementById('despesaChart');
            this.chart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels,
                    datasets: [{
                        data: valores,
                        backgroundColor: cores,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'left',
                            labels: { boxWidth: 12 }
                        }
                    }
                }
            });
        },
        changePage(page) {
            if (page >= 1 && page <= this.pagination.last_page) {
                this.currentPage = page;
                this.fetchDespesas(this.$route.params.id);
            }
        },
        formatarData(data) {
            const d = new Date(data);
            return d.toLocaleDateString('pt-BR');
        },
        formatarValor(valor) {
            return Number(valor).toLocaleString('pt-BR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }
    },
    mounted() {
        this.fetchData();
    }
};
</script>

<style scoped>
.list-unstyled li:hover {
    background-color: rgba(255, 255, 255, 0.05);
    border-radius: 4px;
    transition: 0.2s;
    padding-left: 2px;
}

.page-link {
    cursor: pointer;
    padding: 0.5rem 0.75rem;
    user-select: none;
}

.page-item {
    margin: 0 2px;
}
.pagination-wrapper {
    overflow-x: auto;
    white-space: nowrap;
    -webkit-overflow-scrolling: touch;
    padding-bottom: 1rem;
    max-width: 100%;
}

.pagination {
    display: inline-flex;
    flex-wrap: nowrap;
    margin: 0 auto;
}

.page-link {
    cursor: pointer;
    user-select: none;
}

</style>
