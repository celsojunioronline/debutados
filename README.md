<h1 align="center">
  <br>
  <img src="https://destrosp.digital/logo1.png" alt="Deputados" width="100">
  <br>
  Deputados
  <br>
</h1>

<h4 align="center">Consulta moderna de dados da Câmara dos Deputados com Laravel + Vue 3</h4>

<p align="center">
  <a href="https://laravel.com">
    <img src="https://img.shields.io/badge/Laravel-12.x-red.svg" alt="Laravel">
  </a>
  <a href="https://vuejs.org">
    <img src="https://img.shields.io/badge/Vue-3.x-42b883.svg" alt="Vue 3">
  </a>
  <a href="https://dadosabertos.camara.leg.br/">
    <img src="https://img.shields.io/badge/DadosAbertos-Câmara-blue.svg" alt="API Câmara">
  </a>
  <a href="LICENSE">
    <img src="https://img.shields.io/badge/license-MIT-green.svg" alt="License">
  </a>
</p>

<p align="center">
  <a href="#✨-funcionalidades">Funcionalidades</a> •
  <a href="#🧰-tecnologias">Tecnologias</a> •
  <a href="#🚀-como-usar">Como usar</a> •
  <a href="#🧠-sobre-o-projeto">Sobre o projeto</a> •
  <a href="#📄-licença">Licença</a>
</p>

---

## ✨ Funcionalidades

- 🔍 Filtro por nome, estado (UF) e partido
- 🧑‍💼 Consulta completa do deputado (foto, nome, ocupações, profissões)
- 💸 Listagem paginada de despesas com busca por fornecedor ou tipo
- 📊 Gráfico pizza dos tipos de gasto (gastos públicos por categoria)
- 📈 Total mensal, anual e média por deputado
- ⚡ Integração completa com a [API oficial da Câmara](https://dadosabertos.camara.leg.br/)

---

## 🧰 Tecnologias

| Back-end | Front-end | Dados |
|----------|-----------|-------|
| Laravel 12.x | Vue 3 + Vite | API da Câmara dos Deputados |
| PHP 8.2 | Bootstrap 5 | Axios |
| Eloquent ORM | Vue Router | JSON |

---

## 🚀 Como usar

> Requisitos: PHP 8.2+, Composer, Node.js, NPM/Yarn

```bash
# Clone o repositório
git clone https://github.com/seunome/deputados.git
cd deputados

# Instale dependências
composer install
npm install

# Compile os assets
npm run build

# Crie o banco de dados e configure o .env
cp .env.example .env
php artisan key:generate

# Rode as migrations
php artisan migrate

# Inicie o servidor
php artisan serve
