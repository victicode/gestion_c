<template>
  <div class="display__container3 h-100">
    <div class="h-100" style="display: flex">
      <div style="width: 28%;">
        <departamentsDisplay />
      </div>
      <div style="width: 72%;">
        <div style="height: 11%; overflow: hidden;">
          <headerDisplay />
        </div>
        <div style="height: 89%; overflow: hidden; ">
          
          <div class="publicidad" :style="'background:url('+colors[color]+'); background-size: cover; background-position: center;'">
          </div>
          
        </div>
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
  import { ref, onMounted } from 'vue'
  import headerDisplay from '@/components/layouts/headerDisplay3.vue';
  import departamentsDisplay from '@/components/departaments/departamentsDisplay3.vue';
  import eventBus from '@/services/eventBus/eventBus'
  import consul from '@/assets/images/publicidad/consul.jpg'
  import consul2 from '@/assets/images/publicidad/consul2.jpg'
  import consul3 from '@/assets/images/publicidad/consul3.jpg'

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
        consul,
        consul2,
        consul3
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
          if(color.value == 2){
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
  
  text-align: center; 
  border-radius: 20px;
  margin: 0px 1rem;
  width: 35rem;
}
.display__container3{
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
  transition: all 0.5s ease;
}

</style>
