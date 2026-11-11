# runtime-m.by — редизайн сайта на WordPress

[![CI](https://github.com/luxsordel/runtime-m-redesign/actions/workflows/ci.yml/badge.svg)](https://github.com/luxsordel/runtime-m-redesign/actions/workflows/ci.yml)
![WordPress](https://img.shields.io/badge/WordPress-6.9-21759B?logo=wordpress&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?logo=php&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-Compose-2496ED?logo=docker&logoColor=white)
![License](https://img.shields.io/badge/license-MIT-green)

Полный редизайн устаревшего корпоративного сайта [runtime-m.by](https://runtime-m.by): перенос в воспроизводимую локальную среду, собственная блочная тема WordPress (Full Site Editing), техническое и локальное SEO, интеграция карт, оптимизация скорости и публикация без потери позиций в поиске.

> **Статус:** 🚧 в работе — см. [дорожную карту](#дорожная-карта) и [CHANGELOG](CHANGELOG.md).

<!-- После первого этапа сюда добавляются скриншоты «до / после»:
| До | После |
|----|-------|
| ![до](docs/screenshots/before-home.png) | ![после](docs/screenshots/after-home.png) |
-->

## Задачи проекта

- Сохранить удобную для владельца админку (wp-admin + блочный редактор), но убрать устаревшие конструкторы и лишние плагины.
- Современный адаптивный дизайн, Core Web Vitals в «зелёной» зоне, доступность WCAG 2.1 AA.
- Не потерять трафик: 301-редиректы со всех изменившихся URL, перенос метаданных SEO.
- Локальное SEO: schema.org `LocalBusiness`, карты, единые NAP-данные, Яндекс Вебмастер / Google Search Console.

## Стек

| Слой | Технологии |
|------|------------|
| CMS | WordPress 6.9, PHP 8.3, MariaDB 11.4 |
| Тема | Собственная блочная тема (FSE): `theme.json`, шаблоны, паттерны блоков |
| SEO | Rank Math, schema.org JSON-LD, sitemap, редиректы 301 |
| Окружение | Docker Compose, WP-CLI, phpMyAdmin, Mailpit |
| Изображения | ImageMagick, Pillow → WebP/AVIF, адаптивные `srcset` |
| Качество | GitHub Actions (PHP lint, проверка compose), Lighthouse, Playwright |
| Автоматизация | AI-агент Claude Code с MCP (Playwright, Windows) — см. [CLAUDE.md](CLAUDE.md) |

## Структура репозитория

```
├── docker-compose.yml      # локальный стек: WordPress, MariaDB, WP-CLI, phpMyAdmin, Mailpit
├── docker/php.ini          # лимиты PHP для импорта больших архивов
├── wp-content/
│   ├── mu-plugins/         # служебные плагины (локальная почта и т.п.)
│   └── themes/runtime-m/   # собственная блочная тема
├── docs/
│   ├── adr/                # архитектурные решения (ADR)
│   ├── screenshots/        # скриншоты до/после
│   └── progress.md         # журнал работ
├── CLAUDE.md               # инструкции и регламент для AI-агента
└── .github/                # CI, шаблоны issue/PR, Dependabot
```

Данные клиента (дампы БД, архивы `.wpress`, загрузки, `.env`) в репозиторий **не попадают** — см. [.gitignore](.gitignore).

## Быстрый старт

Требуется Docker Desktop.

```bash
cp .env.example .env              # задать локальные пароли
docker compose up -d
docker compose run --rm wpcli core install \
  --url=http://localhost:8080 --title="runtime-m (local)" \
  --admin_user=admin --admin_password=<пароль> --admin_email=admin@site.test --skip-email
```

| Сервис | Адрес |
|--------|-------|
| Сайт | http://localhost:8080 (админка: `/wp-admin`) |
| phpMyAdmin | http://localhost:8081 |
| Mailpit (почта с сайта) | http://localhost:8025 |

WP-CLI: `docker compose run --rm wpcli <команда>`, например `plugin list`.

## Дорожная карта

- [x] Воспроизводимая локальная среда (Docker, WP-CLI, перехват почты)
- [ ] Аудит старого сайта: страницы, контент, плагины, SEO, скорость
- [ ] Перенос боевого сайта в локальную копию
- [ ] Новая структура и тексты
- [ ] Блочная тема: дизайн-система (`theme.json`), шаблоны, паттерны
- [ ] Оптимизация изображений и производительности
- [ ] SEO: метаданные, schema.org, sitemap, 301-редиректы
- [ ] Карты и локальное SEO
- [ ] Формы, аналитика, cookies, политика конфиденциальности
- [ ] Публикация и мониторинг

## Процесс разработки

- Ветки `feat/…`, `fix/…`, `docs/…` → Pull Request в `main`.
- Коммиты по [Conventional Commits](https://www.conventionalcommits.org/ru/).
- Архитектурные решения фиксируются в [docs/adr](docs/adr).

## Лицензия

Код в этом репозитории распространяется по лицензии [MIT](LICENSE). Тексты, изображения, логотип и торговые марки runtime-m.by принадлежат их владельцу и под лицензию не подпадают.
