# 📡 The Wire

A real-time international news discussion app built with PHP MVC — no framework.

## 🚀 Technologies

- **PHP 8** — MVC architecture (no framework)
- **SQLite + PDO** — Embedded database with FTS5 full-text search
- **SSE** — Server-Sent Events for real-time chat
- **Vanilla JS** — fetch() API for AJAX reactions
- **Tailwind CSS** — Utility-first styling

## ✅ Features

- 📰 Live news feed filtered by country and category (with SQLite fallback when API is unavailable)
- 💬 Real-time chat salon powered by Server-Sent Events (SSE) with heartbeat ping
- 👍 AJAX reactions — Like, Favourite, Interesting — counters update without page reload
- 🔍 Full-text search powered by SQLite FTS5 with ranked results
- 🔒 Security: CSRF protection, XSS sanitisation, HTTP security headers

## 🧠 Technical Challenges

### 1. Server-Sent Events (SSE)
The real-time chat uses SSE to push messages from server to client without polling. Output buffering must be cleared (`ob_end_clean()`) before sending SSE headers, and a heartbeat comment is sent every 15 seconds to keep the connection alive.

### 2. AJAX Reactions
Reaction buttons use `fetch()` with `X-Requested-With: XMLHttpRequest` header so the server can detect AJAX requests and return JSON instead of redirecting. Output buffers are flushed before the JSON response to avoid mixing HTML into the payload.

### 3. CSRF Protection
Every form includes a hidden token generated in session. Controllers verify the token before processing any POST request — invalid tokens return a 403.

### 4. Full-Text Search (FTS5)
Articles are indexed in a virtual FTS5 table on insert. Search queries use SQLite's `MATCH` operator with `rank` ordering for relevance-sorted results.

### 5. API Fallback
When the external news API is unavailable, `ArticleController` falls back to `findAll()` on the local SQLite database — the site stays functional with previously fetched articles.

## 🏗️ Project Structure

```
the-wire/
├── index.php              # Entry point & router
├── migrate.php            # Database schema setup
├── seed.php               # Test data
├── database.sql           # Schema
└── src/
    ├── controllers/       # ArticleController, ChatController, ReactionController…
    ├── models/            # Repositories & entities
    ├── views/             # PHP templates + layout
    └── classes/           # Database, NewsService
```

## 🔮 Future Improvements

- [ ] User authentication
- [ ] Deployment on a PHP host
- [ ] Pagination for the news feed
- [ ] Dark mode

---

Built by Marie Laure Debeaune
