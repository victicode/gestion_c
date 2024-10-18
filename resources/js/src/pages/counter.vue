<template>
  <div class="counter__container">
    <div class="counter__current" style="">
      <counterCurrentNumber/>
    </div>
    <div class="counter__buttons" style="">

    </div>
    <div class="counter__list" style="">

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
  import counterCurrentNumber from '@/components/counter/counterCurrentNumber.vue';
  
  export default defineComponent({
    components: {
      counterCurrentNumber,
    },
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
      }
    }
  })
</script>
<style lang="scss">
.counter__container{
  display: flex;
  height: 100%;
  width: 100%;
}
.counter__current{
  width: 50%; 
  height: 100%; 
}
.counter__buttons{
  width: 20%; 
  height: 100%;  
  background: blue;
}
.counter__list{
  width: 30%; 
  height: 100%;  
  background: yellow;
}
@media screen and (max-width: 780px){
  .counter__container{
    flex-wrap: wrap;
  }
  .counter__current{
    order: 2;
    width: 100%; 
    height: 37.5%; 
    background: red;
  }
  .counter__buttons{
    order: 3;
    width: 100%; 
    height: 25%;  
    background: blue;
  }
  .counter__list{
    order: 1;
    width: 100%; 
    height: 37.5%;  
    background: yellow;
  }
}

</style>