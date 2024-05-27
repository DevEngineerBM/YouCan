require('./bootstrap');
import { createApp } from 'vue'
import App from './App.vue'
import router from './Router' 


const app = createApp(App)
  .use(router)
  .mount('#app');