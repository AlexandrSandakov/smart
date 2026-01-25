# Support Ticket Widget + Manager API (Laravel)

A small ticketing system built with Laravel.
Includes a public embeddable ticket form (widget) that submits via AJAX and supports multiple file attachments, plus a manager-only API secured by Sanctum + roles.

---

## Features

### Public (Widget / Client)
- Create support tickets via **AJAX** (`POST /api/tickets`)
- Fields: name, email, phone, subject, message
- Multiple file uploads (`files[]`)
- Validation errors shown inline (422)
- Designed to be embedded on any page via an **iframe**

### Manager (Protected API)
- Manager login endpoint returns a Sanctum token
- Manager-only endpoints protected with:
  - `auth:sanctum`
  - `role:manager` (Spatie Permission)
- List tickets with pagination
- Optional filtering via query params (example: `status`, `phone`)

### Attachments
- File uploads handled via **Spatie Media Library**
- Stored on `public` disk and accessible via `/storage/...`
- Ticket resource returns attachment metadata + URL

---

## Tech Stack
- Laravel (API + Blade widget)
- Laravel Sanctum (token authentication)
- Laravel Breeze (installed for auth scaffolding / baseline setup)
- Spatie Permission (roles)
- Spatie Media Library (attachments)
- Tailwind (CDN) for widget UI

---

## Requirements
- PHP 8.2+ (tested on modern PHP)
- Composer
- MySQL / MariaDB / PostgreSQL (any Laravel-supported DB)
- Node is **not required** for the widget (Tailwind CDN)

---

## Installation


composer install

cp .env.example .env

php artisan key:generate

Configure your DB in .env, then:


php artisan migrate

php artisan storage:link

Media Library config can be published if needed:


php artisan vendor:publish --provider="Spatie\\MediaLibrary\\MediaLibraryServiceProvider" --tag="medialibrary-config"

## Seeded Demo Accounts

### Manager User
- **Email:** `manager@example.com`
- **Password:** `password`
- **Role:** `manager`

---

## API Endpoints

### Public

#### Create Ticket
`POST /api/tickets`

**Content-Type:** `multipart/form-data`

**Fields:**
- `customer_name` (required)
- `customer_email` (required, email)
- `customer_phone` (required)
- `subject` (required)
- `message` (required)
- `files[]` (optional, multiple)

**Response:**
- `201 Created` on success

---

### Manager Authentication (Sanctum)

#### Login (Get Token)
`POST /api/auth/login`

**JSON body:**
json
{
  "email": "manager@example.com",
  "password": "password"
}

**Response:**

`{   "token": "..." }`

Use the token in requests:

`Authorization: Bearer <token>`

* * *

### Manager Routes

All manager routes are protected by:

-   `auth:sanctum`

-   `role:manager`


#### List Tickets

`GET /api/manager/tickets`

**Optional filters:**

-   `status` — exact match

-   `phone` — partial match (LIKE search)


**Examples:**

`/api/manager/tickets?page=1 /api/manager/tickets?status=new /api/manager/tickets?phone=38050`

* * *

## Testing (Insomnia / Postman)

### 1. Login

`POST /api/auth/login`

Copy the returned token.

### 2. Manager Tickets

`GET /api/manager/tickets`

**Header:**

`Authorization: Bearer <token>`

### 3. Create Ticket With Files

`POST /api/tickets`

**Body:** `multipart/form-data`
Repeat `files[]` for each attachment.

* * *

## Widget / iFrame

### Widget Page

`/widget/ticket`

### Embed Example

`<iframe   src="https://your-domain.com/widget/ticket"   width="420"   height="720"   style="border:0; overflow:hidden;"   loading="lazy" ></iframe>`

### Widget Configuration

`window.TICKET_WIDGET = {   apiUrl: "{{ config('widget.api_url') }}" };`

* * *

## Environment Configuration

### `.env`

`WIDGET_API_URL=http://127.0.0.1:8000/api/tickets`

* * *

## Notes

-   Upload limits depend on PHP configuration:

    -   `upload_max_filesize`

    -   `post_max_size`

-   Attachments are served from `/storage/...`

-   Run once after setup:

    `php artisan storage:link`


* * *

## License

Demo project. Free to use for testing and evaluation.
