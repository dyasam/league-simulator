# Champions League Simulator

A Laravel-based football league simulator that creates fixtures, simulates matches week by week or all at once, and updates standings accordingly.

## 🚀 Installation

```bash
git clone https://github.com/dyasam/league-simulator.git
cd league-simulator

cp .env.example .env
composer install
php artisan key:generate
php artisan migrate --seed
```

## 🐳 Run with Docker

```bash
docker compose build --no-cache
docker compose up -d
```

## 📌 API Endpoints

| Method | Endpoint                                | Description                    |
|--------|-----------------------------------------|--------------------------------|
| POST   | `/api/simulations`                      | Create a new simulation        |
| POST   | `/api/simulations/{uid}/play-next-week` | Play next match week           |
| POST   | `/api/simulations/{uid}/play-all`       | Simulate all remaining matches |
| GET    | `/api/teams`                            | List all teams                 |

## 🧪 Running Tests

```bash
docker compose exec app php artisan test
```

## ⚙️ Tech Stack

- Laravel 11
- MySQL
- Redis
- Docker
- PHPUnit

## 📁 Folder Structure Highlights

- `app/Services/` – Match logic, simulation, fixture generation
- `app/Http/Controllers/Api/` – API layer
- `app/Http/Resources/` – API transformers
- `tests/Feature/` – API tests
- `tests/Unit/` – Service-level tests

---

## Live Demo: 
http://31.97.183.2
