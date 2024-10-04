<template>
  <section id="sistemPage">
    <div style="height: 10%" class="w-100">
      <headerHost />
    </div>
    <div class="w-100" style="height: 90%">
      <router-view v-slot="{ Component }">
        <component :is="Component" />
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
	name: 'App',
	setup () {
    const { user } = storeToRefs(useAuthStore())
    return {
      user
    }
  }
})
</script>
