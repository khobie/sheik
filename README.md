# Koforidua Artisan Booking System

This project implements a web-based platform for booking and managing artisan services in the
Koforidua Municipality. It is based on the thesis brief: clients can discover, filter, and book
verified artisans, while artisans can register profiles, publish availability, receive booking
notifications, and build trust through reviews and ratings.

## Features

- Client-facing artisan search by keyword, category, availability, and minimum rating.
- Artisan profile cards with verification status, location, skills, pricing, reviews, and next
  available slot.
- Booking workflow for selected artisans with client contact, address, date, time, and service
  description.
- Artisan registration workflow for profile, skills, pricing, location, and availability.
- Booking history and notification dashboard.
- Express REST API for users, artisans, categories, bookings, reviews, notifications, and health
  checks.
- MySQL schema and seed data for the relational database described in the thesis.
- In-memory API seed data so the server can run before MySQL credentials are configured.

## Project structure

```text
client/                 React + Vite front-end
server/                 Node.js + Express REST API
server/database/        MySQL schema and seed scripts
server/src/data/        Demo seed data used by the API
server/src/routes/      REST endpoint definitions
server/src/services/    Marketplace business logic
```

## Getting started

Install dependencies:

```bash
npm install --prefix client
npm install --prefix server
```

Run the React client:

```bash
npm run client:dev
```

Run the API:

```bash
cp server/.env.example server/.env
npm run server:dev
```

Build the client for production:

```bash
npm run build
```

Run checks:

```bash
npm run lint
```

## Database setup

The API runs with in-memory demo data by default. To use MySQL:

1. Create a database user with permission to create tables.
2. Run `server/database/schema.sql`.
3. Run `server/database/seed.sql`.
4. Copy `server/.env.example` to `server/.env` and set `DB_HOST`, `DB_PORT`, `DB_USER`,
   `DB_PASSWORD`, and `DB_NAME`.
5. Start the server and open `/api/database/health` to verify connectivity.

## Key API endpoints

- `GET /api/dashboard/summary`
- `GET /api/categories`
- `GET /api/artisans`
- `POST /api/artisans`
- `PATCH /api/artisans/:id/availability`
- `GET /api/bookings`
- `POST /api/bookings`
- `PATCH /api/bookings/:id/status`
- `GET /api/reviews`
- `POST /api/reviews`
- `GET /api/notifications`
- `PATCH /api/notifications/:id/read`
- `POST /api/auth/register`
- `POST /api/auth/login`
