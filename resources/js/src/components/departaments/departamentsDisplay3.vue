<template>
  <div class="h-100">
    <div style="height: 10%; overflow: hidden; width:91%!important;">
      <div class="text-center mt-1 " style="font-size: 3.8rem; line-height: 1; padding: 1rem 0px;  background: darkgray; color: white;">
        TURNO
      </div>
    </div>
    <div v-if="departaments.length > 0" class=" displayContent">
      <transition name="fadex">
        <div v-if="show == 1" class="departamentGroup">
          <div v-for="departament in departaments1" :key="departament.id" style="width:91%!important; height: 25%;"  >
            <div class="displayDepartament__content">
              <div class="departament__name">
                <div class="mb-0 text-center text__d" >
                {{ departament.name }}
                </div>
              </div>
              <div class="departament__ticket">
                <n-h1 class="text-bold mb-0 text__ticket text-center" > 
                  {{ departament.current_ticket ? departament.current_ticket.number : '---' }}
                </n-h1>
              </div>
              
            </div>
          </div>
        </div>
      </transition>        
      <transition name="fadex">
        <div v-if="show == 2" class="departamentGroup">
          <div v-for="departament in departaments2" :key="departament.id" style="width:91%!important; height: 25%; "   >
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
          <div v-for="departament in departaments3" :key="departament.id" style="width:91%!important; height: 25%; "  class="" >
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
          <div v-for="departament in departaments4" :key="departament.id" style="width:91%!important; height: 25%; "  class="" >
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
        },800000000)
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
  padding: 1.3rem 2rem;
  box-shadow:0px 10px 10px 0px rgba(0, 0, 0, 0.151) ;
  width: calc(100% - 2rem);
  border-bottom-left-radius: 5rem;
  border-bottom-right-radius: 1.5rem;
  position: relative;
  height: 70%;
  background: white;
  margin-left: 2rem;
  & .text__ticket{
    text-align: center;
    font-size: 4.2rem; 
  }
}

.departament__name{
  height: 30%;
  background: rgb(15, 61, 1);
  color: white;
  width: 100%;
  border-top-right-radius: 10px;
  padding: 0.5rem 0.8rem;
  & .text__d{
    font-size: 1.9rem; overflow: hidden; white-space: nowrap;text-overflow: ellipsis; 
  }
}
.displayContent{
  width: 100%; padding-top: 0.7rem ;  overflow: hidden; height: 90%;
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
    height: 92%;
    display:flex;
    justify-content: space-between;
    flex-direction: column;
    align-items: center;
    background: transparent;
    cursor: pointer;
    border-bottom-right-radius: 10px;
    border-top-right-radius: 10px;

    
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
    &:active{
      // background: #7a7a7a;
      transform: scale(0.8);
      & .n-h6{
        color: white,
      }
    }

}
</style>
