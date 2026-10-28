# Foo Foo & Me — WordPress Theme

A hand-built, bilingual (English / Arabic RTL) WordPress theme for **Foo Foo & Me**, the home of the *Little Bunny Foo Foo* storybook series set in Saudi Arabia. It features cinematic desert hero scenes, 3D book covers, read-aloud players, downloadable activities and a contact form, with everything editable from the WordPress Customizer. It needs no page builder and no plugins.

- **Theme slug / folder:** `little-bunny-foo-foo`
- **Version:** 1.2.4
- **Requires:** WordPress 6.0+, PHP 7.4+
- **License:** GPL-2.0-or-later

---

## Features

- **Cinematic home hero:** a desert video background with a light grade and sand particles, a floating 3D book cover and a slider of places.
- **Brand pillars:** three arch-shaped buttons in the hero (*Joy for Children*, *Memories for Families*, *A Lifelong Love of Discovery*), each linking to one part of the site.
- **English / Arabic without a plugin:** Arabic lives under `/ar/` and switches the site to right-to-left with Arabic fonts. It also outputs `hreflang` tags for search engines.
- **3D book covers:** they tilt toward the mouse, add a light glare, and fly between pages on page transitions.
- **Page transitions and loading screen:** uses View Transitions where the browser supports them and falls back to a sliding curtain.
- **Image slots:** every photo is chosen in the Customizer. Empty slots show a drawn SVG desert illustration, so the site never looks broken.
- **Activities post type:** downloadable PDFs listed on the Explore page.
- **Contact form and newsletter:** messages are saved in the dashboard and emailed. Newsletter sign-ups can be exported as CSV.
- **WooCommerce-ready:** if WooCommerce is installed, shop pages render inside the theme layout.
- **Self-hosted fonts:** Cormorant Garamond, Manrope, Amiri and IBM Plex Sans Arabic. There are no Google requests and no jQuery.

## Site navigation

The main navigation (desktop header and mobile menu) is defined in code, in `lbff_primary_nav()` in [`inc/template-tags.php`](inc/template-tags.php). Changing it does not require editing a menu in WP Admin.

| Nav label | Opens | URL |
|---|---|---|
| Home | Home (front page) | `/` |
| The Books | The Books template | `/the-books/` |
| Workshops & Field Trips | Explore template | `/explore/` |
| Our Story | Meet Foo Foo template | `/meet-foo-foo/` |
| Shop | Buy section of The Books | `/the-books/#buy` |

The hero pillar buttons are defined in `lbff_hero_pillars()` in the same file:

| Pillar | Links to |
|---|---|
| Joy for Children | The Books |
| Memories for Families | Workshops & Field Trips (Explore) |
| A Lifelong Love of Discovery | Our Story (Meet Foo Foo) |

Every Arabic URL is the English URL with `/ar` in front, for example `/ar/the-books/`.

## Installation

