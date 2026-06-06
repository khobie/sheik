# AGENTS.md

## Repository layout

The default branch (`gh-pages`) contains only a placeholder `README.md`. Runnable applications live on feature branches:

| Product | Branch | Stack |
|---------|--------|-------|
| Koforidua Artisan Booking System | `cursor/artisan-booking-system-3bff` | Node.js, React/Vite, Express |
| New Juaben Campaign Tracking System | `cursor/document-campaign-tracking-system-blueprint-e460` | Laravel 10, PHP 8.1+, MySQL |
| Enterprise Network (Packet Tracer) | `cursor/design-and-simulate-enterprise-network-for-rural-bank-abd4` | Cisco IOS configs (desktop Packet Tracer only) |

Check out the branch for the product you are working on before installing dependencies.

## Cursor Cloud specific instructions

### Artisan Booking System (primary dev setup)

**Requirements:** Node.js 18+ and npm only. MySQL is optional (API uses in-memory seed data by default).

**Install** (from repo root after checking out the artisan branch):

```bash
npm install --prefix client
npm install --prefix server
cp server/.env.example server/.env   # first time only
```

**Run** (two terminals):

```bash
npm run server:dev    # Express API on http://localhost:4000
npm run client:dev    # React/Vite UI on http://localhost:5173
```

**Verify:**

```bash
npm run lint          # ESLint (client) + node --check (server)
npm run build         # Vite production build
curl http://localhost:4000/api/dashboard/summary
```

The React client uses in-browser `seedData.js` and does not call the API during normal UI flows. The API is still useful for REST testing and future full-stack integration.

**Hello-world flow:** open the client, search/filter artisans, submit a booking, confirm it appears in Booking history and Notifications.

### Campaign Tracking System

Requires PHP 8.1+, Composer, MySQL 8, and npm (for Vite assets). See `docs/campaign-tracking-system.md` on branch `cursor/document-campaign-tracking-system-blueprint-e460`. Typical flow: `composer install`, configure `campaign-tracker/.env`, `php artisan migrate --seed`, `php artisan serve`, `npm run dev` inside `campaign-tracker/`.

### Packet Tracer project

Not runnable in Cloud Agent VMs. Use Cisco Packet Tracer 8.x on a desktop machine with `pt-project/tests/runbook.md`.
