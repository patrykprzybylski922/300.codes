# 📚 Laravel 12 – Books & Authors API

Projekt API w Laravel 12 do zarządzania książkami i autorami.  
Zawiera relacje many-to-many, paginację, filtrowanie, kolejki (Jobs), testy oraz uwierzytelnianie przez **Laravel Sanctum**.

---

## 🚀 Uruchomienie projektu (od zera)

### 1️⃣ Klonowanie repozytorium
```bash
git clone https://github.com/patrykprzybylski922/300.codes.git
cd 300.codes
```

---

### 2️⃣ Zbudowanie i uruchomienie kontenerów
```bash
docker compose up -d --build
```

---

### 3️⃣ Konfiguracja środowiska (.env)

Plik `.env` **nie jest wersjonowany** – należy go utworzyć na podstawie przykładu:

```bash
cp .env.example .env
```

Wygeneruj klucz aplikacji:
```bash
docker compose exec app php artisan key:generate
```

Minimalne, wymagane ustawienia DB (domyślne pod Dockera):
```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=secret
```

---

### 4️⃣ Instalacja zależności PHP
```bash
docker compose exec app composer install
```

---

### 5️⃣ Migracje i dane startowe
```bash
docker compose exec app php artisan migrate
docker compose exec app php artisan db:seed
```

> Seeder `UserSeeder` tworzy użytkownika testowego (patrz sekcja Autoryzacja).

---

### 6️⃣ Uruchomienie serwera Laravel (DEV)
```bash
docker compose exec app php artisan serve --host=0.0.0.0 --port=8000
```

---

## 🌍 Dostępy
- API (Laravel): http://localhost:8000
- phpMyAdmin: http://localhost:8084
    - user: `laravel`
    - password: `secret`

---

## 🔐 Autoryzacja (Laravel Sanctum)

Endpointy modyfikujące dane (`POST` / `PUT /api/books`) są zabezpieczone **Sanctum**.

---

### 1️⃣ Utworzenie użytkownika (DEV)

Projekt zawiera **seedera użytkownika**.

Uruchomienie seedera:
```bash
docker compose exec app php artisan db:seed --class=UserSeeder
```

Seeder utworzy użytkownika:

- **email:** `admin@test.pl`
- **password:** `password`

> Hasło jest hashowane i gotowe do użycia z Laravel Sanctum.

---

### 2️⃣ Logowanie i pobranie tokena
`POST /api/login`

```json
{
  "email": "admin@test.pl",
  "password": "password"
}
```

Response:
```json
{
  "token": "1|xxxxxxxxxxxxxxxxxxxx"
}
```

Token należy przekazywać w nagłówku:
```
Authorization: Bearer {TOKEN}
```

---

## 📡 Dostępne endpointy API

### 📘 Books

| Metoda | Endpoint | Opis | Auth |
|------|--------|------|------|
| GET | `/api/books` | Lista książek z autorami | ❌ |
| GET | `/api/books/{id}` | Szczegóły książki | ❌ |
| POST | `/api/books` | Dodanie książki | ✅ Sanctum |
| PUT | `/api/books/{id}` | Aktualizacja książki | ✅ Sanctum |
| DELETE | `/api/books/{id}` | Usunięcie książki | ❌ |

---

### ✍️ Authors

| Metoda | Endpoint | Opis |
|------|--------|------|
| GET | `/api/authors` | Lista autorów (z książkami) |
| GET | `/api/authors/{id}` | Szczegóły autora |
| POST | `/api/authors` | Dodanie autora |

#### 🔎 Filtrowanie autorów
```
GET /api/authors?search=fragment_tytulu
```

Zwraca autorów, których **tytuły książek** zawierają podany ciąg znaków.

---

## 🧪 Testy

Uruchomienie wszystkich testów:
```bash
docker compose exec app php artisan test
```

Wybrany test:
```bash
docker compose exec app php artisan test --filter=BookApiTest
```

---

## ⚙️ Komendy Artisana

### ➕ Utworzenie nowego autora (CLI)
```bash
docker compose exec app php artisan author:create
```

---

## 🛑 Zatrzymanie projektu
```bash
docker compose down
```

⚠️ Zatrzymanie + usunięcie bazy danych:
```bash
docker compose down -v
```
