<template>
  <div class="h-100">
    <div class="host-container">
      <n-card style="" class="host-page px-0 w-100" >
        {{ 'Hola ' + user.name}}
        <br>
        {{ 'Hola ' + user.name}}
        <br>
        {{ 'Hola ' + user.name}}

      </n-card>
    </div>
    <div  class="w-100 bottom-banner" >
      <div style="display:flex; justify-content:flex-end; align-items:center; padding: 0px 5%" class="h-100">
        <n-button color="#05A952" strong round size="large" class="button" style="padding:30px!important">
          Solicitar Ticket
        </n-button>
      </div>
    </div>
  </div>

</template>
<script>
  import { storeToRefs } from 'pinia'
  import { useAuthStore } from "@/services/store/auth.store";
  export default defineComponent({
	name: 'App',
	setup () {
    const { user } = storeToRefs(useAuthStore())
    return {
      user
    }
  }
})
</script>
<style lang="scss" scoped>

  .host-container {
    padding-top:1%;
    padding-right: 50px;
    padding-left: 50px;
    height:85%
  }
  .button{
    box-shadow:0px 5px 10px 0px rgba(0, 0, 0, 0.747) 
  }
  .bottom-banner {
    z-index: 1; 
    height:15%; 
    background:rgb(20, 20, 20); 
    box-shadow:0px -5px 10px 0px rgba(0, 0, 0, 0.356) 
  }
  @media screen and (max-width: 780px){ 
    .host-container {
      padding-right: 10px;
      padding-left: 10px;
    }
  }
</style>