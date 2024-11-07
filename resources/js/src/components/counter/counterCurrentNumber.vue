<template>
  <div class="w-100 h-100 currentTicket__section" style="">
    <div class="h-80  numberTicket__section"  v-if="Object.values(currentTicket).length > 0">
      <div class="text-center">
        <div class="title__current text-bold">Atendiendo actualmente en {{ user.name }}</div>
      </div>
      <div class="numberTicket__current">
        <div class="numberTicket__current--container">
          {{ currentTicket.number }}
        </div>
        <div class="text-center text-medium numberTicket__current--user" style="">
          {{ currentTicket.client.name }}
        </div>
      </div>
      <div class="text-center mt-3">
        <div class="mt-2 text-bold" style="font-size: 2rem;">
          Tiempo de consulta
        </div>
        <div class="text-medium" style="font-size: 1.8rem;">
          {{ date }}
        </div>
      </div>
    </div>
    <div class="noCurrent h-80" v-if="Object.values(currentTicket).length == 0" >
        <div class="text-center mt-3">
          <div class="title__current mt-3 text-bold">
            No hay ticket siendo atendido en {{ user.name }} 😞
          </div>
        </div>
    </div>
    <div class="h-20 w-100 stats__counter"  >
      <div class="text-center">
        <div class="stats__counter--title">Tickets atendidos hoy</div>
        <div class="stats__counter--value">{{ departament.tickets_atending_count  }}</div>
      </div>
      <div class="text-center updateLimit">
        <div class="stats__counter--title" >Limite de ticket</div>
        <div class="stats__counter--value" @click="modalStatus(true)">
          <div>
            {{ departament.limit ?? 0 }}
          </div>
        </div>
      </div>
    </div>
    <updateLimitTicket :dialog="dialog" :departament="departament" @hiddeModal="modalStatus(false)" @update="updateLimit" />
  </div>
</template>
<script>
  import { storeToRefs } from 'pinia'
  import { useAuthStore } from "@/services/store/auth.store";
  import { inject, ref, onMounted } from 'vue';
  import { useNotification } from 'naive-ui'
  import updateLimitTicket from '@/components/counter/modals/updateLimitTicket.vue';
  
  export default defineComponent({
    components: {
      updateLimitTicket
    },
    props:{
      departament: Object,
      currentTicket: Object
    },
    setup (props) {

      const { user } = storeToRefs(useAuthStore())
      const moment = inject('moment')
      const date = ref()
      const notification = useNotification()
      const departament = ref(props.departament)
      const currentTicket = ref(props.currentTicket)
      const interval = ref('');
      const dialog = ref(false);

      const clock = () =>{
        if(currentTicket.value){
          interval.value = setInterval( () => {
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
      
      const modalStatus = (status) => {
        dialog.value = status
      }
      const updateLimit = (newLimit) => {
        departament.value.limit = newLimit
        modalStatus(false)
      }
      watch(() => props.departament, (newValue) => {
        departament.value = newValue
      });
      watch(() => props.currentTicket, (newValue, old) => {
        currentTicket.value = newValue
        if(currentTicket.value.client){
          notification.success({
            content: 'Atendiendo a: '+ currentTicket.value.client.name,
            duration: 2500,
          })
          clock() 
        }
      });

      onMounted(() => {
        clock() 
      })

      return {
        user,
        dialog,
        departament,
        currentTicket,
        date,
        modalStatus,
        updateLimit,
      }
    }
  })
</script>
<style lang="scss">
.currentTicket__section{
  padding: 0px 0.5rem;
}
.updateLimit{
  cursor: pointer;
  & .stats__counter--value{
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    
    & > div {
      transition: all 0.5s ease;
      z-index: 24;
    }
    &::before{
      transition: all 0.5s ease;
      content: '';
      display: block;
      position: absolute;
      height: 60px;
      width: 0px;
      background: #044723;
      border-radius: 5px;
      // top: calc();
      z-index: 1;
    }
  }
  &:hover > .stats__counter--value {
    color: #fff;
    &::before {
      width: 60px;
    }
  }
}
.stats__counter{
  display: flex; 
  justify-content: space-between; 
  padding: 1rem 3rem; 
  box-shadow: 0px 0px 5px 0px rgba(138, 138, 138, 0.514);
  border-top: 4px  solid rgba(138, 138, 138, 0.514);
  border-right: 4px  solid rgba(138, 138, 138, 0.514);
  border-left: 4px  solid rgba(138, 138, 138, 0.514);
  border-top-left-radius: 10px;
  border-top-right-radius: 10px;
  background: transparent;
  
  &--title{
    background: #044723;
    color: white;
    padding:0.1rem 0.8rem;
    font-size: 1.1rem;
    font-weight: 600;
    border-radius: 0.2rem;
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
    border: 4px solid #044723;
    background: #044723;
    color: white;
    margin-top: 2rem;
    border-radius: 20px;
    font-size: 6rem;
    padding: 1rem;
  }
  &--user{
    font-size: 2rem; margin-top: 1rem; 
    border-radius: 10px;
    padding: 0px 15px;
    background: #044723;
    color: white;
  }
}
</style>