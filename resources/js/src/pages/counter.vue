<template>
  <div class="counter__container" v-if="Object.values(departament).length > 0">
    <div class="counter__current" style="">
      <counterCurrentNumber :departament="departament" :currentTicket="currentTicket"/>
    </div>
    <div class="counter__buttons" style="">
      <counterButtons :departament="departament" @nextEmpty="nextEmpty" />
      <!-- <counterButtons :departament="departament" /> -->

    </div>
    <div class="counter__list" style="">
      <counterList :departament="departament"/>
    </div>
  </div>
</template>
<script>
  import { storeToRefs } from 'pinia'
  import { useAuthStore } from "@/services/store/auth.store";
  import { ref, onMounted, inject } from 'vue';
  import utils from '@/util/httpUtil.js'
  import { useRouter } from "vue-router";
  import counterCurrentNumber from '@/components/counter/counterCurrentNumber.vue';
  import counterButtons from '@/components/counter/counterButtons.vue';
  import counterList from '@/components/counter/counterList.vue';
  import { useNotification } from 'naive-ui'
  import { useDepartamentStore } from '@/services/store/departament.store';
  
  export default defineComponent({
    components: {
      counterCurrentNumber,
      counterButtons,
      counterList,
    },
    setup () {
      const { user } = storeToRefs(useAuthStore())
      const router = useRouter()
      const loading = ref(false);
      const departamentStore = useDepartamentStore()
      const departament = ref({})
      const currentTicket = ref({})
      const notification = useNotification()

      const logout = () => {
        utils.errorLogout( () => router.push('/login'))
      }

      const getDepartament = (inject=null) => {
        loading.value = true
        departamentStore.getDepartamentQueueById(user.value.departament)
        .then((data) => {
          const old = departament.value.tickets_by_day ? departament.value.tickets_by_day.length : 0
          departament.value = data.data
          setCurrentTicket(data.data.current_ticket)
            
          if(inject){
            showNotification(old)
          }
        }).catch((response) => {
          message.error(response)
          loading.value = false
          logout()
        })
      }
      const setCurrentTicket = (newCurrent) => {
        if( newCurrent && newCurrent.id !== currentTicket.value.id){
          currentTicket.value = newCurrent
          return
        }
        currentTicket.value = {};
      }
      const showNotification = (type) => {
        type < departament.value.tickets_by_day.length
        ? notification.success({
            content: 'Se ha agregado un nuevo ticket',
            duration: 2500,
          })
        : type == departament.value.tickets_by_day.length 
        ? ''
        : notification.warning({
            content: 'Se ha eliminado ticket',
            duration: 2500,
          })
      }
      const nextEmpty = () => {
        getDepartament()
        currentTicket.value = {};
      }

      onMounted(() => {
        getDepartament()

        window.Echo
        .channel('updateTicket'+user.value.departament)
        .listen('TicketEvent', async () => {
          getDepartament(true)
        })
        
      })
      return {
        user,
        departament,
        currentTicket,
        nextEmpty,
      }
    }
  })
</script>
<style lang="scss">
.counter__container{
  display: flex;
  height: 100%;
  width: 100%;
}
.counter__current{
  width: 50%; 
  height: 100%; 
  background: rgba(224, 224, 224, 0.384);

}
.counter__buttons{
  width: 20%; 
  height: 100%;  
  background: rgba(224, 224, 224, 0.384);
  // border-left: 5px  solid rgba(138, 138, 138, 0.514);
}
.counter__list{
  width: 30%; 
  height: 100%;  
  background: rgba(224, 224, 224, 0.384);

}
@media screen and (max-width: 780px){
  .counter__container{
    flex-wrap: wrap;
  }
  .counter__current{
    order: 2;
    width: 100%; 
    height: 37.5%; 
    background: rgba(224, 224, 224, 0.384);
  }
  .counter__buttons{
    order: 3;
    width: 100%; 
    height: 25%;  
    background: rgba(224, 224, 224, 0.384);
  }
  .counter__list{
    order: 1;
    width: 100%; 
    height: 37.5%;  
    background: rgba(224, 224, 224, 0.384);
  }
}

</style>