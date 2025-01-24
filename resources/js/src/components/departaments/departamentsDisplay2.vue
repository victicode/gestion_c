<template>
  <div class="h-100 displayContent2 ">
    <div  class="ticket" style="width: max-content; transition: all 5s ease;">
      <TransitionGroup name="vertical-up">
          <div v-for="ticket in ticket" :key="ticket.id" style="width:30rem!important; margin: 0px 1rem; height: 100%; transition: all 0.8s ease;"  >
            <div class="displayDepartament__content">
              <div class="departament__name">
                <div class="mb-0 text-center text__d" >
                {{ ticket.id }}
                </div>
              </div>
              <div class="departament__ticket">
                <n-h2 class="text-bold mb-0 text__ticket" > 
                  {{ ticket.name }}
                </n-h2>
              </div>
              
            </div>
          </div>
        </TransitionGroup>        
      </div>
    <!-- <transition name="fadex">
      <div v-if="show == 2" class="ticket">
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
      <div v-if="show == 3" class="ticket">
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
      <div v-if="show == 4" class="ticket">
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
    </transition>         -->
  </div>
</template>
<script>
  import { useDepartamentStore } from '@/services/store/departament.store';
  import { ref, onMounted, watch } from 'vue'
  import eventBus from '@/services/eventBus/eventBus'
  import audio from '@/assets/audio/alert2.mp3'
  export default defineComponent({
    props: {
      current: Number
    },
    emits: ['getTicket'],
    setup (props, { emit }) {
      const alert = new Audio(audio)

      const ticket = ref([
        {
          id:'001',
          name:'Victor Rivero',
          order: '2 Perros Clasicos + 1 Refresco de 1lt + 1 Ración de papas'
        },
        {
          id:'002',
          name:'Wilmer Rivero ',
          order: '2 Hamburguesas + refresco 2lt'
        },
        {
          id:'003',
          name:'David Rivero',
          order: '1 Perro full papas'
        },
        {
          id:'004',
          name:'Andrea Peraza',
          order: '2 Perros Clasicos + refresco 1lt'
        },
        {
          id:'005',
          name:'Alejandro Rivero',
          order: '4 Perros Clasicos + refresco 1.5LT'
        },
        {
          id:'006',
          name:'Mirna Gomez',
          order: '2 Perros Clasicos'
        },
        {
          id:'007',
          name:'Fran Garcia',
          order: '1 Hambuguesa sencilla'
        },
      ])

      const getTicket = () =>{

        emit('getTicket', ticket.value.shift())
        
      }
      watch(() => props.current, (newValue) => {
        getTicket()
        setTimeout(() => {
          alert.play()
        },100)
      });
      onMounted(() => {

        getTicket()
      })
      return {

        ticket

      } 
      
    }
  })
</script>
<style lang="scss">
.departament__ticket{
    padding: .5rem;
    height: 75%;
    display: flex;
    justify-content: center;
    align-items: center;
  & .text__ticket{
    font-size: 3.3rem; 
  }
}

.departament__name{
  height: 25%;
  background: rgb(219, 17, 10);
  color: white;
  width: 100%;
  border-top-left-radius: 0px;
  border-top-right-radius: 0px;
  padding: 0.1rem 0.8rem;
  & .text__d{
    font-size: 2rem; overflow: hidden; white-space: nowrap;text-overflow: ellipsis; 
  }
}
.displayContent2{
  width: 100%; padding: 0rem 0px; padding-bottom: 0rem; overflow-y: visible; overflow-x: auto;
 
  &::-webkit-scrollbar{
    display: none;
  }
}
.ticket{
  display: flex; justify-content: space-between; height: 100%;
}
.ticket.last{
  display: flex; justify-content: flex-start; flex-direction: column; height: 100%;
}
.mb-0{
  margin-bottom: 0px;
}

.displayDepartament__content{
    display:flex;
    height: 95%;
    flex-direction: column;
    align-items: center;
    background: white;
    cursor: pointer;
    border-radius: 0px;
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
.vertical-up-enter-active,
.vertical-up-leave-active {
  transition: all 0.5s ease;
}

.vertical-up-leave-to {
  opacity: 0;
  transform: translateY(30px);
}
.vertical-up-enter-to{
  transform: translateX(-30px);
}
</style>
