# 🗺️ Places API – Laravel 12 + PostgreSQL

API RESTful para cadastro e gerenciamento de lugares, com suporte a filtro por nome.

---

## 🚀 Tecnologias Utilizadas

- **Laravel 12**
- **PHP 8.3**
- **PostgreSQL**
- **Docker**
- **PHPUnit** (testes automatizados)

---

## 📦 Instalação com Docker

### 1. Clone o repositório

```bash
git clone https://github.com/Deivison06/desafio_backend_places.git
cd desafio_backend_places

cp .env.example .env
docker-compose build --no-cache
docker-compose up -d
espere um pouco e acesse:

http://localhost:8000/api/places

Criar um lugar (POST /api/places)
{
  "name": "Praia do Forte",
  "city": "Mata de São João",
  "state": "BA"
}

Método	Rota	Descrição
GET	/api/places	Lista os lugares (filtro por nome)
POST	/api/places	Cria um novo lugar
GET	/api/places/{id}	Exibe os detalhes de um lugar
PUT	/api/places/{id}	Atualiza os dados de um lugar
DELETE	/api/places/{id}	Remove um lugar


docker exec -it laravel-app php artisan test
