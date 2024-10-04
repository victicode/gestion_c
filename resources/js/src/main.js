
import '@/assets/scss/template.scss'
import { createApp } from 'vue'
import { createPinia } from "pinia";
import router from "@/routes/index";
import { Picker } from 'vant';
import { Switch } from 'vant';
import mitt from 'mitt'
import 'vant/lib/index.css';
import naiveUI from 'naive-ui'
import Provider from '@/components/provider.vue'
import moment from 'moment';
import 'moment/locale/es';
moment.updateLocale('es', 
  {
    months: 'Enero_Febrero_Marzo_Abril_Mayo_Junio_Julio_Agosto_Septiembre_Octubre_Noviembre_Diciembre'.split('_'),
    monthsShort: 'Enero._Feb._Mar_Abr._May_Jun_Jul._Ago_Sept._Oct._Nov._Dec.'.split('_'),
    weekdays: 'Domingo_Lunes_Martes_Miercoles_Jueves_Viernes_Sabado'.split('_'),
    weekdaysShort: 'Dom._Lun._Mar._Mier._Jue._Vier._Sab.'.split('_'),
    weekdaysMin: 'Do_Lu_Ma_Mi_Ju_Vi_Sa'.split('_')
  }
);

const emitter = mitt()
const app = createApp(Provider)


app.use(createPinia())
app.use(router)
app.use(naiveUI)
app.use(Picker);
app.use(Switch);
app.provide('emitter', emitter)
app.provide('moment', moment)


app.mount('#app')