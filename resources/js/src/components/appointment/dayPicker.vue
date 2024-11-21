<template>
  <div class="form__container-date "> 
    <n-card  class="host-page px-0 w-100 h-100" style="max-height:100%" >
      <div>
        <div class="flex justify-between items-center w-100 title__container">
          <div class=" text-h5 " style="margin-bottom:5px; width: 70%">Selecciona la fecha y la hora de tu consulta🩺 </div>
          <div class=" text-h5 " style="margin-bottom:5px">Paso 2/3</div>
        </div>
        <div class=" text-h2 w-100 text-bold title2__container" >Selecciona el día</div>
        <div class=" text-h5" style="margin-bottom:15px;">Los cupos de cita por dias son limitados por semana*</div>

        <div class="">
          <DatePicker 
            v-model="dateAppointment" 
            :disabled-dates="disabledDates" 
            :color="'green'"  
            style="width: 100%;" 
            :min-date="new Date()" 
            :max-date="moment().add(setLefDay(), 'days').format()" 
            is-required
            @update:modelValue="getAvaibleHour"
            class="appointment-calendar"
            :attributes="attributes"
          />
        </div>
        <div class="footer__container">
          <div class="footer__section">
            <n-select
                v-model:value="hourAppointment"
                filterable
                clearable
                placeholder="Selecciona la hora"  
                size="large"
                label-field="hour"
                value-field="id"
                style=""
                menu-size="large"
                :options="avaibleHour"
                :disabled="avaibleHour.length == 1 "
                @update:value="validateDayTime"
              />
          </div>
          <div class="footer__section" style=" display: flex; align-items: end; flex-direction: column"> 
            <div class="text-h5 text-bold" style="margin-top:1.5rem">Fecha Seleccionada</div>
            <div style="font-size: 1.2rem;margin-top:0.5rem">
              {{  dateAppointment ? moment(dateAppointment).format('DD/MM/YYYY') : '--/--/----' }}  
              {{ hourAppointment == 0 ? '--:-- --' : avaibleHour.find((hour) => hour.id == hourAppointment).hour }}
            </div>
          </div>
        </div>
      </div>
    </n-card>
  </div>
</template>
<script>
import { defineComponent, onMounted, ref, watch, inject} from "vue";
import { useMessage } from "naive-ui";
import { useTicketStore } from "@/services/store/ticket.store";
import { Calendar, DatePicker } from 'v-calendar';
import 'v-calendar/style.css';

export default defineComponent({
  components: {
    Calendar,
    DatePicker,
  },
  props: {
    'departament': Number,
  },
  emits: ['selectedDayTime'],
  setup (props, { emit }) {
    const moment = inject('moment')
    const ticketStore = useTicketStore()
    const departament =  props.departament;  
    const dateAppointment = ref('')
    const hourAppointment = ref(0)
    const disabledDates = ref([])
    const avaibleHour = ref([
      {id:0, hour:'Selecciona la hora de tu cita'},
    ])

    const getAvaibleHour = () => {
      resetHour()
      const data = {
        day:    moment(dateAppointment.value).format('D'),
        month:  moment(dateAppointment.value).format('M'),
        departament,
      }

      ticketStore.getAvaibleHoursByDay(data)
      .then((response) =>{
        avaibleHour.value = [
          {id:0, hour:'Selecciona la hora de tu cita'},
          ...response.data
        ]
      })
      .catch((response) => {
        console.log(response)

      })
    }
    const setLefDay = ()  => {
      return 7 - parseInt(moment().format('d')) -2
    }
    const dotDays = () => {
      const leftDays = setLefDay()
      const attributes = []
      for (let index = 0; index < leftDays+1 ; index++) {
        attributes.push(
          {
            key: 'today',
            dot: true,
            dates: new Date(moment().format('YYYY'), moment().format('MM')-1, parseInt(moment().format('DD')) + index)
          
          }
        )
        
      }
      return attributes;
    }
    const resetHour = () => {
      hourAppointment.value = 0
      avaibleHour.value = [
        {id:0, hour:'Cargando...'},
      ] 
      validateDayTime()
    }
    const validateDayTime = () =>  {
      let check = true
      if(!dateAppointment.value) check = false
      if(!hourAppointment.value) check = false

      emit('selectedDayTime', { 
        day:  dateAppointment.value, 
        time: avaibleHour.value.find((hour) => hour.id == hourAppointment.value).hour, 
        check
      })
      
    }
    const getNotAvaibleDay = () => {
      
      
      const data = {
        days: formatDatepost(),
        departament: departament
      }

      ticketStore.getNotAvaibleDay(data)
      .then((response) =>{
        disabledDates.value = formatDate(response.data)
      })
      .catch((response) => {
        console.log(response)

      })
    }

    const formatDatepost = () => {
      let days = []
      for (let index = 0; index < setLefDay()+1; index++) {
        days.push(moment().add(index, 'days').format())
      }
      return JSON.stringify(days)
    }

    const formatDate = (dates) => {
      let datesFormatted = []
      dates.forEach(date => {
        datesFormatted.push(new Date(date))
      });

      return datesFormatted
    }

    onMounted(() => {
      getNotAvaibleDay()
    })
    return {
      dateAppointment,
      disabledDates,
      hourAppointment,
      avaibleHour,
      moment,
      getAvaibleHour,
      setLefDay,
      validateDayTime,
      attributes:dotDays()
    };
  }
});
</script>
<style lang="scss">
  .footer__container{
    display: flex;
    align-items: center;
    flex-wrap: wrap;
  }
  .footer__section{
    width: 50%;
  }
  .n-base-select-menu .n-base-select-option.n-base-select-option--show-checkmark{
    margin-top: 10px;
  }

  .form__container-date{
    padding: 0px 15%;
    & .n-card.n-card--bordered {
      padding: 0px 0%;
    }
  }
  .appointment-calendar {
    & .vc-day-box-center-center{
      width: auto!important;
    }
    & .vc-header{

      height: 50px;
    }
    & .vc-attr{
      font-size: 20px;
      height: 42px;
      width: 42px;
    }
    & .vc-title{
      font-size: 20px;
      height: 40px;
      margin-bottom: 20px;

    }
    & .vc-highlight{
      height: 32px;
      width: 32px;
    }
    & .vc-dot{
      width: 5px!important;
      height: 5px!important;
      transform: translateY(0.2rem);
    }
  }
  
  @media screen and (max-width: 780px){ 
    .footer__container{
      margin-top: 1rem;
    }
    .footer__section{
      width: 100%;
      align-items:start!important
    }
    .form__container-date{
      padding: 0px 2%;
      & .n-card.n-card--bordered {
        padding: 0px 5%;
      }
    }
    .items__ticket-form{
      width:100%;
      &:nth-child(even){
        padding-left: 0px;
      }
    }
  }
</style>