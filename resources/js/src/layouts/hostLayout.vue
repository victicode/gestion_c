<template>
  <section id="sistemPage">
    <div class="w-100 header" >
      <headerHost />
    </div>
    <div class="w-100 mt-0 content">
      <router-view v-slot="{ Component }">
        <transition name="vertical" >
          <component :is="Component"/>
        </transition>
      </router-view>
    </div>
  </section>
</template> 
<script>
  import { storeToRefs } from 'pinia'
  import { useAuthStore } from "@/services/store/auth.store";
  import headerHost from '@/components/layouts/header.vue'
  export default defineComponent({
  components:{
    headerHost
  },
	setup () {
    const { user } = storeToRefs(useAuthStore())
    return {
      user
    }
  }
})
</script>
<style lang="scss" scoped>
  .header{
    height: 13%;
  }
  .content {
    height: 87%
  }
  @media screen and (max-width: 780px){
    .header{
      height: 11%;
    }
    .content {
      height: 89%
    }
  }
</style>
