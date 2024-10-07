<template>
  <div class="h-100">
    <div class="host-container">
      <n-card  class="host-page px-0 w-100 h-100" style="max-height:100%" >
        <departamentList />
      </n-card>
    </div>
    <div  class="w-100 bottom-banner" >
      <div class="h-100 button__section">
        <n-button 
          color="#05A952" 
          strong 
          round 
          size="large" 
          class="button_action__bottom_bar" 
          @click="router.push('/create_ticket')"
        >
          Solicitar Ticket
        </n-button>
      </div>
    </div>
  </div>
</template>
<script>
  import { storeToRefs } from 'pinia'
  import { useAuthStore } from '@/services/store/auth.store';
  import departamentList from '@/components/departaments/departamentsList.vue'
  import { useRouter } from 'vue-router'
  export default defineComponent({
  components: {
    departamentList
  },
	setup () {
    const { user } = storeToRefs(useAuthStore())
    const router = useRouter()
    return {
      user,
      router
    }
  }
})
</script>
<style lang="scss" >

</style>