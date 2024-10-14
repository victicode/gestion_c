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
  </div>
</template>
<script>
  import { ref, onMounted } from 'vue'
  import headerDisplay from '@/components/layouts/headerDisplay.vue';
  import departamentsDisplay from '@/components/departaments/departamentsDisplay.vue';

  export default defineComponent({
    components: {
      headerDisplay,
      departamentsDisplay,
    },
    setup () {

      const color = ref(0)

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
      }
    }
  })
</script>
<style lang="scss">

.publicidad{
  height: 100%; 
  border-radius: 30px; 
  transition: all 0.5 ease;
}

</style>
