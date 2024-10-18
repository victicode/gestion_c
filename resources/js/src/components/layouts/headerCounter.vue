<template>
  <div class="header-counter w-100 h-100" style="overflow: hidden; " >
    <div  class=" header-counter__section w-100 h-100" >
      <div class="counter-header__container h-100">
        <div class="items_header__img " >
          <img src="https://siamtel.lara.gob.ve/fundacion-siamtel/wp-content/uploads/2021/02/cintillo.png"   style="filter: grayscale(2) brightness(100);"/>
        </div>
        <div class="items_header__user  text-bold">
          <n-avatar
            size="small"
          >
            {{user.name.charAt(0)}}
          </n-avatar>
          <div class="header-user___name">
            <n-ellipsis style="max-width: 100px">
              {{user.name}}
            </n-ellipsis>
          </div>
        </div> 
        <div class="items_header__hour  text-bold">
          {{ moment(date).format('MMMM Do YYYY, h:mm:ss a') }}
        </div>    
        
        <div class="items_header__action " >
          <div class="hidden-xs">
            <n-button  color="#fff"  class="actionCounterButton" quaternary size="large" text-color="black" style="padding:20px 10px; margin-right: 1rem;" @click="logout()" :loading="loading">
              <template #icon>
               <n-icon :size="'2rem'"  :component="Settings32Regular" />
              </template>
            </n-button>
            <n-button  color="#fff" class="actionCounterButton"  quaternary size="large" text-color="black" style="padding:20px 10px" @click="logout()" :loading="loading">
              <template #icon>
               <n-icon :size="'2rem'" :component="SignOut24Regular" />
              </template>
            </n-button>
          </div>
          <div class="show-xs w-100" style="justify-content:space-between; ">
            <n-button  circle color="#cbcbcb" size="medium">
              <template #icon>
              <n-icon :size="'1.5rem'" :component="Settings32Regular" />
              </template>
            </n-button>
            <n-button  circle color="#cbcbcb" size="medium" @click="logout()">
              <template #icon>
                <n-icon :size="'1.5rem'" :component="SignOut24Regular" />
              </template>
            </n-button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import { storeToRefs } from 'pinia'
  import { useAuthStore } from "@/services/store/auth.store";
  import { inject, ref, onMounted } from 'vue';
  import { SignOut24Regular, LineHorizontal320Filled, Settings32Regular } from '@vicons/fluent'
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
        Settings32Regular,
        loading,
        logout,
      }
    }
  })
</script>
<style lang="scss" >
.actionCounterButton{
  transition: all ease 0.7;
  & i {
    transition: all ease 0.7;
  }
  &:hover{
    background: white!important;
    & i{
      color: rgba(9, 39, 0, 0.986);
    }
  }
}
.header-user___name{
  position: relative;
  margin-left: 0.3rem;
  font-size: 1rem;
  font-weight: bold;

}
.header-counter{
  & .n-card__content{
    padding: 8px 10px!important;
  }
}
.counter-header__container{
  display:flex;
  justify-content: space-between;
  align-items: center;
  background: rgba(9, 39, 0, 0.986);
  padding: 0px 1rem;
}
.items_header__img {
  width: 70%;
  border-right: 2px solid #6d6d6d;
  height: 100%;
  display: flex;
  align-items: center;
  & img {
    width: 180px;
  }
}
.items_header__user {
  color: white;
  width: 10%;
  border-right: 2px solid #6d6d6d;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}
.items_header__hour {
  color: white;
  width: 10%;
  border-right: 2px solid #6d6d6d;
  height: 100%;
  display: flex;
  align-items: center;
  text-align: center;
  justify-content: center;
}
.items_header__action {
  width: 10%;
 
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}

@media screen and (max-width: 780px){
  
  .header-counter__section{
    padding:0px
  }
  .header-counter{
    padding-top:  2%;
    padding: 0%;
    & .n-card__content{
      padding: 15px!important;
    }
  }
  .counter-header__container {
    padding: 0% 0%;
  }
  .header-user___name{
    display: none;
  }
  .items_header__user{
    width: 15%;
  }
  .items_header__action {
    width: 25%;
    padding: 0px 0.5rem;
  }
  .items_header__hour{
    width: 25%;
  }
  .items_header__img {
    width: 35%;
   & img{
    width: 100%;
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