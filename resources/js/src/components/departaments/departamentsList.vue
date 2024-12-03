<template>
  <div style="height: 90%;" >
    <n-h2 class=" w-100 text-bold" style="margin-bottom:5px; margin-left: 15px">Lista de espera</n-h2>
    <div class="departament__container">
      <div v-for="(departament, index) in departaments" :key="index"  class="departamentList__table">
        <div class="departamentList__item" @click="goTo(departament.id)">
          <div class="departamentList__item--name">
            {{ departament.name }}
          </div>
          <div class="count_section">
            <div class="mr-1">
              {{ departament.tickets_pending.length }}
            </div>
            <n-icon size="24" :component="PeopleAudience20Regular" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import { useDepartamentStore } from '@/services/store/departament.store';
  import { ref, onMounted } from 'vue'
  import { PeopleAudience20Regular } from '@vicons/fluent'
  import { useRouter } from 'vue-router'
  export default defineComponent({
    setup () {
      const departamentStore = useDepartamentStore()
      const departaments = ref([])
      const router = useRouter()
      const goTo = (id) => {
        router.push('/departament/list/'+id)
      }
      const getDepartamentList = () => {
        departamentStore.getDepartamentsWithPending()
        .then((response) => {
          departaments.value = response.data
        })
      }
      onMounted(() => {
        getDepartamentList()
      })
      window.Echo
      .channel('updateDepataments')
      .listen('TicketEvent', async () => {
        getDepartamentList()
      })
      return {
        departaments,
        PeopleAudience20Regular,
        goTo,
      }
    }
  })
</script>
<style lang="scss" >
  .departament__container {
    display:flex; 
    flex-wrap:wrap; 
    height: 100%; 
    overflow-y: auto;
  }
  .departamentList__table{
    width:50%;
    padding: 0px 50px; 
    &:nth-child(odd){
      border-right: 1px solid lightgrey;
    }
  }
  .mr-1{
    margin-right: 0.2rem;
  }
  .count_section{
    display:flex;
    justify-content: space-between;
  }
  .departamentList__item{
    padding: 15px 5px;
    display:flex;
    justify-content: space-between;
    border-bottom: 1px solid;
    &--name{
      cursor:pointer;
      transition:all 0.5s ease;
      &:hover {
        text-decoration:underline;
        color:grey;
      }
    }
  }
  .button{
    box-shadow:0px 5px 10px 0px rgba(0, 0, 0, 0.747) 
  }
  .bottom-banner {
    z-index: 1; 
    height:15%; 
    background:rgb(20, 20, 20); 
    box-shadow:0px -5px 10px 0px rgba(0, 0, 0, 0.356) 
  }
  @media screen and (max-width: 780px){ 

    .departamentList__table{
    width:100%;
    padding: 0px 10px ; 
      &:nth-child(odd){
        border-right: 0px solid lightgrey;
      }
    }
    .departamentList__item {
      padding: 10px 5px;
      display:flex;
      justify-content: space-between;
      border-bottom: 1px solid
    }
  }
</style>