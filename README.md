# Sinergy Philippines — Website

Philippines-based outsourcing company website. Built with PHP, vanilla CSS, and vanilla JavaScript. No framework, no database, no build step.

---

## Requirements

- PHP 7.4 or higher
- Apache web server with `mod_rewrite` enabled (shared hosting, XAMPP, Laragon)
- PHPMailer (manual install — see setup below)
- Brevo account for SMTP email delivery
- OpenAI API key for the AI chat widget

---

## Project Structure

```
sinergy-philippines/
├── img/
│   ├── favicon.png
│   ├── sinergy-logo.png
│   └── sinergy-logo-white.png
├── PHPMailer/
│   └── src/
│       ├── Exception.php
│       ├── PHPMailer.php
│       └── SMTP.php
├── .htaccess                # Clean URL routing (mod_rewrite)
├── config.php               # Credentials — NOT committed (gitignored)
├── config.sample.php        # Credential template — copy to config.php
├── header.php               # Shared page head + site header
├── footer.php               # Shared footer + AI chat widget + script tag
├── nav.php                  # Navigation with active link highlighting
├── styles.css               # All styles (global + per-page + modal + chat)
├── script.js                # Nav, forms, application modal, AI chat
├── index.php                # Home page
├── services.php             # Services overview
├── industries.php           # Industries we support
├── how-it-works.php         # Process and workflow
├── why-sinergy.php          # Why choose Sinergy
├── about.php                # About the company
├── careers.php              # Job listings + application modal
├── contact.php              # Quote request form
├── customer-support.php     # Customer support service page
├── technical-support.php    # Technical support service page
├── sales-services.php       # Sales services page
├── data-entry-verification.php
├── data-annotation.php
├── privacy-policy.php
├── terms-of-service.php
├── contact-handler.php      # Handles quote form submission
├── application-handler.php  # Handles job application + resume upload
└── chat-handler.php         # Handles AI chat (OpenAI API + booking emails)
```

---

## Setup

### 1. Copy config file

```bash
cp config.sample.php config.php
```

Fill in all values in `config.php` — it is gitignored and never committed.

### 2. Install PHPMailer (manual)

Download the latest release from:
`https://github.com/PHPMailer/PHPMailer/releases/latest`

Extract and copy the `src/` folder into the project:

```
sinergy-philippines/
└── PHPMailer/
    └── src/
        ├── Exception.php
        ├── PHPMailer.php
        └── SMTP.php
```

### 3. Configure credentials in config.php

```php
// Brevo SMTP — get from brevo.com → Settings → SMTP & API
define('SMTP_HOST',    'smtp-relay.brevo.com');
define('SMTP_PORT',    587);
define('SMTP_USER',    'your-brevo-login@email.com');
define('SMTP_PASS',    'your-brevo-smtp-key');

// Email addresses
define('FROM_EMAIL',   'admin@sinergyph.com');
define('ADMIN_EMAIL',  'admin@sinergyph.com');
define('CAREERS_EMAIL','careers@sinergyph.com');

// OpenAI — get from platform.openai.com/api-keys
define('OPENAI_API_KEY', 'sk-proj-...');
```

### 4. Get Brevo SMTP credentials

