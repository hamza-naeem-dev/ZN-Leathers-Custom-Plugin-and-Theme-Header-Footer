# ZN Leathers — WordPress Website

A fully custom WordPress website built for **ZN Leathers**, a premium handcrafted leather goods brand based in Lahore, Pakistan. The site showcases the brand's artisan collections, craft philosophy, and provides a bespoke inquiry system for customers.

---

## Live Preview

![ZN Leathers Website](./fullwebsite.png)

---

## Project Overview

| Detail | Info |
|---|---|
| **Platform** | WordPress (Self-hosted) |
| **Theme** | Blocksy Child Theme (custom) |
| **Plugin** | ZN Contact Form (custom-built) |
| **Est. Founded** | 2014 · Lahore, Pakistan |
| **Developer** | Hamza Naeem |

---

## Features

### Theme — Blocksy Child
- Custom **header** with transparent-to-solid scroll transition
- Sticky navigation with smooth scroll behaviour
- Responsive **burger menu** for mobile and tablet viewports
- Custom **footer** with brand info, collection links, and CTA button
- `Playfair Display` serif typography throughout for an editorial feel
- Gold (`#EAB308`) and warm brown (`#1a1612`) brand colour palette
- Fully responsive layout via CSS media queries (breakpoint at 1024px)

### Plugin — ZN Contact Form
A purpose-built WordPress plugin (`ZN Contact Form`) that handles all customer inquiries end-to-end.

**Form Fields**
- Full Name, Email Address, Mobile Number
- Query Type (General Inquiry / Bulk Order / Custom Design / Product Question)
- Description / Message
- Optional file attachment (JPEG, PNG, DOCX, PDF)

**Under the Hood**
- AJAX form submission (no page reload)
- WordPress nonce verification for CSRF protection
- Honeypot field + time-based bot detection
- Server-side input sanitization (`sanitize_text_field`, `sanitize_email`, `absint`)
- File uploads handled via `wp_handle_upload()`
- Submissions saved to a custom database table (`wp_leather_product_queries`) using `$wpdb` and `dbDelta()`
- Email notifications sent to the business via `wp_mail()` with the uploaded file as an attachment
- Client-side email validation with real-time feedback

---

## Project Structure

```
/
├── blocksy-child/               # Child theme
│   ├── style.css                # Theme declaration + all custom CSS
│   ├── functions.php            # Asset enqueuing + theme support
│   ├── header.php               # Custom header template
│   └── footer.php               # Custom footer template
│
└── zn-contact-form/             # Custom plugin
    ├── zn-contact-form.php      # Plugin bootstrap (constants, hooks, DB setup)
    └── includes/
        ├── class_zn_cf_plugin.php   # Shortcode + AJAX form handler
        ├── script.js                # AJAX fetch, validation, burger menu, scroll
        └── style.css                # Contact form styles
```

---

## Plugin Usage

The contact form is embedded anywhere on the site using a shortcode:

```
[zncfdesign]
```

On **activation**, the plugin automatically creates the custom database table. On **deactivation**, rewrite rules are flushed cleanly.

---

## Security Measures

- **Nonce verification** on every form submission
- **Honeypot field** — a hidden input that bots tend to fill, humans don't
- **Time-check** — submissions under 3 seconds are flagged as bots
- **File type whitelist** — only JPEG, PNG, DOCX, and PDF are accepted
- **Server-side sanitization** on all user inputs before database insertion

---

## Tech Stack

| Layer | Technology |
|---|---|
| CMS | WordPress |
| Theme Base | Blocksy |
| Styling | Custom CSS (no framework) |
| Scripting | Vanilla JavaScript |
| Backend | PHP (OOP) |
| Database | MySQL via `$wpdb` |
| Email | `wp_mail()` |
| Fonts | Google Fonts — Playfair Display |

---

## Website Sections

1. **Hero** — Full-width banner with brand tagline and CTA
2. **The Collection** — Four flagship product showcases (Sovereign, Diplomat, Vermillion Lady, Corporate Set)
3. **The Craft** — Editorial section on hand-stitching, vegetable tanning, and legacy
4. **Contact / Bespoke Inquiries** — Custom AJAX contact form
5. **Footer** — Brand info, navigation, collection links, and CTA

---

## Author

**Hamza Naeem**
WordPress Developer · MSc Cybersecurity

---

## License

This project is private and proprietary. All design, code, and content belong to ZN Leathers and the developer. Not licensed for redistribution.
