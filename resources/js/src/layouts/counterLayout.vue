<template>
  <div class="counter__base">
    <section id="section-header">
      <headerCounter />
    </section>
    <section id="section-counter">
      <router-view v-slot="{ Component }">
        <transition name="vertical" >
          <component :is="Component"/>
        </transition>
      </router-view>
    </section>
  </div>
</template>
<script>
  import { storeToRefs } from 'pinia'
  import { useAuthStore } from "@/services/store/auth.store";
  import headerCounter from '@/components/layouts/headerCounter.vue'
  export default defineComponent({
    components:{
      headerCounter 
    },
    setup () {
      const { user } = storeToRefs(useAuthStore())
      return {
        user
      }
    }
  })
</script>
<style lang="scss">
#section-header{
  height: 9%;
}
#section-counter {
  height: 91%;
}
.counter__base{
  width: 100%;
  height: 100%;
  background: white;
}
</style>