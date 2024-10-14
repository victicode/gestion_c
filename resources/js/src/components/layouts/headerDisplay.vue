<template>
  <div class="header-host w-100 h-100" style="overflow: hidden; " >
    <div  class="  header__section w-100" >
      <n-card  class="host-page  w-100"  style=" padding: 0.2rem 2rem;">
        <div class="host-header__container">
          <div class="items_header text-bold">
            <n-h2 class="text-bold mb-0"> 
              {{ moment(date).format('MMMM Do YYYY, h:mm:ss a') }}
            </n-h2>
          </div>    
          <div class="items_header" style="text-align: end" >
            <img src="https://siamtel.lara.gob.ve/fundacion-siamtel/wp-content/uploads/2021/02/cintillo.png"   width="200"/>
          </div>
        </div>
      </n-card>
    </div>
  </div>
</template>
<script>

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
  .header-host{
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