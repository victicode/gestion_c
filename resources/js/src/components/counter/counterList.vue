<template>
  <div class="h-100 ">
  <div class="h-100 list__section" v-if="Object.values(departament).length > 0">

    <div class="list__container" v-if="departament.tickets_pending.length > 0">
      <div v-for="(ticket, index) in departament.tickets_pending " :key="index">
        hola
      </div>
    </div>
    <div v-else class="list__container text-center" >
      <div style="margin-top: 2rem; font-size: 1rem; font-weight: 600">
        No hay ticket en la lista Pediatría
      </div>
    </div>
  </div>
  </div>
</template>
<script>
  import { storeToRefs } from 'pinia'
  import { useAuthStore } from "@/services/store/auth.store";
  import { inject, ref, onMounted, watch } from 'vue';

  
  export default defineComponent({
    props:{
      departament: Object,
    },
    setup (props) {
      const { user } = storeToRefs(useAuthStore())
      const loading = ref()
      const departament = ref(props.departament)
      const setLoading = (value) => {
        loading.value = value
      }

      watch(() => props.departament, (newValue) => {
        departament.value = newValue
      });

      return {
        user,
        loading,
        departament,
      }
    }
  })
</script>
<style lang="scss">
.list__section{
  padding: 1.5rem 0.5rem;
}
.list__container{
  padding: 1rem;
  height: 100%;
  background: white;
  border-radius: 10px;
  box-shadow: 0px 0px 5px 1px rgba(138, 138, 138, 0.253);

}

</style>