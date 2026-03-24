Dealer Specials Plugin
WordPress plugin that renders a car dealership specials grid from JSON (originally loaded from a remote admin API). This repo is kept as a design and implementation archive. The original live site and backing database are no longer available, so the remote data source in the code may not work.

What it is:
Plugin: car-dealership-deals.php (header: Car Dealership Deals Display, v2.9).
Shortcode: [car_deals] outputs deal cards (title, APR, image, lease/finance/buy style rows, CTAs).
Assets: assets/css/car-deals.css, images under assets/images/, sample structure in assets/data/deals.json.
Note: assets/js/car-deals.js is enqueued but is currently empty.
How data was meant to load
The plugin calls wp_remote_get() against a URL on admin.zyvexia.net and parses the response as JSON. There is a path to assets/data/deals.json in the file, but the active path uses the HTTP response body, not the local file, unless you change the code.

Sample / reference payloads live in assets/data/deals.json (array of deals with title, apr, car_image, car_data, details[] with label, price, term).

WordPress usage:
Copy the plugin folder into wp-content/plugins/ (or zip and install).
Activate Car Dealership Deals Display.
Add the shortcode [car_deals] to a page or post.
Styles and scripts are registered on wp_enqueue_scripts.

Without the old site or API:
Remote requests will fail or return nothing; you may see No car deals available at the moment unless you point the plugin at a working endpoint or refactor it to read deals.json (or another source) locally.
Hardcoded links and phone numbers in the PHP (dealer site, contact/finance URLs) are from the original project and should be updated or removed if you reuse this.

Security note:
The PHP file contains a hardcoded API key in the request URL which no longer works.

Requirements:
WordPress with standard plugin hooks.
PHP with wp_remote_get / JSON available (typical WordPress hosting).

Author:
David Mroz.
