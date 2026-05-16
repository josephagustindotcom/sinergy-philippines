# Sinergy Philippines — Website

Philippines-based outsourcing company website. Built with PHP, vanilla CSS, and vanilla JavaScript. No framework, no database, no build step.

---

## Requirements

- PHP 7.4 or higher
- Web server with PHP support (Apache, Nginx, or local: XAMPP / Laragon)
- PHPMailer (manual install — see setup below)
- Brevo account for SMTP email delivery

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
├── header.php               # Shared page head + site header
├── footer.php               # Shared footer + script tag
├── nav.php                  # Navigation with active link highlighting
├── styles.css               # All styles (global + per-page)
├── script.js                # Mobile nav, forms, modal, dynamic dates
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
└── application-handler.php  # Handles job application submission
```

---

## Setup

### 1. Install PHPMailer (manual)

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

### 2. Configure SMTP credentials

Both handlers use Brevo SMTP. Update the credentials in each file:

**`contact-handler.php`** (lines 44–48)
```php
define('SMTP_USER',   'your-brevo-login@email.com');
define('SMTP_PASS',   'your-brevo-smtp-key');
define('ADMIN_EMAIL', 'admin@sinergyph.com');
```

**`application-handler.php`** (lines 55–60)
```php
define('SMTP_USER',    'your-brevo-login@email.com');
define('SMTP_PASS',    'your-brevo-smtp-key');
define('FROM_EMAIL',   'admin@sinergyph.com');
define('CAREERS_EMAIL','careers@sinergyph.com');
```

### 3. Get Brevo SMTP credentials

1. Create a free account at [brevo.com](https://brevo.com)
2. Go to **Settings → SMTP & API → Generate SMTP key**
3. Copy the SMTP login and key into the files above

### 4. Verify sender in Brevo

Emails sent FROM `admin@sinergyph.com` require sender verification:

- **Option A (quick):** Brevo dashboard → Senders & IP → Senders → Add `admin@sinergyph.com` → verify via email
- **Option B (recommended):** Brevo dashboard → Senders & IP → Domains → Add `sinergyph.com` → add DNS records → covers all `@sinergyph.com` addresses

---

## How Forms Work

### Quote Request (contact.php)

1. User fills form and submits
2. `script.js` sends POST via `fetch()` to `contact-handler.php`
3. Handler validates fields, sends two emails via PHPMailer:
   - Admin notification → `admin@sinergyph.com` (full form data)
   - Auto-reply → requester's email (confirmation with inquiry summary)
4. JSON response shown inline (success or error message)

### Job Application (careers.php)

1. User clicks any **Apply** button → modal opens with role pre-filled
2. User fills form and attaches resume (PDF, DOC, DOCX — max 5 MB)
3. `script.js` sends POST via `fetch()` to `application-handler.php`
4. Handler validates fields + file, sends two emails via PHPMailer:
   - Careers notification → `careers@sinergyph.com` (applicant details + resume attachment)
   - Auto-reply → applicant's email (confirmation)
5. JSON response shown inside modal

---

## Pages

| Page | File | Description |
|---|---|---|
| Home | `index.php` | Hero, services overview, how it works, CTA |
| Services | `services.php` | All 5 service areas overview |
| Customer Support | `customer-support.php` | Service detail page |
| Technical Support | `technical-support.php` | Service detail page |
| Sales Services | `sales-services.php` | Service detail page |
| Data Entry & Verification | `data-entry-verification.php` | Service detail page |
| Data Annotation | `data-annotation.php` | Service detail page |
| Industries | `industries.php` | Industries Sinergy supports |
| How It Works | `how-it-works.php` | Engagement and workflow process |
| Why Sinergy | `why-sinergy.php` | Differentiators and positioning |
| About | `about.php` | Company story, mission, values |
| Careers | `careers.php` | Job openings and application modal |
| Contact | `contact.php` | Quote request form |
| Privacy Policy | `privacy-policy.php` | Privacy notice |
| Terms of Service | `terms-of-service.php` | Website terms |

---

## PHP Partials

| File | Purpose |
|---|---|
| `header.php` | DOCTYPE, head (meta, favicon, CSS), site header with logo and nav |
| `footer.php` | Footer links, copyright year, script tag |
| `nav.php` | Navigation links with active state via `basename($_SERVER['PHP_SELF'])` |

Each page sets variables before including `header.php`:

```php
<?php
$page_title = 'Page Title';       // Sets <title> tag
$page_class = 'page-slug';        // Optional — adds class to <body> for scoped CSS
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
