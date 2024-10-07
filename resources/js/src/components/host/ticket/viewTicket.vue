<template>
  <div class="viewTicket__container"> 
    <n-card  class="host-page px-0 w-100 h-100" style="max-height:100%" >
      <div v-if="Object.values(ticket).length > 0 ">
        <n-h1 class=" w-100 text-bold text-center" style="margin-bottom:0px">Tu ticket🎉</n-h1>
        <div class="view-ticket">
          <div class="number_section" style="border-bottom: 1px solid black; border-top: 1px solid black">
            <div class="text-bold text-center ticket__number" style="">
              {{ ticket.number }}
            </div>
          </div>
          <div class="mt-2 ticket__info">
            <div class="ticket__info--item">
              <n-icon size="30px" :component="Building24Regular" /> 
              <div class="ticket__info--item-text">{{ticket.departament.name}}</div>
            </div>
            <div class="ticket__info--item">
              <n-icon size="30px" :component="Person20Filled" /> 
              <div class="ticket__info--item-text">
                {{ticket.client.name}}
              </div>
            </div>
            <div class="ticket__info--item">
              <n-icon size="30px" :component="CalendarLtr24Regular" /> 
              <div class="ticket__info--item-text">{{moment(ticket.created_at).format('DD/MM/YYYY')}}</div>
            </div>
            <div class="ticket__info--item">
              <n-icon size="30px" :component="PersonCall24Regular" /> 
              <div class="ticket__info--item-text">{{ ticket.client.phone }}</div>
            </div>
          </div>
          <div>
            <div class="text-center mt-2 text-subtitle">
              Puedes revisar tu posición en la cola en el siguiente link, o escaneando el codigo QR
            </div>
            <div class="qr__container mt-2r">
              <qrcode-vue :value="`https://example.com/view/${ticket.departament.id}/${ticket.client.id}`" :size="120" level="H" render-as="svg" />
              <a class="mt-2r link_ticket" :href="`https://example.com/view/${ticket.departament.id}/${ticket.client.id}`" target="_blank">
                https://example.com/view/{{ticket.departament.id}}/{{ticket.client.id}}
              </a>
            </div>
          </div>
        </div>
      </div>
    </n-card>
  </div>
</template>
<script>
import { defineComponent, ref, watch, inject} from "vue";
import {Building24Regular, Person20Filled, CalendarLtr24Regular, PersonCall24Regular} from '@vicons/fluent'
import QrcodeVue from 'qrcode.vue'

export default defineComponent({
  components: {
    QrcodeVue,
  },
  props: {
    ticket: Object
  },
  emits: ['selectedUser'],
  setup (props, { emit }) {
    const ticket = ref(props.ticket)
    const moment = inject('moment')
    watch(() => props.ticket, (newValue) => {
      ticket.value = newValue
    });

    return {
      ticket,
      moment,
      Building24Regular,
      Person20Filled,
      CalendarLtr24Regular,
      PersonCall24Regular,
    };
  }
});
</script>
<style lang="scss">
  .link_ticket {
    color:black;
    text-decoration: underline;
    cursor:pointer;
    transition: all 0.5s ease;
    &:hover{
      color:$primary;
    }
  }
  .mt-2r{
    margin-top: 1rem;
  }
  .text-subtitle{
    font-size:0.9rem;
  }
  .qr__container {
    display:flex;
    justify-content:center;
    align-items:center;
    flex-direction:column;
  }
  .ticket__info{
    display:flex;
    flex-wrap:wrap;
    &--item {
      width:50%;
      display:flex;
      justify-content:center;
      align-items:center;
      margin: 10px 0px;
    }
 
    &--item-text{
      width:60%;
      margin-left: 2px;
      
    }

  }
  .view-ticket{
    margin-top: 1%
  }
  .viewTicket__container{
    padding: 0px 30%;
    & .n-card.n-card--bordered {
      padding: 0px 0%;
    }
  }
  .ticket__number{
    margin-bottom: 0px; 
    font-size:55px; 
    color:$primary;
    line-height: 1.4;
  }
  @media screen and (max-width: 780px){ 
    .text-subtitle{
      font-size:0.9rem;
    }
    .viewTicket__container{
      padding: 0px 2%;
      & .n-card.n-card--bordered {
        padding: 0px 5%;
      }
    }
  }
</style>