### Option A: WordPress dashboard
1. Build a zip (see [Building a release zip](#building-a-release-zip)).
2. Go to **Appearance → Themes → Add New → Upload Theme**, choose the zip, then **Install** and **Activate**.
   If the theme is already active, choose **Replace current with uploaded**.
3. Go to **Settings → Permalinks**, select **Post name**, and click **Save**.

### Option B: SFTP
Upload the `little-bunny-foo-foo` folder to `wp-content/themes/`, overwriting the old copy if there is one.

On first activation the theme creates the pages **Home**, **Meet Foo Foo**, **The Books** and **Explore** with the right templates, and sets Home as the front page.

After every update, flush the host cache (GoDaddy: **Flush Cache** in the WP Admin top bar) and hard-refresh the browser.

## Building a release zip

The theme has no build step: CSS and JS are plain files loaded directly. A release is a zip of the theme folder.

```bash
git archive --format=zip --prefix=little-bunny-foo-foo/ -o little-bunny-foo-foo.zip HEAD
```

Development-only files (`README.md`, `.gitignore`, `.gitattributes`) are left out of the zip by `.gitattributes`.

**Before each release,** bump the version in **both** places so browsers and the host cache load the new CSS and JS:
- `define( 'LBFF_VERSION', 'x.y.z' );` in [`functions.php`](functions.php)
- `Version:` in [`style.css`](style.css)

## Editing content

**Appearance → Customize →**

| Panel | What you can change |
|---|---|
| Foo Foo — Settings → Brand & contact | Logo text, public email, where form messages go |
| Foo Foo — Settings → Store & social links | Amazon, Kindle, Instagram, YouTube, Facebook, Privacy and Terms links |
| Foo Foo — Settings → Desert hero scene | Background video (MP4 upload or URL), poster image, sand particles |
| Foo Foo — Settings → Book 01 | Cover, title, blurb, author, illustrator, ages, formats |
| Foo Foo — Settings → Read-aloud & videos | MP3 for the audio players, video links |
| Foo Foo — Settings → Footer | Heading, newsletter text, copyright |
| Foo Foo — Settings → Arabic texts | Arabic versions of the Customizer texts, and the switch to turn Arabic on or off |
| Foo Foo — Page Images | Every photo on every page, grouped by page |

Texts written in the templates (hero copy, section headings and similar) are edited in the matching file under `template-parts/`. Their Arabic translations are in `languages/ar.php`.

## English / Arabic

- [`inc/i18n.php`](inc/i18n.php) detects `/ar/` at the start of the URL, removes it, and serves the normal page in Arabic. Arabic does not need separate pages.
- Theme strings use `__( 'English text', 'littlebunny' )`. The Arabic dictionary in [`languages/ar.php`](languages/ar.php) maps each English string to Arabic.
- To add or change a translation, add or edit an `'English' => 'Arabic'` line in `languages/ar.php`. The English key must match the string in the template exactly, including `<br>` and `<em>` tags.
- Content typed in the page or post editor is not translated automatically. Add a plugin such as Polylang if separate Arabic posts are needed.

## Project structure

```
little-bunny-foo-foo/
├── style.css               Theme header (name, version)
├── functions.php           Constants + loads everything in /inc
├── front-page.php          Home (sections from template-parts/home/)
├── page.php, single.php, index.php, 404.php, woocommerce.php …
├── page-templates/         The Books, Explore, Meet Foo Foo
├── template-parts/
│   ├── global/             Nav, footer, page hero, book cover, desert scene, loader
│   ├── home/               hero, intro, featured, meet, world, ages, listen, series, cta
│   ├── books/              hero, book, series, listen, buy
│   ├── explore/            hero, listen, activities, ages, educators, experiences, contact
│   ├── meet/               hero, who, discovery, journey, ages, educators, author, credits
│   └── content/            Blog loop items
├── inc/
│   ├── i18n.php            English / Arabic switch
│   ├── setup.php           Theme supports, menus, image sizes, editor palette
│   ├── enqueue.php         Styles, scripts, font preloads
│   ├── template-tags.php   Helpers + nav and hero pillar config
│   ├── customizer.php      Customizer panels
│   ├── image-slots.php     Registry of every editable image
│   ├── illustrations.php   SVG fallback scenes
│   ├── post-types.php      Activities post type
│   ├── forms.php           Contact form + newsletter handlers
│   ├── activation.php      Creates pages + menu on theme activation
│   └── woocommerce.php     WooCommerce compatibility
├── languages/ar.php        Arabic translations
└── assets/
    ├── css/main.css        All styles (tokens → components → responsive → RTL)
    ├── js/main.js          All interactions (vanilla JS)
    ├── fonts/              Self-hosted WOFF2 fonts
    └── images/             Default book cover
```

Every page is assembled from section partials, so a section can be reordered or removed with a filter, for example:

```php
add_filter( 'lbff_home_sections', function ( $sections ) {
	return array_diff( $sections, array( 'listen' ) );
} );
```

Available filters: `lbff_home_sections`, `lbff_books_sections`, `lbff_explore_sections`, `lbff_meet_sections`.

## Design tokens

Brand colours are CSS variables in `assets/css/main.css` (`:root`) and are also registered as the block-editor palette. Use these tokens rather than new colours.

| Token | Hex | Use |
|---|---|---|
| `--ff-teal` | `#073B46` | Primary dark / brand blue |
| `--ff-deep` | `#04262E` | Deepest teal |
| `--ff-gold` | `#E8C08D` | Peach / gold accent |
| `--ff-cream` | `#F7F2E8` | Page background, light text |
| `--ff-sand` | `#EDE3D0` | Alternate section background |
| `--ff-copper` | `#A86A36` | Italic accents on light backgrounds |
| `--ff-ink` | `#182321` | Body text |

Fonts: **Cormorant Garamond** (display) and **Manrope** (UI) in English; **Amiri** and **IBM Plex Sans Arabic** in Arabic.

## Recommended plugins (optional)

- An SMTP plugin (e.g. WP Mail SMTP), so contact-form emails reach the inbox reliably
- An SEO plugin (Yoast SEO or Rank Math)
- WooCommerce, to sell directly on the site

## Credits

- Theme design and development: M Hamad
- Fonts: Cormorant Garamond, Manrope, Amiri, IBM Plex Sans Arabic, all under the SIL Open Font License 1.1
- Default hero video: Pexels (free to use; replace it in the Customizer)

## License

GPL-2.0-or-later. See <https://www.gnu.org/licenses/gpl-2.0.html>.
