import App from '@/App.vue'
import { createApp } from 'vue'
import { createPinia } from "pinia";
import router from "@/routes/index";
import { Picker } from 'vant';
import { Switch } from 'vant';
import naive from 'naive-ui/es/preset';
import mitt from 'mitt'
import 'vant/lib/index.css';
import '@/assets/scss/template.scss'
import naiveUI from 'naive-ui'
import Provider from '@/components/provider.vue'

const emitter = mitt()
const app = createApp(Provider)


app.use(createPinia())
app.use(router)
app.use(naiveUI)
app.use(Picker);
app.use(Switch);
app.provide('emitter', emitter)

app.mount('#app')