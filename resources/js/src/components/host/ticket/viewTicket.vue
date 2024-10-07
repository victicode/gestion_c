<template>
  <div class="viewTicket__container"> 
    <n-card  class="host-page px-0 w-100 h-100" style="max-height:100%" >
      <div v-if="Object.values(ticket).length > 0 ">
        <n-h6 class=" w-100 text-bold text-center" style="margin-bottom:5px">Has sido asigado de forma exitosa🎉</n-h6>
        <div class="view-ticket">
          <div class="number_section">
            <n-h1>
              {{ ticket.number }}
            </n-h1>
          </div>
          
        </div>
      </div>
    </n-card>
  </div>
</template>
<script>
import { defineComponent, ref, watch} from "vue";
// import { useMessage } from "naive-ui";
// import { useClientStore } from '@/services/store/client.store.js'

export default defineComponent({
  props: {
    ticket: Object
  },
  emits: ['selectedUser'],
  setup (props, { emit }) {
    const ticket = ref(props.ticket)
    
    watch(() => props.ticket, (newValue) => {
      console.log(newValue)
      ticket.value = newValue
    });

    return {
      ticket
    };
  }
});
</script>
<style lang="scss">
  .view-ticket{
    margin-top: 5%
  }
  .viewTicket__container{
    padding: 0px 25%;
    & .n-card.n-card--bordered {
      padding: 0px 0%;
    }
  }
  @media screen and (max-width: 780px){ 
    .viewTicket__container{
      padding: 0px 2%;
      & .n-card.n-card--bordered {
        padding: 0px 5%;
      }
    }
  }
</style>