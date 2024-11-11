<template>
  <div class="form__container-date mt-3"> 
    <n-card  class="host-page px-0 w-100 h-100" style="max-height:100%" >
      <div>
        <div class="flex justify-between items-center w-100">
          <div class=" text-h5 " style="margin-bottom:5px">Selecciona la fecha y la hora de tu consulta🩺 </div>
          <div class=" text-h5 " style="margin-bottom:5px">Paso 2/3</div>
        </div>
        <div class=" text-h2 w-100 text-bold " style="margin-bottom:5px">Selecciona el día</div>
        <div class="form-ticket">
          <DatePicker v-model="date" :color="'green'"  style="width: 100%;" class="appointment-calendar"/>
        </div>
      </div>
    </n-card>
  </div>
</template>
<script>
import { defineComponent, onMounted, ref, watch} from "vue";
import { useMessage } from "naive-ui";
import { useDepartamentStore } from "@/services/store/departament.store";
import { Calendar, DatePicker } from 'v-calendar';
import 'v-calendar/style.css';

export default defineComponent({
  components: {
    Calendar,
    DatePicker,
  },
  props: {},
  emits: ['selectedUser'],
  setup (props, { emit }) {

    return {
      date: new Date(),
    };
  }
});
</script>
<style lang="scss">

  .n-base-select-menu .n-base-select-option.n-base-select-option--show-checkmark{
    margin-top: 10px;
  }

  .form__container-date{
    padding: 0px 15%;
    & .n-card.n-card--bordered {
      padding: 0px 0%;
    }
  }
  .appointment-calendar {
    
    & .vc-attr{
      font-size: 20px;
      height: 40px;
  
    }
    & .vc-highlight{
      height: 40px;
      width: 40px;
    }
  }
  
  @media screen and (max-width: 780px){ 
    .form__container-date{
      padding: 0px 2%;
      & .n-card.n-card--bordered {
        padding: 0px 5%;
      }
    }
    .items__ticket-form{
      width:100%;
      &:nth-child(even){
        padding-left: 0px;
      }
    }
  }
</style>