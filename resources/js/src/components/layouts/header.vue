<template>
  <div class="header-host w-100 h-100">
    <n-card style="" class="host-page px-0 w-100" >
      <div>
        {{ moment(date).format('MMMM Do YYYY, h:mm:ss a') }}
      </div>    
      <div>

      </div>
      <div>
      </div>
    </n-card>
  </div>
</template>
<script>
  import { storeToRefs } from 'pinia'
  import { useAuthStore } from "@/services/store/auth.store";
  import { inject, ref, onMounted } from 'vue';

  export default defineComponent({
	name: 'App',
	setup () {
    const { user } = storeToRefs(useAuthStore())
    const moment = inject('moment')
    const date = ref()
    const clock = () =>{
      setInterval( ()=> {
        date.value = new Date
      },1000 )
    }
    onMounted(() => {
      date.value = new Date
      clock()
    })
    return {
      user,
      moment,
      date,
    }
  }
})
</script>
<style lang="scss" scoped>
.header-host{
  padding: 1%;
}
</style>