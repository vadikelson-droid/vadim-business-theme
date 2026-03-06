# 🎨 Vadim Business Theme

![Preview](preview.png)

> Custom WordPress theme built from scratch — no page builders, no frameworks.

## Live Demo
🌐 [http://91.219.61.4/wordpress/](http://91.219.61.4/wordpress/)

## Features

| Feature | Details |
|---------|---------|
| **Customizer API** | Hero section, stats bar, CTA, brand colors — all editable from admin |
| **Custom Post Types** | Services, Portfolio, Testimonials, Team |
| **Custom Taxonomies** | Portfolio Categories, Service Categories |
| **Meta Boxes** | Built without ACF — pure PHP with nonces & sanitization |
| **AJAX** | Portfolio filtering, live search — no page reload |
| **WooCommerce** | Full support (product gallery, zoom, lightbox) |
| **Responsive** | Mobile-first, works on all devices |
| **Animations** | Scroll reveal, smooth transitions |

## Theme Structure

```
vadim-business/
├── style.css              # Theme styles + metadata
├── functions.php          # Setup, CPT, Customizer, scripts
├── header.php             # Navigation + custom logo
├── footer.php             # CTA section + footer widgets
├── front-page.php         # Homepage (hero, services, portfolio, testimonials)
├── index.php              # Blog archive
├── single.php             # Single post
├── page.php               # Static page
├── 404.php                # Error page
├── inc/
│   ├── meta-boxes.php     # Custom meta boxes (no ACF)
│   ├── ajax-handlers.php  # AJAX portfolio filter + live search
│   └── taxonomies.php     # Custom taxonomies
└── js/
    └── main.js            # Reveal, scroll, AJAX, booking form
```

## Technologies
`PHP` `WordPress` `JavaScript` `CSS3` `AJAX` `REST API` `Customizer API`

## Author
**Vadim Dev** — [Portfolio](https://vadikelson-droid.github.io/vadim-portfolio/) | [Telegram](https://t.me/lord_elson_05)
