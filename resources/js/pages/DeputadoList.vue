<template>
    <div class="container mt-4">
        <input v-model="filters.search" class="form-control mb-2" placeholder="Buscar nome..." @input="debouncedSearch" />

        <div class="row">
            <div class="col-6">
                <select v-model="filters.sigla_uf" class="form-control" @change="getDeputados">
                    <option value="">UF</option>
                    <option v-for="uf in ufs" :key="uf" :value="uf">{{ uf }}</option>
                </select>
            </div>
            <div class="col-6">
                <select v-model="filters.sigla_partido" class="form-control" @change="getDeputados">
                    <option value="">Partido</option>
                    <option v-for="partido in partidos" :key="partido" :value="partido">{{ partido }}</option>
                </select>
            </div>

            <p></p>

            <div v-for="dep in deputados.data" :key="dep.id" class="col-lg-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="member-card-alt">
                            <div class="avatar-xxl member-thumb mb-2 float-start me-3">
                                <img :alt="dep.nome" :src="dep.url_foto" class="img-thumbnail" />
                                <i class="mdi mdi-star-circle member-star text-success" title="verified user"></i>
                            </div>
                            <div class="member-card-alt-info">
                                <h4 class="mb-1 mt-0 fw-semibold">{{ dep.nome }}</h4>
                                <p class="text-muted">
                                    {{ dep.sigla_partido }} <span> | </span> <span> {{ dep.sigla_uf }} </span>
                                </p>
                                <p class="text-muted font-13">
                                    {{ dep.nome }} - {{ calcularIdade(dep.data_nascimento) }} <br/>
                                    {{ dep.municipio_nascimento }}
                                </p>
                                <router-link :to="`/deputado/${dep.id}`" class="btn btn-success rounded-pill waves-effect waves-light">
                                    Ver Despesas
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Paginação -->
            <div class="d-flex justify-content-center">
                <div class="pagination pagination-rounded pagination-boxed mb-0">
                    <ul class="pagination mb-0">
                        <li :class="{ disabled: deputados.meta.current_page === 1 }" class="page-item">
                            <a class="page-link" @click="changePage(deputados.meta.current_page - 1)">«</a>
                        </li>

                        <li
                            v-for="page in visiblePages"
                            :key="page"
                            :class="{ active: page === deputados.meta.current_page }"
                            class="page-item"
                        >
                            <a class="page-link" @click="changePage(page)">{{ page }}</a>
                        </li>

                        <li :class="{ disabled: deputados.meta.current_page === deputados.meta.last_page }" class="page-item">
                            <a class="page-link" @click="changePage(deputados.meta.current_page + 1)">»</a>
                        </li>
                    </ul>
                </div>
            </div>
            <p></p>
        </div>
    </div>
</template>

<script>
import _ from 'lodash'
import axios from "axios";

export default {
    name: 'DeputadosList',
    data() {
        return {
            deputados: {data: [], meta: {}},
            idadeDeputado: '',
            filters: {
                search: '',
                sigla_uf: '',
                sigla_partido: '',
                page: 1,
            },
            ufs: [],
            partidos: [],
        }
    },
    methods: {
        async getDeputados() {
            const params = { ...this.filters }
            const res = await this.$axios.get('/api/deputados', { params })

            const paginated = res.data.data

            this.deputados = {
                data: paginated.data,
                meta: {
                    current_page: paginated.current_page,
                    last_page: paginated.last_page,
                },
            }

            this.ufs = res.data.ufs
            this.partidos = res.data.partidos
        },
        calcularIdade(data) {
            if (!data) return 'Não informada';
            const nascimento = new Date(data);
            const hoje = new Date();
            let idade = hoje.getFullYear() - nascimento.getFullYear();
            const m = hoje.getMonth() - nascimento.getMonth();
            if (m < 0 || (m === 0 && hoje.getDate() < nascimento.getDate())) {
                idade--;
            }
            return `${idade} anos`;
        },
        changePage(page) {
            this.filters.page = page
            this.getDeputados()
        },
        debouncedSearch: _.debounce(function () {
            this.getDeputados()
        }, 500),
    },
    mounted() {
        this.getDeputados()
    },
    computed: {
        visiblePages() {
            const current = this.deputados.meta.current_page
            const last = this.deputados.meta.last_page

            const delta = 2
            let start = Math.max(current - delta, 1)
            let end = Math.min(current + delta, last)

            if (end - start < delta * 2) {
                if (start === 1) end = Math.min(start + delta * 2, last)
                if (end === last) start = Math.max(end - delta * 2, 1)
            }

            const pages = []
            for (let i = start; i <= end; i++) pages.push(i)
            return pages
        }
    }
}
</script>

<style scoped>
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
