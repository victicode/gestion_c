<template>
  <div class="h-100 ">
    <div class="h-100 list__section" v-if="Object.values(departament).length > 0">

      <div class="list__container" v-if="departament.tickets_by_day.length > 0">
        <div v-for="(ticket, index) in departament.tickets_by_day " :key="index" style="" class="list__item">
          <div class="list__item--user">
            <div style="width: 18%; font-size: 0.9rem;">
              {{ ticket.number }}
            </div>
            <div style="margin-left: 1rem; width: 50%; font-size: 0.9rem;">
              {{ ticket.client.name }}
            </div>
          </div>
          <div class="list__item--time">
            <div style="margin-right: 0.05rem;">
              {{ clock(ticket.status == 2 ? ticket.updated_at : ticket.status == 1 ? ticket.created_at : '0') }}

            </div>
            <n-icon 
              size="1.5rem" 
              :color="ticket.status == 2 ? '#05A952' : ticket.status == 3 ? '#212121' : '#F2C037'"
              :component="ticket.status == 2 ? TargetArrow16Regular : ticket.status == 3 ? CheckmarkCircle16Regular : Clock16Regular" 
            />
          </div>
        </div>
      </div>
      <div v-else class="list__container text-center" >
        <div style="margin-top: 2rem; font-size: 1rem; font-weight: 600">
          No hay ticket en la lista Pediatría
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import { storeToRefs } from 'pinia'
  import { useAuthStore } from "@/services/store/auth.store";
  import {  ref, watch } from 'vue';
  import { CheckmarkCircle16Regular, Clock16Regular, TargetArrow16Regular, SwipeRight24Filled } from '@vicons/fluent'
  import moment from 'moment';
  
  export default defineComponent({
    props:{
      departament: Object,
    },
    setup (props) {
      const { user } = storeToRefs(useAuthStore())
      const loading = ref()
      const departament = ref(props.departament)
      const setLoading = (value) => {
        loading.value = value
      }

      watch(() => props.departament, (newValue) => {
        departament.value = newValue
      });

      const clock = (date) =>{
        if(date == '0') return
        let today = new moment();
        let product_due_date = moment(date);
        let diff_due_date = Math.round(moment.duration(today.diff(product_due_date)).as('minutes'));
        return  diff_due_date  +' min';
      }
      
      return {
        user,
        loading,
        departament,
        CheckmarkCircle16Regular, Clock16Regular, TargetArrow16Regular, SwipeRight24Filled,
        clock,

      }
    }
  })
</script>
<style lang="scss">
.list__section{
  padding: 1.5rem 0.5rem;
}
.list__item{
  display: flex; 
  border-bottom: 1px solid lightgrey; 
  justify-content: space-between;
  padding: 0.7rem 0rem; 
  align-items: center;
  &--user{
    display: flex;
    width: 70%;
  }
  &--time{
    display: flex;
    align-items: center;
    justify-content: end;
    width: 30%;
  }
}
.list__container{
  padding: 1rem;
  height: 100%;
  background: white;
  border-radius: 10px;
  box-shadow: 0px 0px 5px 1px rgba(138, 138, 138, 0.253);

}

</style>