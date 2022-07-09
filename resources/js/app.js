import './bootstrap';
import './../css/app.css';

import { createApp, h } from 'vue'
import { createInertiaApp, Link, Head } from '@inertiajs/inertia-vue3'
import Layout from "./Shared/Layout";

createInertiaApp({
  resolve: async name => {
    let page = (await import(`./Pages/${name}`)).default;
    if (page.layout != ""){
      page.layout = Layout;
    }
    return page;
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .component('Link', Link)
      .component('Head', Head)
      .use(plugin)
      .mount(el)
  },
  title: title => "My App - " + title,
})

import { InertiaProgress } from '@inertiajs/progress'

InertiaProgress.init({
  // The delay after which the progress bar will
  // appear during navigation, in milliseconds.
  delay: 100,

  // The color of the progress bar.
  color: '#29d',

  // Whether to include the default NProgress styles.
  includeCSS: true,

  // Whether the NProgress spinner will be shown.
  showSpinner: true,
})