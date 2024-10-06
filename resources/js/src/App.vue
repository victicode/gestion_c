<template>
  <n-layout has-sider class="app-layout" position="absolute">
    <n-layout
      position="absolute"
      style="width:100%; height: 100vh; overflow: hidden; transition: all 0.3s; background: transparent"
    >
      <transition name="vertical">
        <n-layout-content
          v-if="readyState && readyState2"
          class="layout-content"
          style="height: 100%;"
        >
          <router-view v-slot="{ Component }">
            <transition name="vertical" >
              <component :is="Component"/>
            </transition>
          </router-view>
        </n-layout-content>
      </transition>
      <transition name="vertical">
        <div  v-if="!readyState" class="loadingPage">
          <n-spin :show="true" size="large" stroke="primary" />
        </div>
      </transition>
    </n-layout>
  </n-layout>
</template>

<script>
import { defineComponent, ref } from 'vue'
import {
	useMessage,
	useDialog,
	useNotification,
	useLoadingBar,

} from 'naive-ui'
import { useRouter, useRoute } from 'vue-router'
import {useAuthStore} from '@/services/store/auth.store'
import utils from '@/util/httpUtil.js'

export default defineComponent({
	name: 'App',
	setup () {
		const router = useRouter()
    const route = useRoute()
    const readyState = ref(false)
    const readyState2 = ref(false)
    const authStore = useAuthStore()

		// mount on window

		window.$message = useMessage()
		window.$dialog = useDialog()
		window.$notification = useNotification()
		window.$loadingBar = useLoadingBar()

    const isReady = () => {
      readyState.value =  route.name == 'dashboard' || route.name == 'dashboard_admin' ? false : true
      readyState2.value =  route.name == 'Login' ? true : false
    }
    const getCurrentUser = (inject = null) =>{
      if(exceptionsToShow()) return

      authStore.currentUser().then((data)=>{
        if(data.code !== 200 ) throw data
        console.log(data)
        readyState.value = true
        readyState2.value = true
      }).catch((e) => { 
        utils.errorLogout( () => router.push('/login'))
      })
    }
    const exceptionsToShow = () => {
      const user = useAuthStore().user;
      if(route.name == 'Login') {
        readyState2.value = true
        return true
      }
      if(route.name !== 'dashboard' && route.name != 'dashboard_admin' && Object.values(user).length > 0) {
        readyState2.value = true
        return true
      }
      return false
    }
    watch(route, () => {
      isReady()
      getCurrentUser()
    })

    onMounted(() =>{
      isReady()
    
    })

		return {
      readyState2,
      readyState,
      router,
		}
	},
})
</script>

<style scoped lang="scss">
.loadingPage {
  width:100%; 
  height:100vh; 
  display:flex; 
  justify-content:center; 
  align-items:center;
  background: white;
}
.app-layout-sider__title {
  display: flex;
  align-items: center;
  margin-top: 40px;
  margin-bottom: 20px;
  padding-left: 20px;
  height: 28px;
  color: #333;
  font-weight: 500;
  font-size: 20px;
}
.n-layout-header {
  padding: 24px;
  display: flex;
  justify-content: flex-end;
}
.n-layout-header span {
  cursor: pointer;
}
.app-layout {
  background: $primary !important;
  &::before{
    background-image: url('https://siamtel.lara.gob.ve/fundacion-siamtel/sistema-siamtel/assets/imagenes/logo/logo.svg');
    content: '';
    position: absolute;
    z-index: 0;
    background-repeat: no-repeat;
    opacity: 0.04;
    width: 100%;
    height: 100%;
  }
}
</style>