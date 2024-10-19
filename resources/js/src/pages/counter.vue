<template>
  <div class="counter__container">
    <div class="counter__current" style="">
      <counterCurrentNumber/>
    </div>
    <div class="counter__buttons" style="">
      <counterButtons :departament="departament"/>
    </div>
    <div class="counter__list" style="">
      <counterList :departament="departament"/>
    </div>
  </div>
</template>
<script>
  import { storeToRefs } from 'pinia'
  import { useAuthStore } from "@/services/store/auth.store";
  import { inject, ref, onMounted } from 'vue';
  import utils from '@/util/httpUtil.js'
  import { useRouter } from "vue-router";
  import counterCurrentNumber from '@/components/counter/counterCurrentNumber.vue';
  import counterButtons from '@/components/counter/counterButtons.vue';
  import counterList from '@/components/counter/counterList.vue';

  import { useDepartamentStore } from '@/services/store/departament.store';
  
  export default defineComponent({
    components: {
      counterCurrentNumber,
      counterButtons,
      counterList,
    },
    setup () {
      const { user } = storeToRefs(useAuthStore())
      const moment = inject('moment')
      const emitter = inject('emitter')
      const date = ref()
      const router = useRouter()
      const loading = ref(false);
      const departamentStore = useDepartamentStore()
      const departament = ref({})

      const logout = () => {
        loading.value = true
        utils.errorLogout( () => router.push('/login'))
      }

      const getDepartament = (inject = false) => {
        loading.value = true
        departamentStore.getDepartamentQueueById(user.value.departament)
        .then((data) => {
          departament.value = data.data

          if(inject){
            
          }
        }).catch((response) => {
          message.error(response)
          loading.value = false
        })
      }
      emitter.on("updateRecipes", () => {
          alert('lllllllll')
        })
      onMounted(() => {
        console.log('llll')
        getDepartament(true)
        
      })
      return {
        user,
        moment,
        departament,
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
  background: rgba(224, 224, 224, 0.253);

}
.counter__buttons{
  width: 20%; 
  height: 100%;  
  background: rgba(224, 224, 224, 0.253);
  // border-left: 5px  solid rgba(138, 138, 138, 0.514);
}
.counter__list{
  width: 30%; 
  height: 100%;  
  background: rgba(224, 224, 224, 0.253);

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