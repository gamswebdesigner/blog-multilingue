# Blog Multilingue — Laravel 12 + Vue 3 + Inertia + TypeScript

Projeto de portfólio focado em **routing avançado no Laravel**, desenvolvido para o mercado alemão.

---

## Stack

**Backend:** Laravel 12, SQLite, Eloquent ORM  
**Frontend:** Vue 3 (Composition API), Inertia.js, TypeScript  
**Ferramentas:** Artisan, Vite, Ziggy, Laravel Sanctum

---

## Funcionalidades

- Blog público multilíngue (alemão / inglês)
- Listagem de posts com paginação
- Filtro opcional por categoria
- Post individual com conteúdo traduzido dinamicamente
- Painel admin protegido por autenticação
- API REST v1 com filtros por locale e categoria

---

## Estrutura de Rotas

### Rotas Web (`routes/web.php`)

| URL                          | Nome                | Descrição                                 |
| ---------------------------- | ------------------- | ----------------------------------------- |
| `/`                          | `blog.index`        | Homepage com 6 posts publicados           |
| `/post/{post:slug}`          | `blog.show`         | Post individual (binding implícito)       |
| `/category/{category:slug?}` | `blog.category`     | Filtro por categoria (parâmetro opcional) |
| `/admin/posts`               | `admin.posts.index` | Painel admin (agrupado, middleware auth)  |

### Rotas API (`routes/api.php`)

| Método | URL                    | Nome                 | Descrição               |
| ------ | ---------------------- | -------------------- | ----------------------- |
| GET    | `/api/v1/posts`        | `api.v1.posts.index` | Lista posts com filtros |
| GET    | `/api/v1/posts/{post}` | `api.v1.posts.show`  | Post único              |

---

## Banco de Dados

users ──┐
├──> posts ──> categories
│
└──> post_translations (locale: de | en)

text

- **4 tabelas:** users, categories, posts, post_translations
- **Composite unique key** em `post_translations` (`post_id`, `locale`)
- **Foreign keys** com `cascadeOnDelete`
- **Accessor dinâmico** em `Category`: `$category->name` retorna tradução conforme `app()->getLocale()`

---

## Tópicos de Routing Exercitados

| Tópico                                   | Aplicação                                                           |
| ---------------------------------------- | ------------------------------------------------------------------- |
| **Rotas web vs API**                     | `web.php` (Inertia/HTML) vs `api.php` (JSON stateless)              |
| **Parâmetros obrigatórios e opcionais**  | `{post:slug}` obrigatório, `{category:slug?}` opcional              |
| **Rotas nomeadas e `route()`**           | Uso de `route('blog.show', { post })` nos componentes Vue via Ziggy |
| **Agrupamento com prefixo e middleware** | `/admin` com `auth`, `/api/v1` com prefixo e nome                   |
| **Route Model Binding implícito**        | `{post:slug}` resolve por coluna customizada                        |
| **Route Model Binding explícito**        | Implementado via classe `PostBinding` com `firstOrFail()`           |

---

## Componentes Vue

resources/js/pages/
├── blog/
│ ├── Index.vue # Listagem com paginação e links via route()
│ └── Show.vue # Post individual
└── admin/
└── posts/
└── Index.vue # Tabela de posts (status, categoria, data)

text

---

## O que este projeto demonstra

- Separação clara entre rotas públicas, administrativas e API
- Sistema multilíngue com traduções normalizadas
- Integração Laravel + Vue + TypeScript com tipos seguros
- Uso de convenções do framework (named routes, Ziggy, agrupamento)
- Código preparado para escala (paginação, eager loading, filtros)

---

## Como rodar

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
