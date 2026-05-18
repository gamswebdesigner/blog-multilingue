# Blog Multilíngue — Laravel 12 + Vue 3 + Inertia + TypeScript

# Multilingual Blog — Laravel 12 + Vue 3 + Inertia + TypeScript

Projeto de portfólio focado em routing avançado no Laravel, desenvolvido para o mercado alemão.  
Portfolio project focused on advanced routing in Laravel, developed for the German market.

---

## Stack / Tech Stack

| Camada / Layer      | Tecnologia / Technology                         |
| ------------------- | ----------------------------------------------- |
| Backend             | Laravel 12, SQLite, Eloquent ORM                |
| Frontend            | Vue 3 (Composition API), Inertia.js, TypeScript |
| Ferramentas / Tools | Artisan, Vite, Ziggy, Laravel Sanctum           |

---

## Funcionalidades / Features

**PT:**

- Blog público multilíngue (alemão / inglês)
- Listagem de posts com paginação
- Filtro opcional por categoria
- Post individual com conteúdo traduzido dinamicamente
- Painel admin protegido por autenticação
- API REST v1 com filtros por locale e categoria

**EN:**

- Multilingual public blog (German / English)
- Post listing with native pagination
- Optional filtering by category
- Individual post view with dynamically translated content
- Admin dashboard protected by authentication
- REST API v1 featuring filters by locale and category

---

## Estrutura de Rotas / Route Structure

### Rotas Web / Web Routes (`routes/web.php`)

**PT:**

| URL                          | Nome                | Descrição                                 |
| ---------------------------- | ------------------- | ----------------------------------------- |
| `/`                          | `blog.index`        | Homepage com 6 posts publicados           |
| `/post/{post:slug}`          | `blog.show`         | Post individual (binding implícito)       |
| `/category/{category:slug?}` | `blog.category`     | Filtro por categoria (parâmetro opcional) |
| `/admin/posts`               | `admin.posts.index` | Painel admin (agrupado, middleware auth)  |

**EN:**

| URL                          | Name                | Description                                |
| ---------------------------- | ------------------- | ------------------------------------------ |
| `/`                          | `blog.index`        | Homepage displaying 6 published posts      |
| `/post/{post:slug}`          | `blog.show`         | Individual post (implicit binding by slug) |
| `/category/{category:slug?}` | `blog.category`     | Category filter (optional parameter)       |
| `/admin/posts`               | `admin.posts.index` | Admin dashboard (grouped, auth middleware) |

### Rotas API / API Routes (`routes/api.php`)

**PT:**

| Método | URL                    | Nome                 | Descrição               |
| ------ | ---------------------- | -------------------- | ----------------------- |
| GET    | `/api/v1/posts`        | `api.v1.posts.index` | Lista posts com filtros |
| GET    | `/api/v1/posts/{post}` | `api.v1.posts.show`  | Post único              |

**EN:**

| Method | URL                    | Name                 | Description                     |
| ------ | ---------------------- | -------------------- | ------------------------------- |
| GET    | `/api/v1/posts`        | `api.v1.posts.index` | List posts with dynamic filters |
| GET    | `/api/v1/posts/{post}` | `api.v1.posts.show`  | Fetch details for a single post |

---

## Banco de Dados / Database Schema

```
users ──┐
        ├──> posts ──> categories
        │
        └──> post_translations (locale: de | en)
```

**PT:**

- 4 tabelas: `users`, `categories`, `posts`, `post_translations`
- Composite unique key em `post_translations (post_id, locale)`
- Foreign keys com `cascadeOnDelete`
- Accessor dinâmico em `Category`: `$category->name` retorna tradução conforme `app()->getLocale()`

**EN:**

- 4 tables: `users`, `categories`, `posts`, `post_translations`
- Composite unique key on `post_translations (post_id, locale)`
- Foreign keys configured with `cascadeOnDelete`
- Dynamic Accessor on `Category`: `$category->name` returns translation based on `app()->getLocale()`

---

## Tópicos de Routing Exercitados / Routing Concepts Covered

**PT:**

| Tópico                               | Aplicação                                                 |
| ------------------------------------ | --------------------------------------------------------- |
| Rotas web vs API                     | `web.php` (Inertia/HTML) vs `api.php` (JSON stateless)    |
| Parâmetros obrigatórios e opcionais  | `{post:slug}` obrigatório, `{category:slug?}` opcional    |
| Rotas nomeadas e `route()`           | Uso de `route('blog.show', { post })` no Vue via Ziggy    |
| Agrupamento com prefixo e middleware | `/admin` com `auth`, `/api/v1` com prefixo e nome         |
| Route Model Binding implícito        | `{post:slug}` resolve por coluna customizada              |
| Route Model Binding explícito        | Implementado via classe `PostBinding` com `firstOrFail()` |

**EN:**

| Concept                        | Application                                                            |
| ------------------------------ | ---------------------------------------------------------------------- |
| Web vs API Routes              | `web.php` (Inertia/HTML) vs `api.php` (stateless JSON)                 |
| Required & Optional Parameters | `{post:slug}` required, `{category:slug?}` optional                    |
| Named Routes & `route()`       | Usage of `route('blog.show', { post })` in Vue via Ziggy               |
| Route Grouping & Middlewares   | `/admin` prefix with `auth`, `/api/v1` structured grouping             |
| Implicit Route Model Binding   | `{post:slug}` automatically resolves using custom column               |
| Explicit Route Model Binding   | Custom resolution logic handled via `PostBinding` with `firstOrFail()` |

---

## Componentes Vue / Vue Components

```
resources/js/pages/
├── blog/
│   ├── Index.vue      # Listagem com paginação / Post list & pagination
│   └── Show.vue       # Post individual / Single post view
└── admin/
    └── posts/
        └── Index.vue  # Tabela de posts / Management table
```

---

## O que este projeto demonstra / What This Project Demonstrates

**PT:**

- Separação clara entre rotas públicas, administrativas e API
- Sistema multilíngue com traduções normalizadas no banco
- Integração Laravel + Vue + TypeScript com tipos seguros
- Uso de convenções do framework (named routes, Ziggy, agrupamento)
- Código preparado para escala (paginação, eager loading, filtros)

**EN:**

- Clear separation between public, administrative, and API routes
- Scalable i18n engine with normalized database translations
- Robust Laravel + Vue + TypeScript integration with type safety
- Strict adherence to framework conventions (named routes, Ziggy, grouping)
- Production-ready code (pagination, eager loading, dynamic filters)

---

## Como rodar / How to Run

```bash
git clone https://github.com/SEU_USER/blog-multilingue.git
cd blog-multilingue
composer install
npm install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate:fresh --seed
npm run dev
php artisan serve
```
