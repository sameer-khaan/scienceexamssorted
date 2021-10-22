// import external dependencies
import 'jquery';
import 'jquery-inview/jquery.inview.js';
import 'sticky-kit/dist/sticky-kit.min.js';
import 'objectFitPolyfill/dist/objectFitPolyfill.min.js';

// Import everything from autoload
import './autoload/**/*';

import './nav.js';
import './home-banner.js';
import './text-animation.js';
import './woocommerce.js';
import './ajax.js';

// import local dependencies
import Router from './util/Router';
import common from './routes/common';
import home from './routes/home';
import aboutUs from './routes/about';

/** Populate Router instance with DOM routes */
const routes = new Router({
  // All pages
  common,
  // Home page
  home,
  // About Us page, note the change from about-us to aboutUs.
  aboutUs,
});

// Load Events
jQuery(document).ready(() => routes.loadEvents());
