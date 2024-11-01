<template>
  <div class="display__container h-100">
    <div class="h-100" style="display: flex">
      <div style="width: 30%;">
        <departamentsDisplay />
      </div>
      <div style="width: 70%;">
        <div style="height: 15%; overflow: hidden;">
          <headerDisplay />
        </div>
        <div style="height: 80%; overflow: hidden; padding: 0px 2.5rem ">
          <div class="publicidad" :style="'background:'+colors[color]">
          </div>
        </div>
      </div>
    </div>
    <transition name="fadex">
      <div v-if="newShow" class="newTicketUpdate">
        <div class="ticket__container">
          <div v-for="ticket in tickets" :key="ticket.id" class="ticket__content">
            <div style="font-size: 2.5rem;">{{ ticket.departament }}</div>
            <div style="font-size: 8rem;">{{ ticket.number }}</div>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>
<script>
  import { ref, onMounted } from 'vue'
  import headerDisplay from '@/components/layouts/headerDisplay.vue';
  import departamentsDisplay from '@/components/departaments/departamentsDisplay.vue';
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

      onMounted(() => {
        eventBus.$on('showNewTicket', (data)=>{
          showNew(data)
        })

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
  padding: 3rem; 
  text-align: center; 
  border-radius: 20px;
  margin: 0px 1rem;
  width: 30rem;
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
.publicidad{
  height: 100%; 
  border-radius: 30px; 
  transition: all 0.5 ease;
}

</style>
