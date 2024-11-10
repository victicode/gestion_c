<template>
  <div class="h-100">
    <div class="host-container">
      <transition name="horizontal">
        <div  class=" px-0 w-100 h-100" style="max-height:100%;" v-show="step==1">
          <clientForm :departament="dataForTicket.departament" @selectedUser="setClient" />
        </div>
      </transition>
    </div>
    <div  class="w-100 bottom-banner-app" >
      <div class="h-100 button__section" v-if="step!==1 && step!== 3 ">
        <n-button 
          color="#616161" 
          strong 
          round 
          size="large" 
          class="button_action__bottom_bar-app" 
          
          @click="step == 1 ? router.push('/host') : step--; validate=false"
        >
          Volver
        </n-button>
      </div> 
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
  import { useRouter } from 'vue-router'
  import { ref } from 'vue'
  import { useMessage, useNotification } from 'naive-ui';


  export default defineComponent({
  components: {
    clientForm,
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
      departament: {},
      departament_id:null
    })

    const setDepartament = (departament) => {
      dataForTicket.value.departament = departament;
      dataForTicket.value.departament_id = departament.id;
      validate.value = false
    }

    const setClient = (client) => {
      dataForTicket.value.ci = client.ci;
      dataForTicket.value.name = client.name;
      dataForTicket.value.phone = client.phone;
      dataForTicket.value.email = client.email;
      dataForTicket.value.client_id = client.id;

      validate.value = false
    }
    const createTicket = () => {
      loading.value = true
      ticketStore.createTicket(dataForTicket.value)
      .then((response) => {
        if(response.code !== 200) throw response
        ticket.value = response.data;
        loading.value = false;
        step.value = 3;
      })
      .catch((response) => {
        loading.value = false
        message.error(response.error)
      })
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
        router.push('/host')
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
      setDepartament,
      setClient,
      actionButton,
    }
  }
})
</script>
<style lang="scss" >

</style>