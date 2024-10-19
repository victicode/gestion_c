<template>
  <div class="h-100">
    <div class="host-container">
      <transition name="horizontal">
        <div  class=" px-0 w-100 h-100" style="max-height:100%;" v-show="step==1">
          <departamentSquare @selectedDepartament="setDepartament" />
        </div>
      </transition>
      <transition name="horizontal">
        <div  class=" px-0 w-100 h-100" style="max-height:100%;" v-show="step==2">
          <clientForm :departament="dataForTicket.departament" @selectedUser="setClient" />
        </div>
      </transition>
      <transition name="horizontal">
        <div  class=" px-0 w-100 h-100" style="max-height:100%" v-show="step==3">
          <viewTicket :ticket="ticket" />
        </div>
      </transition>
    </div>
    <div  class="w-100 bottom-banner" >
      <div class="h-100 button__section">
        <n-button 
          color="#616161" 
          strong 
          round 
          size="large" 
          class="button_action__bottom_bar" 
          v-if="step!==3"
          @click="step == 1 ? router.push('/host') : step--; validate=false"
        >
          Volver
        </n-button>
      </div> 
      <div class="h-100 button__section">
        <n-button 
          color="#05A952" 
          strong 
          round 
          size="large" 
          class="button_action__bottom_bar" 
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

  import departamentSquare from '@/components/departaments/departamentsSquare.vue'
  import clientForm from '@/components/host/ticket/clientForm.vue'
  import viewTicket from '@/components/host/ticket/viewTicket.vue';
  import { useRouter } from 'vue-router'
  import { inject, onMounted, ref } from 'vue'

  export default defineComponent({
  components: {
    departamentSquare,
    clientForm,
    viewTicket
  },
	setup () {
    const emitter = inject('emitter')
    const loading = ref(false)
    const ticketStore = useTicketStore();
    const ticket = ref({})
    const router = useRouter()
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
        emitter.emit('updateRecipes')
        loading.value = false;
        console.log('aaaaaaaaaaaas')
        step.value = 3;
      })
      .catch((response) => {
        loading.value = false
        console.log(response)
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