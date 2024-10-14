<template>
  <n-modal v-model:show="dialog">
    <n-card
      style="width: 600px"
      title="Eliminar ticket"
      :bordered="false"
      size="huge"
      role="dialog"
      aria-modal="true"
    >

      <div>
       ¿Estas seguro que deseas eliminar el ticket <b class="text-bold">#{{ ticket.number }}</b>?
      </div>
      <template #footer>
        <div class="ticket__modal-button-area">
          <n-button
            round
            color="#242424"
            class="mx-1"
            @click="closeModal($event)"
          >
            Cerrar
          </n-button>
          <n-button
            round
            type="primary"
            :loading="loading"
            @click="update($event)"
          >
            Eliminar
          </n-button>
        </div>
      </template>
    </n-card>
  </n-modal>
</template>
<script>
import { defineComponent, ref } from "vue";
import { useMessage } from "naive-ui";
import { useTicketStore } from "@/services/store/ticket.store";
export default defineComponent({
  props: {
    dialog: Boolean,
    ticket: Object
  },
  emits: ['hiddeModal', 'update'],

  setup (props, { emit }) {
    const message = useMessage();
    const dialog = ref(props.dialog)
    const ticket = ref(props.ticket)
    const ticketStore = useTicketStore()
    const loading = ref(false)

    const closeModal = () => {
      emit('hiddeModal')
    }

    const update = () =>  {
      loading.value = true
      ticketStore.deleteTicket(ticket.value.id)
      .then((response) => {
        loading.value = false
        message.success("Ticket eliminado con exito");
        emit('update')
      })
      .catch((response) => {
        message.error(response);
        loading.value = false
      })
    }

    watch(() => props.dialog, (newValue) => {
      dialog.value = newValue
    });
    watch(() => props.ticket, (newValue) => {
      ticket.value = newValue
    });
    return {
      dialog,
      ticket,
      loading ,
      closeModal,
      update,
    };
  }
});
</script>
<style lang="scss">
.n-card__footer{
  padding: 1rem!important;
}
.mx-1{
  margin-left: 1rem;
  margin-right: 1rem;
}
.n-dialog .n-dialog__close{
  display: none!important;
}
.ticket__modal-button-area{
  display:  flex;
  justify-content: flex-end;
}
</style>