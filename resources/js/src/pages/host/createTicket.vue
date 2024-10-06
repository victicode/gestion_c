<template>
  <div class="h-100">
    <div class="host-container">
      <div  class=" px-0 w-100 h-100" style="max-height:100%" >
        <departamentSquare />
      </div>
    </div>
    <div  class="w-100 bottom-banner" >
      <div class="h-100 button__section">
        <n-button 
          color="#616161" 
          strong 
          round 
          size="large" 
          class="button_action__bottom_bar" 
          @click="router.push('/host')"
        >
          Volver
        </n-button>
      </div> 
      <div class="h-100 button__section">
        <n-button 
          color="#05A952" 
          strong 
          round 
          size="large" 
          class="button_action__bottom_bar" 
        >
          Siguiente
        </n-button>
      </div>
    </div>
  </div>
</template>
<script>
  import { storeToRefs } from 'pinia'
  import { useAuthStore } from '@/services/store/auth.store';
  import departamentSquare from '@/components/departaments/departamentsSquare.vue'
  import { useRouter } from 'vue-router'
  export default defineComponent({
  components: {
    departamentSquare
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
  
  .host-container {
    padding-top:1%;
    padding-right: 50px;
    padding-left: 50px;
    height:85%;
    padding-bottom:1%;
    .n-card__content {
      height:100%
    }
  }
  @media screen and (max-width: 780px){ 
    .host-container {
      padding-right: 10px;
      padding-left: 10px;
      padding-bottom:5%;
      .n-card__content {
        padding-right: 0px!important;
        padding-left: 0px!important;
        height:100%
      }
    }
  }
</style>