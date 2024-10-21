<template>
  <div class="h-100">
    <div class="host-container listTicket-">
      <n-card  class="host-page px-0 listTicket h-100" style="max-height:100%; margin: auto;" >
        <div class="header-list__ticket">
          <div>
            <n-button quaternary circle @click="router.push('/')">
              <template #icon>
                <n-icon :component="ArrowLeft12Filled" />
              </template>
            </n-button>
          </div>
          <div>
            <n-h2 class="text-bold" style="margin-bottom:0px; margin-left: 0px">Lista de ticket espera</n-h2>
          </div>
          <div>

          </div>
        </div>
        <div v-if="!loading" style="overflow: auto; height: 90%; padding: 0rem 1rem;">
          <div v-if="queue.tickets_pending && queue.tickets_pending.length > 0 " class="px-5" >
            <div v-for="ticket in queue.tickets_pending" :key="ticket.id" class="ticket__info-area mt-1">
                <div class="ticket__init-area">
                  <div>
                    {{ ticket.number }}
                  </div>
                  <div class="ticket__init-client">
                    {{ ticket.client.name }}
                  </div>
                </div>
                <div class="ticket__end-area">
                  <div>
                    {{ moment(ticket.created_at).format('hh:mm:ss A') }}
                  </div>
                  <div class="button__area" v-if="ticket.status == 1">
                    <n-button  circle type="error" @click="setTicket(ticket)" size="small">
                      <template #icon>
                        <n-icon :component="Delete24Regular" />
                      </template>
                    </n-button>
                  </div>
                  <n-icon :component="SwipeRight24Filled" class="button__area" color="#05A952" size="1.8rem" v-else/>
                </div>
            </div>
          </div>
          <div v-if="queue.tickets_pending && queue.tickets_pending.length == 0" >
            <div>
              No hay tickets pendiente en este departamento
            </div>
          </div>
        </div>
        <div v-if="loading"  style="height: 80%;">
          <div style="height: 100%; display: flex; justify-content: center; align-items: center">
            <n-spin size="large" />
          </div>
        </div>
      </n-card>
    </div>
    <div  class="w-100 bottom-banner" >
      <div class="h-100 button__section">
        <n-button 
          color="#05A952" 
          strong 
          round 
          size="large" 
          class="button_action__bottom_bar" 
          @click="router.push('/create_ticket')"
        >
          Solicitar Ticket
        </n-button>
      </div>
    </div>
    <deleteTicket :dialog="dialog" :ticket="selectedTicket" @hiddeModal="hiddenDialog" @update="getQueue(); hiddenDialog()" />
  </div>
</template>
<script>
  import { storeToRefs } from 'pinia'
  import { useAuthStore } from '@/services/store/auth.store';
  import departamentList from '@/components/departaments/departamentsList.vue'
  import { useRouter, useRoute } from 'vue-router'
  import { inject, onMounted } from 'vue';
  import { useDepartamentStore } from '@/services/store/departament.store';
  import { useMessage } from "naive-ui";
  import { ArrowLeft12Filled, Delete24Regular, TargetArrow16Regular, SwipeRight24Filled } from '@vicons/fluent'
  import deleteTicket from '@/components/host/modal/deleteTicket.vue';

  export default defineComponent({
  components: {
    departamentList,
    deleteTicket,
  },
	setup () {
    const { user } = storeToRefs(useAuthStore())
    const departamentStore = useDepartamentStore()
    const moment = inject('moment')
    const router = useRouter()
    const route = useRoute()
    const message = useMessage();
    const queue = ref({})
    const loading = ref(true)
    const dialog = ref(false)
    const selectedTicket = ref({})

    const getQueue = () => {
      departamentStore.getDepartamentQueueById(route.params.id)
      .then((response) => {
        queue.value = response.data
        loading.value = false
      })
      .catch((response) =>{
        message.error(response);
        loading.value = false
      })
    }
    const showDialog = () => {
      dialog.value = true
    }
    const hiddenDialog = () => {
      dialog.value = false
    }
    const setTicket = (ticket) => {
      selectedTicket.value = ticket
      showDialog()
    }
    onMounted(() => {
      getQueue()
      window.Echo
      .channel('updateTicket'+route.params.id)
      .listen('TicketEvent', async () => {
        getQueue()
      })
    })
    return {
      ArrowLeft12Filled,
      Delete24Regular,
      TargetArrow16Regular, 
      SwipeRight24Filled,
      loading,
      user,
      router,
      queue,
      moment,
      dialog,
      selectedTicket,
      showDialog,
      hiddenDialog,
      setTicket,
      getQueue,
    }
  }
})
</script>
<style lang="scss" >
.listTicket{
  width: 50%;
}
.ticket__init-client{
  margin-left: 1rem;
}
.header-list__ticket {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem;
}
.ticket__info-area{
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-bottom: 1px solid lightgray;
  padding: 5px 0px;
}
.ticket__end-area, .ticket__init-area {
  display: flex;
  
  align-items: center;
  width: 50%;
}
.ticket__end-area{
  justify-content: flex-end;
}
.ticket__init-area{
  justify-content: start
}
.button__area{
  margin-left: 1rem;
}
@media screen and (max-width: 780px){
  .px-5{
    padding: 0px 0.7rem;
  }

  .listTicket{
    width: 100%;
  }
}
</style>