<template>
  <div class="h-100">
    <div class="departamentSquere__header" >
      <n-card  class="px-0 form_title" >
        <n-h2 class="w-100 text-bold hidden-xs" style="margin-bottom:0px">Selecciona el departamento</n-h2>
        <n-h4 class="w-100 text-bold show-block-xs" style="margin-bottom:0px; margin-top: 0px!important">Selecciona el departamento</n-h4>

      </n-card>
    </div>
    <div class="departamentSquare__container mt-xs-1" v-if="departaments.length > 0">
      <div v-for="(departament, index) in departaments" :key="index"  class="departamentSquare__table">
        <div class="departamentSquare__item" @click="selectedDepartament($event, departament)" >
          <n-h6 class=" w-100 text-bold text-center" style="margin-bottom:0px;">
            {{ departament.name }}
          </n-h6>
        </div>
      </div>
    </div>
    <div class="departamentSquare__container" v-else>
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
  import { ref, onMounted, watch } from 'vue'
  import { PeopleAudience20Regular } from '@vicons/fluent'

export default defineComponent({

  emits: ['selectedDepartament'],
  setup (props, { emit }) {
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
    const selectedDepartament = (e, departament) => {
      activeCurrent(e.target.closest('.departamentSquare__table'))
      emit('selectedDepartament', departament);
    }
    const activeCurrent = (element) => {
      try{
        document.querySelector('.departamentSquare__item.active').classList.remove('active')
      }
      catch{
      }
      element.querySelector('.departamentSquare__item').classList.add('active')
    }

    onMounted(() => {
      getDepartamentList()
    })
    return {
      departaments,
      PeopleAudience20Regular,
      selectedDepartament,
    }
  }
})
</script>
<style lang="scss" >
  .departamentSquere__header{
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
  .departamentSquare__container {
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
    position:relative;
    transition: all 0.4s ease;

    &.active{
      background: #7a7a7a;
      & .n-h6 { 
        color:white!important;
      }
    }
    .n-h6 { 
      transition: all 0.4s ease;
    }
    &:hover{
      background: #7a7a7a;
      & .n-h6{
        color: white,
      }
    }
    &:active{
      background: #7a7a7a;
      transform: scale(0.8);
      & .n-h6{
        color: white,
      }
    }

  }
  .bottom-banner {
    z-index: 1; 
    height:15%; 
    background:rgb(20, 20, 20); 
    box-shadow:0px -5px 10px 0px rgba(0, 0, 0, 0.356) 
  }
  @media screen and (max-width: 780px){ 
    .form_title {
      & .n-card__content {
        padding: 10px!important;

      }
    }
    .departamentSquere__header{
        max-height:100%; 
        height:10%; 
        padding: 0px 5px;
      }
    .departamentSquare__table{
      width:100%;
      padding: 0px 10px ; 
      &:nth-child(odd){
        border-right: 0px solid lightgrey;
      }
    }
    .departamentSquare__item {
      margin-bottom: 10px;
      padding: 14px 5px;
    }
  }
</style>