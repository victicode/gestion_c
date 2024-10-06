<template>
  <div class="h-100">
    <div class="departament__header" >
      <n-card  class="px-0 form_title" >
        <n-h2 class=" w-100 text-bold" style="margin-bottom:0px">Selecciona el departamento</n-h2>
      </n-card>
    </div>
    <div class="departament__container" v-if="departaments.length > 0">
      <div v-for="(departament, index) in departaments" :key="index"  class="departamentSquare__table">
        <div class="departamentSquare__item">
          <n-h6 class=" w-100 text-bold text-center" style="margin-bottom:0px;">
            {{ departament.name }}
          </n-h6>
        </div>
      </div>
    </div>
    <div class="departament__container" v-else>
      <div v-for="n in 16" :key="n"  class="departamentSquare__table">
        <div class="departamentSquare__item">
          <n-spin size="tiny" />
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import { useDepartamentStore } from '@/services/store/departament.store';
  import { ref, onMounted } from 'vue'
  import { PeopleAudience20Regular } from '@vicons/fluent'

  export default defineComponent({
	setup () {
    const departamentStore = useDepartamentStore()
    const departaments = ref([])

    const getDepartamentList = () => {
      departamentStore.getDepartamentsWithPending()
      .then((response) => {
        setTimeout(() => {
          departaments.value = response.data
        }, 100);
      })
    }
    onMounted(() => {
      getDepartamentList()
    })
    return {
      departaments,
      PeopleAudience20Regular
    }
  }
})
</script>
<style lang="scss" >
  .departament__header{
    max-height:100%; 
    height:10%; 
    padding: 8px 50px
  }
  .form_title {
    box-shadow:0px 2px 5px 0px rgba(0, 0, 0, 0.747) ;
    & .n-card__content {
      padding: 10px!important;
      text-align:center
    }
  }
  .departament__container {
    display:flex; 
    flex-wrap:wrap; 
    height: 90%; 
    overflow-y: auto;
    padding-top:2%;
  }
  .departamentSquare__table{
    width:33%;
    padding: 0px 50px; 
  }
  .mr-1{
    margin-right: 0.2rem;
  }
  .count_section{
    display:flex;
    justify-content: space-between;
  }
  .departamentSquare__item {
    padding: 18px 5px;
    display:flex;
    justify-content: center;
    background: white;
    cursor: pointer;
    border-radius: 15px;
    box-shadow:0px 2px 5px 0px rgba(0, 0, 0, 0.747) ;
    font-weight: 500;
    transition: all 1s ease;

    &:hover{
      background: $secondary;

    }
  }
  .bottom-banner {
    z-index: 1; 
    height:15%; 
    background:rgb(20, 20, 20); 
    box-shadow:0px -5px 10px 0px rgba(0, 0, 0, 0.356) 
  }
  @media screen and (max-width: 780px){ 

    .departamentSquare__table{
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
    }
  }
</style>