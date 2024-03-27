import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'

import PrimeVue from 'primevue/config';
import 'primevue/resources/themes/saga-blue/theme.css';
import 'primevue/resources/primevue.min.css';
import 'primeicons/primeicons.css';
import Tooltip from 'primevue/tooltip';

const app = createApp(App)

app.use(PrimeVue)
app.directive('tooltip', Tooltip);

const pinia = createPinia()

pinia.use((context) => {

    const storeID = context.store.$id

    const serilizer = {
        serialize: JSON.stringify,
        deserialize: JSON.parse
    }

    // sync store from localstorage
    const fromStorage = serilizer.deserialize(window.localStorage.getItem(storeID))

    if (fromStorage) {
        context.store.$patch(fromStorage)
    }

    // listen for changes and update localstorage
    context.store.$subscribe((mutation, state) => {
        console.log(mutation, state);
        window.localStorage.setItem(storeID, serilizer.serialize(state));
    })
})

app.use(pinia)
app.use(router)
app.config.devtools = true

app.mount('#app')

