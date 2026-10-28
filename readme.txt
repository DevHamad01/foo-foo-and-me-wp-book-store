=== Little Bunny Foo Foo ===
Contributors: M Hamad
Requires at least: 6.0
Tested up to: 6.8
Requires PHP: 7.4
Version: 1.2.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A fully custom storybook theme for the Little Bunny Foo Foo book series.

== Installation ==

1. Appearance → Themes → Add New → Upload Theme → choose little-bunny-foo-foo.zip → Install → Activate.
2. On activation the theme automatically:
   • creates the pages Home, Meet Foo Foo, The Books and Explore (with the right templates),
   • sets Home as the front page,
   • builds the "Main menu" and assigns it to the footer.
   The header navigation (Home | The Books | Workshops & Field Trips | Our Story | Shop)
   is set in code — see lbff_primary_nav() in inc/template-tags.php.
3. Settings → Permalinks → choose "Post name" and Save (for clean URLs like /the-books/).

== Editing content ==

Appearance → Customize →
  • Foo Foo — Settings
      Brand & contact ...... logo text, public email, where form messages go
      Store & social links . Amazon, Kindle, Instagram, YouTube, Facebook, Privacy/Terms
      Desert hero scene .... background video (upload an MP4 or paste a URL), poster, sand particles
      Book 01 .............. cover artwork, title, blurb, author, illustrator, ages, formats
      Read-aloud & videos .. MP3 for the audio players, video links
      Footer ............... heading, newsletter text, copyright
  • Foo Foo — Page Images
      Every photo on every page, grouped by page. Empty slots show a drawn
      desert illustration, so the site never looks broken.

Site Identity → upload a logo to replace the text logo.

== English / Arabic ==

  • English:  yoursite.com/the-books/      Arabic:  yoursite.com/ar/the-books/
  • The EN | عربي switch sits in the header and in the mobile menu.
  • Arabic pages switch to right-to-left layout with Amiri + IBM Plex Sans Arabic fonts.
  • All theme text is translated in languages/ar.php (edit the Arabic side to adjust wording).
  • Customize → Foo Foo — Settings → Arabic texts: Arabic versions of the book title,
    blurb, footer text etc., and a checkbox to turn the switch off.
  • Blog posts / page-editor content are not translated automatically — add Polylang later
    if the client wants to write separate Arabic posts.

== Premium touches ==

  • Loading screen on the first page of each visit (a little rabbit hops across a dune).
  • Smooth page transitions — the book cover "flies" between Home and The Books
    (Chrome, Edge, Safari 18+; other browsers get a sliding curtain).
  • 3D book covers tilt toward the mouse with a light glare.
  • Skeleton shimmer while photos, covers and the hero video load.
  • Hand-drawn style illustrations in every empty image slot (dunes, oasis, Medina,
    oryx, night camp, AlUla rocks, falcon, Foo Foo, map, colouring page …).
    They are replaced automatically once a real image is chosen in the Customizer.

== Dashboard additions ==

  • Activities ... downloadable PDFs for the Explore page (type, age group, free/paid, file).
                   Until you add some, the six example activities from the design are shown.
  • Messages ..... every contact-form message is saved here AND emailed to you.
  • Tools → Newsletter ... footer sign-ups, with "Export CSV" for Mailchimp / MailerLite.

== Recommended plugins (optional, add later) ==

  • An SMTP plugin (e.g. WP Mail SMTP) so contact emails reliably reach your inbox.
  • An SEO plugin (e.g. Yoast SEO or Rank Math).
  • A caching / image-optimisation plugin.
  • WooCommerce, if you later want to sell directly — the theme already wraps shop pages
    in its own design.

== Theme structure ==

  style.css ................ theme header
  functions.php ............ loads /inc
  inc/ ..................... setup, assets, customizer, image slots, activities, forms, activation
  page-templates/ .......... Meet Foo Foo, The Books, Explore
  front-page.php ........... Home
  template-parts/ .......... one file per page section (global, home, meet, books, explore, content)
  assets/css/main.css ...... all styles (tokens, components, responsive)
  assets/js/main.js ........ all interactions (no jQuery)
  inc/i18n.php ............. English / Arabic switch
  inc/illustrations.php .... drawn SVG scenes for empty image slots
  languages/ar.php ......... Arabic translations
  assets/fonts/ ............ self-hosted Cormorant Garamond, Manrope, Amiri, IBM Plex Sans Arabic
  assets/images/ ........... default book cover

== Credits ==

Fonts: Cormorant Garamond, Manrope, Amiri, IBM Plex Sans Arabic — SIL Open Font License 1.1.
Default hero video and poster: Pexels (free to use) — replace them in the Customizer any time.
