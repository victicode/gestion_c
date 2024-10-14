<template>
  <div v-if="departaments.length > 0" class="h-100 displayContent">
    <transition name="fadex">
      <div v-if="show == 1" class="departamentGroup">
        <div v-for="departament in departaments1" :key="departament.id" style="width:80%!important;"  >
          <div class="displayDepartament__content">
            <div>
              <div class="mb-0 text-center" style="font-size: 22px;" >
              {{ departament.name }}
              </div>
            </div>
            <div>
              <n-h1 class="text-bold mb-0"> 
                {{ departament.current_ticket ? departament.current_ticket.number : '---' }}
              </n-h1>
            </div>
            <div>
              <div class="mb-0 text-center" style="font-size: 22px;" >
                {{ departament.current_ticket ? departament.current_ticket.client.name  : '...' }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </transition>        
    <transition name="fadex">
      <div v-if="show == 2" class="departamentGroup">
        <div v-for="departament in departaments2" :key="departament.id" style="width:80%!important; "   >
          <div class="displayDepartament__content">
            <div>
              <div class="mb-0 text-center" style="font-size: 22px;" >
              {{ departament.name }}
              </div>
            </div>
            <div>
              <n-h1 class="text-bold mb-0"> 
                {{ departament.current_ticket ? departament.current_ticket.number : '---' }}
              </n-h1>
            </div>
            <div>
              <div class="mb-0 text-center" style="font-size: 22px;" >
                {{ departament.current_ticket ? departament.current_ticket.client.name  : '...' }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </transition>        
    <transition name="fadex">
      <div v-if="show == 3" class="departamentGroup last">
        <div v-for="departament in departaments3" :key="departament.id" style="width:80%!important; "  class="mt-3" >
          <div class="displayDepartament__content">
            <div>
              <div class="mb-0 text-center" style="font-size: 22px;" >
              {{ departament.name }}
              </div>
            </div>
            <div>
              <n-h1 class="text-bold mb-0"> 
                {{ departament.current_ticket ? departament.current_ticket.number : '---' }}
              </n-h1>
            </div>
            <div>
              <div class="mb-0 text-center" style="font-size: 22px;" >
                {{ departament.current_ticket ? departament.current_ticket.client.name  : '...' }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </transition>        
  </div>
</template>
<script>
  import { useDepartamentStore } from '@/services/store/departament.store';
  import { ref, onMounted } from 'vue'

  export default defineComponent({
    setup () {
      const departamentStore = useDepartamentStore()
      const departaments = ref([])
      const show = ref(1)
      const departaments1 = ref([])
      const departaments2 = ref([])
      const departaments3 = ref([])

      const getDepartamentList = () => {
        departamentStore.getDepartamentsWithPendingPublic()
        .then((response) => {
          departaments.value = response.data
          separateDepartaments(departaments.value)
        })
      }
      const separateDepartaments = (departaments) => {
        departaments1.value = departaments.slice(0,6)
        departaments2.value = departaments.slice(6,12)
        departaments3.value = departaments.slice(12,18)
      }
      const colors = [
        'white',
        'green',
        'black',
        'yellow',
        'red',
        'blue',
        'orange',
        'grey',
        'pink',
      ]

      onMounted(() => {
        getDepartamentList()
        setInterval(() => {
          if(show.value == 3){
            show.value = 1 
            return
          }
          show.value++
          return
        },6000)

      })
      return {
        departaments,
        departaments1,
        departaments2,
        departaments3,
        show,
      }
    }
  })
</script>
<style lang="scss">
.displayContent{
  width: 100%; padding: 1.1rem 0px; overflow: hidden
}
.departamentGroup{
  display: flex; justify-content: space-between; flex-direction: column; height: 100%;
}
.departamentGroup.last{
  display: flex; justify-content: flex-start; flex-direction: column; height: 100%;
}
.mb-0{
  margin-bottom: 0px;
}
.display__container{
  padding: 0px 1rem;
}
.displayDepartament__content{
    padding: 0.5rem 8px;
    display:flex;
    justify-content: center;
    flex-direction: column;
    align-items: center;
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
</style>
