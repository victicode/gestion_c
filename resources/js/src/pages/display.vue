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
      const showNew = () => {
        newShow.value = true

        setTimeout(() => {
          newShow.value = false
        }, 4000);
      }

      onMounted(() => {
        eventBus.$on('showNewTicket', ()=>{
          showNew()
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
      }
    }
  })
</script>
<style lang="scss">
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
