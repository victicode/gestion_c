<template>
  <div class="w-100 h-100">
    <div class="h-80  numberTicket__section"  v-if="currentTicket && !loading ">
      <div class="text-center">
        <div class="title__current text-bold">Atendiendo actualmente en {{ user.name }}</div>
      </div>
      <div class="numberTicket__current">
        <div class="numberTicket__current--container">
          {{ currentTicket.number }}
        </div>
        <div class="text-center text-medium" style="font-size: 1.8rem; margin-top: 1rem;">
          {{ currentTicket.client.name }}
        </div>
      </div>
      <div class="text-center mt-3">
        <div class="mt-2 text-bold" style="font-size: 1.5rem;">
          Tiempo de consulta
        </div>
        <div class="text-medium" style="font-size: 1.2rem;">
          {{ date }}
        </div>
      </div>
    </div>
    <div class="noCurrent h-80" v-if="!currentTicket && !loading " >
        <div class="text-center mt-3">
          <div class="title__current mt-3 text-bold">
            No hay ticket siendo atendido en {{ user.name }} 😞
          </div>
        </div>
    </div>
    <div class=" h-80 numberTicket__section" v-if="loading ">
        <div class="text-center">
          <div class="title__current mt-3 text-bold">  
             <n-skeleton text style="width: 60%" />
          </div>
        </div>
        <div class="numberTicket__current w-100">
            <n-skeleton text style="width: 60%; height: 150px; border-radius: 20px; margin-top: 1.5rem;" />
        </div>
        <div class="w-100 text-center">
          <n-skeleton text style="width: 60%" />
        </div>
    </div>
    <div class="h-20 w-100 stats__counter"  >
      <div class="text-center">
        <div class="stats__counter--title">Tickets atendidos hoy</div>
        <div class="stats__counter--value">{{ departament.tickets_by_day ? departament.tickets_by_day.length : 0 }}</div>
      </div>
      <div class="text-center">
        <div class="stats__counter--title" >Limite de ticket</div>
        <div class="stats__counter--value">{{ departament.limit ?? 0 }}</div>
      </div>
    </div>
  </div>
</template>
<script>
  import { storeToRefs } from 'pinia'
  import { useAuthStore } from "@/services/store/auth.store";
  import { inject, ref, onMounted } from 'vue';
  import { useMessage } from "naive-ui";
  import utils from '@/util/httpUtil.js'
  import { useRouter } from "vue-router";
  import { useDepartamentStore } from '@/services/store/departament.store';
  
  export default defineComponent({
    setup () {
      const { user } = storeToRefs(useAuthStore())
      const moment = inject('moment')
      const date = ref()
      const router = useRouter()
      const loading = ref(false);
      const departament = ref({})
      const currentTicket = ref(null)

      const departamentStore = useDepartamentStore()
      const message = useMessage();

      const clock = () =>{
        if(currentTicket.value){
          setInterval( ()=> {
            let today = new moment();
            let product_due_date = moment(currentTicket.value.updated_at);
            let diff_due_date = Math.round(moment.duration(today.diff(product_due_date)).as('seconds'));
            let seconds = () => {
              return (diff_due_date % 60+'').length == 1
              ?  '0' + diff_due_date % 60
              : diff_due_date % 60
            }
            let minute = () => {
              return (parseInt(diff_due_date / 60)+'').length == 1
              ?  '0' + parseInt(diff_due_date / 60)
              : parseInt(diff_due_date / 60)
            }
            let hour = () => {
              return (parseInt(diff_due_date / 3600)+'').length == 1
              ?  '0' + parseInt(diff_due_date / 3600)
              : parseInt(diff_due_date / 3600)
            }
  
            date.value =  hour() + ':' + minute() + ':' + seconds();
          }, 1000 )
        }
      }

      const getCurrentTicket = () => {
        loading.value = true
        departamentStore.getDepartamentQueueById(user.value.departament)
        .then((data) => {
          console.log(data)
          departament.value = data.data
          currentTicket.value = data.data.current_ticket 
          setTimeout(() => {
            clock()
            loading.value = false
          }, 50);

        }).catch((response) => {
          message.error(response)
          loading.value = false

        })
      }
      
      onMounted(() => {
        getCurrentTicket()  
      })

      return {
        user,
        departament,
        loading,
        currentTicket,
      }
    }
  })
</script>
<style lang="scss">
.stats__counter{
  display: flex; 
  justify-content: space-between; 
  padding: 1rem 3rem; 
  box-shadow: -10px 0px 10px 0px rgba(138, 138, 138, 0.514);
  border-top: 5px  solid rgba(138, 138, 138, 0.514);
  &--title{
    font-size: 1.2rem;
    color:$dark;
    font-weight: 600;
  }
  &--value{
    font-size: 2.8rem;
    font-weight: bold;
    color:$dark;
  }
}
.numberTicket__section {
  display: flex; 
  justify-content: space-between; 
  flex-direction: column; 
  padding: 2rem 0px;
}
.h-80{
  height: 80%;
}
.h-20{
  height: 20%;
}
.noCurrent{
  display: flex;
  justify-content: center;
  align-items: center;
}
.px-2{
  padding-left: 1rem;
  padding-right: 1rem;
}
.title__current{
  font-size: 1.8rem;
}
.subtitle__current{
  font-size: 1.6rem;
}
.numberTicket__current{
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  width: 100%;
  &--container{
    border: 4px solid $primary;
    margin-top: 2rem;
    border-radius: 20px;
    font-size: 6rem;
    padding: 0.9rem;
  }
}
</style>