<template>
  <div v-if="departaments.length > 0" class="h-100 displayContent">
    <transition name="fadex">
      <div v-if="show == 1" class="departamentGroup">
        <div v-for="departament in departaments1" :key="departament.id" style="width:93%!important;"  >
          <div class="displayDepartament__content">
            <div class="departament__name">
              <div class="mb-0 text-center text__d" >
              {{ departament.name }}
              </div>
            </div>
            <div class="departament__ticket">
              <n-h1 class="text-bold mb-0 text__ticket" > 
                {{ departament.current_ticket ? departament.current_ticket.number : '---' }}
              </n-h1>
            </div>
            
          </div>
        </div>
      </div>
    </transition>        
    <transition name="fadex">
      <div v-if="show == 2" class="departamentGroup">
        <div v-for="departament in departaments2" :key="departament.id" style="width:93%!important; "   >
          <div class="displayDepartament__content">
            <div class="departament__name">
              <div class="mb-0 text-center text__d" >
              {{ departament.name }}
              </div>
            </div>
            <div class="departament__ticket">
              <n-h1 class="text-bold mb-0 text__ticket" > 
                {{ departament.current_ticket ? departament.current_ticket.number : '---' }}
              </n-h1>
            </div>
            
          </div>
        </div>
      </div>
    </transition>    
    <transition name="fadex">
      <div v-if="show == 3" class="departamentGroup">
        <div v-for="departament in departaments3" :key="departament.id" style="width:93%!important; "  class="" >
          <div class="displayDepartament__content">
            <div class="departament__name">
              <div class="mb-0 text-center text__d" style="" >
              {{ departament.name }}
              </div>
            </div>
            <div class="departament__ticket">
              <n-h1 class="text-bold mb-0 text__ticket" > 
                {{ departament.current_ticket ? departament.current_ticket.number : '---' }}
              </n-h1>
            </div>
          </div>
        </div>
      </div>
    </transition>      
    <transition name="fadex">
      <div v-if="show == 4" class="departamentGroup">
        <div v-for="departament in departaments4" :key="departament.id" style="width:93%!important; "  class="" >
          <div class="displayDepartament__content">
            <div class="departament__name">
              <div class="mb-0 text-center text__d" >
              {{ departament.name }}
              </div>
            </div>
            <div class="departament__ticket">
              <n-h1 class="text-bold mb-0 text__ticket" > 
                {{ departament.current_ticket ? departament.current_ticket.number : '---' }}
              </n-h1>
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
  import eventBus from '@/services/eventBus/eventBus'
  import audio from '@/assets/audio/alert2.mp3'
  export default defineComponent({
    setup () {
      const departamentStore = useDepartamentStore()
      const departaments = ref([])
      const show = ref(1)
      const departaments1 = ref([])
      const departaments2 = ref([])
      const departaments3 = ref([])
      const departaments4 = ref([])

      const interval = ref('')
      const alert = new Audio(audio)
      const getDepartamentList = (inject = false) => {
        departamentStore.getDepartamentsWithPendingPublic()
        .then((response) => {
          departaments.value = response.data
          separateDepartaments(departaments.value)
          if(inject){
            departaments.value = response.data
            eventBus.$emit('showNewTicket', 
            formatDataEmit(departaments.value.find(departament => departament.id == inject)) )
            alert.play()
            goInterval()
          }
        })
      }
      const separateDepartaments = (departaments) => {
        departaments1.value = departaments.slice(0,4)
        departaments2.value = departaments.slice(4,8)
        departaments3.value = departaments.slice(8,12)
        departaments4.value = departaments.slice(12,16)
      }
      const findTicket = (id) => {

        if(departaments1.value.find(departament => departament.id == id)) show.value = 1
        if(departaments2.value.find(departament => departament.id == id)) show.value = 2
        if(departaments3.value.find(departament => departament.id == id)) show.value = 3
        if(departaments4.value.find(departament => departament.id == id)) show.value = 4

      }
      const formatDataEmit = (data) => {
        return {
          departament: data.name,
          ...data.current_ticket
        }
      }

      const goInterval = () => {
        interval.value = setInterval(() => {
          if(show.value == 4){
            show.value -= 3 
            return
          }
          show.value++
          return
        },8000)
      }
      
      onMounted(() => {
        getDepartamentList(false)
        window.Echo
        .channel('displayUpdate')
        .listen('DisplayEvent', async ({departament}) => {
          clearInterval(interval.value)
          getDepartamentList(departament)
          findTicket(departament)
        })
        goInterval()
        

      })
      return {
        departaments,
        departaments1,
        departaments2,
        departaments3,
        departaments4,
        show,
      }
    }
  })
</script>
<style lang="scss">
.departament__ticket{
  padding: 1.3rem 0.5rem;
  & .text__ticket{
    font-size: 4.1rem; line-height: 1.05
  }
}

.departament__name{
  background: rgb(19, 82, 0);
  color: white;
  width: 100%;
  border-top-left-radius: 12px;
  border-top-right-radius: 12px;
  padding: 0.5rem 0.8rem;
  & .text__d{
    font-size: 1.7rem; overflow: hidden; white-space: nowrap;text-overflow: ellipsis; 
  }
}
.displayContent{
  width: 100%; padding: 0.8rem 0px; padding-bottom: 1.5rem; overflow: hidden
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

.displayDepartament__content{
    display:flex;
    justify-content: space-between;
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
