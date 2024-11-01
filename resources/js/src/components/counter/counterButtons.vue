<template>
  <div class="button-action__section" v-if="Object.values(departament).length > 0">
    <div class="button-action__item">
      <n-button type="success" @click="nextTicket()" :loading="loading == 'next'">
        Siguiente
      </n-button>
    </div>
    <div class="button-action__item">
      <n-button type="success" @click="recall()" :loading="loading == 'recall'">
        Volver a llamar
      </n-button>
    </div>
    <div class="button-action__item">
      <n-button type="success" @click="posNextTicket()" :loading="loading == 'pos'">
        Posponer
      </n-button>
    </div>
  </div>
</template>
<script>
  import { storeToRefs } from 'pinia'
  import { useAuthStore } from "@/services/store/auth.store";
  import { useMessage } from "naive-ui";
  import { ref, watch } from 'vue';
  import { useTicketStore } from '@/services/store/ticket.store';

  export default defineComponent({
    props:{
      departament: Object,
    },
    emits: ['nextEmpty'],
    setup (props, { emit }) {
      const { user } = storeToRefs(useAuthStore())
      const loading = ref('')
      const departament = ref(props.departament)
      const ticketStore = useTicketStore()
      const message = useMessage();

      const setLoading = (value) => {
        loading.value = value
      }

      const nextTicket = () => {
        setLoading('next')
        ticketStore.nextTicket(departament.value.id)
        .then((response) => {
          setLoading('')

        })
        .catch((response) => {
          message.error(response.error);
          setLoading('')
          if(response.code == 201){
            emit('nextEmpty');
          }

        })
      }
      const recall = () => {
        setLoading('recall')
        ticketStore.recallTicket(departament.value.id)
        .then(()=>{
          message.success('Ticket rellamado con exito');
          setLoading('')

        }).catch((response)=>{
          setLoading('')
          message.error(response);
        })
      }
      const posNextTicket = () => {
        setLoading('pos')
        ticketStore.posNextTicket(departament.value.id)
        .then(()=> {
          message.success('Ticket pospuesto con exito');
          setLoading('')
          emit('nextEmpty');

        }).catch((response)=>{
          
          setLoading('')
          message.error(response);
        })
      }
      
      watch(() => props.departament, (newValue) => {
        departament.value = newValue
      });

      return {
        user,
        loading,
        departament,
        posNextTicket,
        nextTicket,
        recall,
      }
    }
  })
</script>
<style lang="scss">
.button-action__section{
  padding: 1.5rem;
  display: flex;
  flex-direction: column;
  justify-content: start;
  align-items: center;
  height: 100%;
}
.button-action__item{
  
  margin-bottom: 2rem;
  display: flex;
  justify-content: center;
  width: 100%;
  transition: all 0.5s ease;
  cursor: pointer;
  &:hover{
    transform: scale(0.9);
  }
  & .n-button {
    width: 100%;
    padding: 2.5rem;
    border-radius: 5px;
  }
  & .n-button__content {
    font-size: 1rem;
  }
}
</style>