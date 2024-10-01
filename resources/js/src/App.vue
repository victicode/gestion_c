<template>
  <n-layout has-sider class="app-layout" position="absolute">
    <n-layout
      position="absolute"
      style="width:100%; height: 100vh; overflow: hidden; transition: all 0.3s;"
    >
      <n-layout-content
        class="layout-content"
        style="height: 100%;"
      >
        <router-view v-slot="{ Component }">
          <component :is="Component" />
        </router-view>
      </n-layout-content>
    </n-layout>
  </n-layout>
</template>

<script>
import { defineComponent, ref, computed } from 'vue'
import {
	useMessage,
	useDialog,
	useNotification,
	useLoadingBar,

} from 'naive-ui'
import { useRouter } from 'vue-router'

export default defineComponent({
	name: 'App',
	setup () {
		const router = useRouter()
		// mount on window
		window.$message = useMessage()
		window.$dialog = useDialog()
		window.$notification = useNotification()
		window.$loadingBar = useLoadingBar()
		const collapsed = ref(false)
		const activeName = ref('/')
		const handleMenuSelect = (value) => {
			activeName.value = value
			router.push({
				path: value,
			})
		}

		// config


		return {
      router,
			collapsed,
			activeName,
			handleMenuSelect,
		}
	},
})
</script>

<style scoped>
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
</style>