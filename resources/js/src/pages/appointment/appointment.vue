<template>
  <div class="h-100">
    <div class="host-container">
      <transition name="horizontal">
        <div  class=" px-0 w-100 h-100 container__section" style="max-height:100%; " v-show="step==1">
          <clientForm  :dataClient="dataForTicket" @selectedUser="setClient" />
        </div>
      </transition>
      <transition name="horizontal">
        <div  class=" px-0 w-100 h-100 container__section" style="max-height:100%;" v-if="step==2">
          <dayPicker :departament="dataForTicket.departament_id"  @selectedDayTime="setDayTime" />
        </div>
      </transition>
      <transition name="horizontal ">
        <div  class=" px-0 w-100 h-100 container__section " style="max-height:100%;" v-if="step==3">
          <viewTicket :ticket="ticket" />
        </div>
      </transition>
    </div>
    <div  class="w-100 bottom-banner-app "  style="padding:0rem 0rem">
      <transition name="fadex">
        <div class="h-100 button__section" v-if="step!==1 && step!== 3 ">
          <n-button 
            color="#616161" 
            strong 
            round 
            size="large" 
            class="button_action__bottom_bar-app--back" 
            
            @click="step == 1 ? router.push('/host') : step--; validate=false"
          >
            Volver
          </n-button>
        </div> 
      </transition>
      <div class="h-100 button__section">
        <n-button 
          color="#fff" 
          strong 
          round 
          size="large" 
          class="button_action__bottom_bar-app" 
          :disabled="validate"
          @click="actionButton()"
          :loading="loading"
        >
          {{ step == 1 ? 'Siguiente' : step == 2 ? 'Generar Ticket' : 'Volver al inicio'  }}
        </n-button>
      </div>
    </div>
  </div>
</template>
<script>
  import { useTicketStore  } from '@/services/store/ticket.store';
  import clientForm from '@/components/appointment/clientForm.vue';
  import dayPicker from '@/components/appointment/dayPicker.vue';
  import { useRouter } from 'vue-router'
  import { ref } from 'vue'
  import { useMessage, useNotification } from 'naive-ui';
  import viewTicket from '@/components/host/ticket/viewTicket.vue';

  export default defineComponent({
  components: {
    clientForm,
    dayPicker,
    viewTicket,
  },
	setup () {
    const loading = ref(false)
    const ticketStore = useTicketStore();
    const ticket = ref({})
    const router = useRouter()
    const message = useMessage()
    const notification = useNotification()
    const step = ref(1)
    const validate = ref(true)
    const dataForTicket = ref({
      ci: '',
      name: '',
      phone: '', 
      email: '', 
      client_id: '',
      departament_id: 0,
      type:2,
    })


    const setClient = (client) => {
      dataForTicket.value.ci = client.ci;
      dataForTicket.value.name = client.name;
      dataForTicket.value.phone = client.phone;
      dataForTicket.value.email = client.email;
      dataForTicket.value.client_id = client.id;
      dataForTicket.value.departament_id = client.dep;
      validate.value = !client.check
    }

    const setDayTime = (data) => {
      dataForTicket.value.day = data.day;
      dataForTicket.value.time = data.time;
      validate.value = !data.check
    }
    const createTicket = () => {
      loading.value = true

      ticketStore.createTicketPublic(dataForTicket.value)
      .then((response) => {
        if(response.code !== 200) throw response
        ticket.value = response.data.ticket;
        loading.value = false;
        step.value = 3;
      })
      .catch((response) => {
        loading.value = false
        message.error(response.error)
      })
    }
    const cleanData = () => {
      dataForTicket.value = {
        ci: '',
        name: '',
        phone: '', 
        email: '', 
        client_id: '',
        departament_id: 0,
        type:2,
      }
    }
    const actionButton = () => {
      if(step.value == 1) {
        step.value++ 
        validate.value=true
        return
      }
      if(step.value == 2) {
        createTicket()
        return
      }
      if(step.value == 3) {
        step.value = 1
        cleanData()
        return
      }
      
    }
    
    return {
      step,
      loading,
      router,
      validate,
      dataForTicket,
      ticket,
      setClient,
      actionButton,
      setDayTime,
    }
  }
})
</script>
<style lang="scss" >
@media screen and (max-width: 780px){ 
  .container__section{
    margin-top: 1rem;
  }
}
</style>