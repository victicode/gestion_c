<template>
  <n-modal v-model:show="dialog">
    <n-card
      style="width: 600px"
      title="Modificar Limite de ticket"
      :bordered="false"
      size="huge"
      role="dialog"
      aria-modal="true"
    >

      <div class="">
        <div class="text__dialog">
          Ingresa el nuevo limite de ticket por días,  <b style="font-weight: bold;">(Actual:{{ departament.limit }})</b>
        </div>
        <div class="input__area">
          <n-input v-model:value="newLimit" :maxlength="2" clearable placeholder="" />
        </div>
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
            Enviar
          </n-button>
        </div>
      </template>
    </n-card>
  </n-modal>
</template>
<script>
import { defineComponent, ref } from "vue";
import { useMessage } from "naive-ui";
import { useDepartamentStore } from "@/services/store/departament.store";
export default defineComponent({
  props: {
    dialog: Boolean,
    departament: Object
  },
  emits: ['hiddeModal', 'update'],

  setup (props, { emit }) {
    const message = useMessage();
    const dialog = ref(props.dialog)
    const departament = ref(props.departament)
    const departamentStore = useDepartamentStore()
    const loading = ref(false)
    const newLimit = ref(departament.value.limit+'')

    const closeModal = () => {
      emit('hiddeModal')
    }

    const update = () =>  {
      loading.value = true
      departamentStore.updateLimit({id:departament.value.id, limit: parseInt(newLimit.value)})
      .then((response) => {
        loading.value = false
        newLimit.value = response.data.limit+'';
        message.success("Limite cambiado con exito");
        emit('update', newLimit.value)
      })
      .catch((response) => {
        message.error(response);
        loading.value = false
      })
    }

    watch(() => props.dialog, (newValue) => {
      dialog.value = newValue
    });
    watch(() => props.departament, (newValue) => {
      departament.value = newValue
    });
    return {
      dialog,
      departament,
      loading,
      newLimit,
      closeModal,
      update,
    };
  }
});
</script>
<style lang="scss">
.text__dialog{
  font-size: 1.1rem;
}
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
.input__area{
  margin-top: 2rem;
  display: flex;
  justify-content: center;
  & .n-input {
    height: 8.1rem;
    font-size: 4rem;
    max-width: 8rem;

  }
  & .n-input__input-el{
    height: 8.1rem;
    transform: translatex(0.7rem);
  }
}
</style>