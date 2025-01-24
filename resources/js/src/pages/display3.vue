<template>
  <div class="display__container h-100">
    <div class="h-100" style="    display: flex;
    flex-direction: column;
    justify-content: center;">
      
      <div style="width: 100%; height: 80%; display: flex;">
        <div style="height: 100%;  width: 35%; padding-right: 1rem;">
          <headerDisplay />
          <div style="padding: 2rem 1rem; background: white; margin-top: 2.5rem; text-align: center; transition: all 0.8s ease;" id="containerChek" >
            
            <div v-if="!loading && Object.values(currentTicket).length > 0"> 
              <div style="font-size: 2.8rem;font-weight: 600 ">
                Pedido saliente
              </div>
              <div>
                <div style="font-size: 2.8rem;font-weight: 600; margin-top: 1rem;">N° {{ currentTicket.id }}</div>
                <div style="font-size: 5rem; font-weight: 900 ;">{{ currentTicket.name }}</div>
              </div>
              <div style="border-top: 2px solid lightgrey; padding-top: 2rem; font-size: 2.5rem; font-weight: 900; text-align: justify; padding-left: 1rem;" v-for="(n, i) in currentTicket.order.split('+')" :key="i">
                - {{ n }}
              </div>
            </div>
            <div v-else>
              <n-spin size="large" />
            </div>
          </div>
        </div>
        <div style="overflow: hidden;height: 100%; width: 65%; " @click="nextTicket()">
          <div style="display: flex; height: 95%;">
            <div class="publicidad2" :style="'background:'+colors[color]" style="display: flex; align-items: center; justify-content: center;">
              <div style="font-size: 8rem; color: white; transform: rotate(-30deg);">
                PUBLICIDAD
              </div>
            </div>
          </div>
        </div>
      </div>
      <div style="width: 100%;overflow: auto; height: 20%;">
        <departamentsDisplay :current="count" @getTicket="getTicke" />
      </div>
    </div>
    <transition name="fadex">
      <div v-if="newShow" class="newTicketUpdate">
        <div class="ticket__container">
          <div v-for="ticket in tickets" :key="ticket.id" class="ticket__content">
            <div class="departament__name" style="padding: 1.2rem;">
              <div style="font-size: 2.5rem;">{{ ticket.departament }}</div>
            </div>
            <div style="padding: 1.2rem;">
              <div style="font-size: 8rem;">{{ ticket.number }}</div>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>
<script>
  import { ref, onMounted, watch } from 'vue'
  import headerDisplay from '@/components/layouts/headerDisplay2.vue';
  import departamentsDisplay from '@/components/departaments/departamentsDisplay2.vue';
  import eventBus from '@/services/eventBus/eventBus'

  export default defineComponent({
    components: {
      headerDisplay,
      departamentsDisplay,
    },
    setup () {

      const color = ref(0)
      const newShow = ref(false)
      const timer = ref('')
      const tickets = ref([])
      const loading = ref(true)
      const colors = [
        'green',
        'black',
        'red',
        'blue',
        'orange',
        'grey',
        'pink',
      ]
      const currentTicket =  ref({})
      const showNew = (data) => {
        if(tickets.value.find(tickets => tickets.id == data.id)) return

        try {
          clearTimeout(timer.value)
        } catch (error) {
          
        }

        newShow.value = true
        tickets.value.push(data)
        
        timer.value = setTimeout(() => {
          newShow.value = false
          tickets.value = []
        }, 6000);
      }

      const count = ref(0)
      const nextTicket = () => {
        count.value++
      }
      const getTicke = (ticket) => {
        loading.value = true
        currentTicket.value = ticket
        setTimeout(() => {
          loading.value = false
          document.getElementById('containerChek').classList.add('lll')
          setTimeout(() => {
          document.getElementById('containerChek').classList.remove('lll')
          },3000)
        }, 1000);
      }
      
      watch(currentTicket, (newValue) => {

      })
      onMounted(() => {
        eventBus.$on('showNewTicket', (data)=>{
          showNew(data)
        })
        setTimeout(() => {
          loading.value = false
        }, 2000);
        setInterval(() => {
          if(color.value == 8){
            color.value = 0 
            return
          }
          color.value++
          return
        },3000)
        
      })
      return {
        colors,
        color,
        newShow,
        tickets,
        count,
        currentTicket,
        loading,
        getTicke,
        nextTicket,
      }
    }
  })
</script>
<style lang="scss">
.ticket__container {
  display: flex; 
  width: 100%;
  justify-content: center;
  align-items: center;
  height: 100%;
  flex-wrap: wrap;
}
.ticket__content {
  background: white;
  
  text-align: center; 
  border-radius: 20px;
  margin: 0px 1rem;
  width: 35rem;
}
.display__container{
  padding: 0px 1rem;
  position: relative;
}
.newTicketUpdate{
  position: absolute;
  background: rgba(0, 0, 0, 0.836);
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
}
.publicidad2{
  margin-top: 1rem;
  height: 100%; 
  width: 100%;
  border-radius: 30px; 
  transition: all 0.5 ease;
}
.lll{
  animation: bounce 0.7s alternate-reverse infinite;
}
@keyframes bounce {
  0%{
    transform: translateY(8rem);
  }

  100%{
    transform: translateY(-2rem);
  }
  
}

</style>
