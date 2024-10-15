<template>
  <div class="header-host w-100 h-100" style="overflow: hidden; " >
    <div  class="  header__section w-100" >
      <!-- <n-card  class="host-page  w-100"  style=""> -->
      <div class="host-header__container">
        <div class="items_header text-bold">
          {{ moment(date).format('MMMM Do YYYY, h:mm:ss a') }}
        </div>    
        <div class="items_header text-center" >
          <img src="https://siamtel.lara.gob.ve/fundacion-siamtel/wp-content/uploads/2021/02/cintillo.png"   width="200"/>
        </div>
        <div class="items_header action_section " >
          <div class="hidden-xs">
            <n-button  color="#cbcbcb" size="small" text-color="black" style="padding:20px 10px" @click="logout()" :loading="loading">
              <div class="">Cerrar sesion</div>
              <template #icon>
               <n-icon :size="'1.3rem'" :component="SignOut24Regular" />
              </template>
            </n-button>
          </div>
          <div class="show-xs w-100" style="justify-content:space-between; ">
            <n-button  circle color="#cbcbcb" size="medium" @click="logout()">
              <template #icon>
                <n-icon :size="'1.3rem'" :component="SignOut24Regular" />
              </template>
            </n-button>
            <n-button  circle color="#cbcbcb" size="medium">
              <template #icon>
              <n-icon :size="'1.3rem'" :component="LineHorizontal320Filled" />
              </template>
            </n-button>
          </div>
        </div>
      </div>
    <!-- </n-card> -->
    </div>
  </div>
</template>
<script>
  import { storeToRefs } from 'pinia'
  import { useAuthStore } from "@/services/store/auth.store";
  import { inject, ref, onMounted } from 'vue';
  import { SignOut24Regular, LineHorizontal320Filled } from '@vicons/fluent'
  import utils from '@/util/httpUtil.js'
  import { useRouter } from "vue-router";

  
  export default defineComponent({
	setup () {
    const { user } = storeToRefs(useAuthStore())
    const moment = inject('moment')
    const date = ref()
    const router = useRouter()
    const loading = ref(false);
    const clock = () =>{
      setInterval( ()=> {
        date.value = new Date
      },1000 )
    }
    const logout = () => {
      loading.value = true
      utils.errorLogout( () => router.push('/login'))
    }
    onMounted(() => {
      date.value = new Date
      clock()
    })
    return {
      user,
      moment,
      date,
      SignOut24Regular,
      LineHorizontal320Filled,
      loading,
      logout,
    }
  }
})
</script>
<style lang="scss" >
.header__section {
  padding: 1% 0%;
}
.header-host{
  padding:  0.8%;
  padding-top:  0.5%;
  padding-right: 50px;
  padding-left: 50px;

  & .n-card__content{
    padding: 8px 10px!important;
  }
}
.host-header__container{
  display:flex;
  justify-content: space-between;
  align-items: center;
}
.items_header {
  width: 33%
}
.action_section {
  display:flex; 
  justify-content:end; 
  & button:nth-child(2){
    display: none;
  }
}

@media screen and (max-width: 780px){
  .header__section{
    padding:4% 0px
  }
  .header-host{
    padding-top:  2%;
    padding: 3%;
    & .n-card__content{
      padding: 15px!important;
    }
  }
  .items_header {
    width: 75%;
    &:nth-child(2n) {
      display: none;
    }
    &:nth-child(3n) {
      width: 25%;
      padding:0px 0px 0px 0px;
    }
  }
  .action_section {
    display:flex; 
    
    padding-left:35px;
    & button:nth-child(2) {
      display: inline-flex;
    }
  }
}
</style>