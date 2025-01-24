<template>
  <div class="header-hoste w-100 " style="overflow: hidden; padding-left: 0px; padding-right: 0px; padding-bottom: 10px; " >
    <div  class="  header__section3 w-100" >
      <div  class="  w-100"  style="">
        <div class="host-header__container">
          <div class="items_header1 text-bold ">
            <div class="text-bold mb-0" style="font-size:2.5rem; color: white;">  
              {{ moment(date).format('MMMM Do YYYY, h:mm:ss a') }}
            </div>
          </div>  
          <div style="font-size: 3.4rem; display: flex; align-items: center; justify-content: end; padding:0.3rem;">
            <div style="width: 100px; display: flex; align-items: center; justify-content: center; height: 100px; border-radius: 50%; background: white;">
              <img :src="bcv" alt="" width="100px" height="100px">
            </div>
            <div style="color: white; font-weight: 600; text-decoration: underline; margin-left: 1rem;">
              56.28 Bs
            </div>
          </div>  
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import bcv from '@/assets/images/logo/bcv.png'

  import { inject, ref, onMounted } from 'vue';

  export default defineComponent({
	setup () {
    const moment = inject('moment')
    const date = ref()
    const clock = () =>{
      setInterval( ()=> {
        date.value = new Date
      },1000 )
    }

    onMounted(() => {
      date.value = new Date
      clock()
    })
    return {
      moment,
      date,
      bcv,

    }
  }
})
</script>
<style lang="scss" >
.header__section3 {
  padding: 0.5rem 0%;
}
.header-hoste{
  padding:  0.8%;
  padding-top:  0rem;
  padding-right: 50px;
  padding-left: 50px;

  & .n-card__content{
    padding: 8px 10px!important;
  }
}
.host-header__container{
  margin-top: -0.5rem;
  display:flex;
  justify-content: space-between;
  align-items: center;
}
.items_header1 {
  width: 50%
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
  .header-hoste{
    padding-top:  2%;
    padding: 3%;
    & .n-card__content{
      padding: 15px!important;
    }
  }
  .items_header {
    width: 50%;

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