<template>
  <div class="header-host w-100 " style="overflow: hidden; padding-left: 0px; padding-right: 0px; padding-bottom: 10px; " >
    <div  class="  header__section2 w-100" >
      <div  class="  w-100"  style=" padding: 0rem 1rem;">
        <div class="host-header__container">
          <div class="items_header1 text-bold">
            <n-h1 class="text-bold mb-0"> 
              {{ moment(date).format('MMMM Do YYYY, h:mm:ss a') }}
            </n-h1>
          </div>    
          <div class="items_header2" style="text-align: center; font-weight: bold; font-size: 2.5rem;" >
            Logo 
          </div>
        </div>
      </div>
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
.header__section2 {
  padding: 1.8rem 0%;
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
.items_header1 {
  width: 70%
}
.items_header2 {
  width: 20%;
  transform: rotate(40deg) translateY(0.5rem) translateX(-0.5rem);
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