1. Create free account at [brevo.com](https://brevo.com)
2. Go to **Settings → SMTP & API → Generate SMTP key**
3. Copy the SMTP login and key into `config.php`

### 5. Verify sender in Brevo

Emails sent FROM `admin@sinergyph.com` require sender verification:

- **Option A (quick):** Brevo → Senders & IP → Senders → Add `admin@sinergyph.com` → verify via email
- **Option B (recommended):** Brevo → Senders & IP → Domains → Add `sinergyph.com` → add DNS records → covers all `@sinergyph.com` addresses

### 6. Get OpenAI API key

1. Create account at [platform.openai.com](https://platform.openai.com)
2. Go to **API Keys → Create new secret key**
3. Add billing credits (minimum $5 — sufficient for thousands of conversations)
4. Paste key into `config.php`

---

## Clean URLs

`.htaccess` strips `.php` from all page URLs via Apache `mod_rewrite`:

| Requested URL | Serves |
|---|---|
| `/about` | `about.php` |
| `/contact` | `contact.php` |
| `/how-it-works` | `how-it-works.php` |

Old `.php` URLs redirect 301 to the clean version. POST requests to handlers (`contact-handler.php`, `application-handler.php`, `chat-handler.php`) are unaffected.

To enable HTTPS redirect, uncomment these lines in `.htaccess`:
```apache
# RewriteCond %{HTTPS} off
# RewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [R=301,L]
```

---

## How Forms Work

### Quote Request (/contact)

1. User fills form and submits
2. `script.js` sends POST via `fetch()` to `contact-handler.php`
3. Handler validates fields, sends two emails via PHPMailer:
   - Admin notification → `admin@sinergyph.com` (full form data)
   - Auto-reply → requester's email (confirmation with inquiry summary)
4. JSON response shown inline

### Job Application (/careers)

1. User clicks any Apply button → modal opens with role pre-filled
2. User fills form and attaches resume (PDF, DOC, DOCX — max 5 MB)
3. `script.js` sends POST via `fetch()` to `application-handler.php`
4. Handler validates fields + file, sends two emails via PHPMailer:
   - Careers notification → `careers@sinergyph.com` (applicant details + resume attachment)
   - Auto-reply → applicant's email (confirmation)
5. JSON response shown inside modal

### AI Chat Widget (all pages)

1. Floating chat button appears bottom-right on every page
2. Powered by OpenAI `gpt-4o-mini` via `chat-handler.php`
3. Answers questions about Sinergy's services
4. When visitor wants to book a discovery call, chat collects:
   - Full name, email, preferred date/time, service interest
5. On booking completion, sends two emails via PHPMailer:
   - Admin notification → `admin@sinergyph.com` (booking details)
   - Auto-reply → visitor's email (confirmation)

---

## Pages

| URL | File | Description |
|---|---|---|
| `/` | `index.php` | Home — hero, services overview, how it works, CTA |
| `/services` | `services.php` | All 5 service areas overview |
| `/customer-support` | `customer-support.php` | Service detail page |
| `/technical-support` | `technical-support.php` | Service detail page |
| `/sales-services` | `sales-services.php` | Service detail page |
| `/data-entry-verification` | `data-entry-verification.php` | Service detail page |
| `/data-annotation` | `data-annotation.php` | Service detail page |
| `/industries` | `industries.php` | Industries Sinergy supports |
| `/how-it-works` | `how-it-works.php` | Engagement and workflow process |
| `/why-sinergy` | `why-sinergy.php` | Differentiators and positioning |
| `/about` | `about.php` | Company story, mission, values |
| `/careers` | `careers.php` | Job openings and application modal |
| `/contact` | `contact.php` | Quote request form |
| `/privacy-policy` | `privacy-policy.php` | Privacy notice |
| `/terms-of-service` | `terms-of-service.php` | Website terms |

---

## PHP Partials

| File | Purpose |
|---|---|
| `header.php` | DOCTYPE, head (meta, favicon, CSS), site header with logo and nav |
| `footer.php` | Footer links, copyright year, AI chat widget HTML, script tag |
| `nav.php` | Navigation links with active state — uses `str_replace('.php', '', basename($_SERVER['PHP_SELF']))` |

Each page sets variables before including `header.php`:

```php
<?php
$page_title = 'Page Title';   // Sets <title> tag
$page_class = 'page-slug';    // Optional — adds class to <body> for scoped CSS
include 'header.php';
?>
```

---

## Contact

| Purpose | Email |
|---|---|
| General inquiries | hello@sinergy.com |
| Careers | careers@sinergyph.com |
| Admin / forms | admin@sinergyph.com |
