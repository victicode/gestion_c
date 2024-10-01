<template>
  <n-config-provider
    class="demo"
    :theme-overrides="themeOverrides"
  >
    <n-dialog-provider>
      <n-message-provider>
        <n-notification-provider>
          <n-loading-bar-provider>
            <App />
          </n-loading-bar-provider>
        </n-notification-provider>
      </n-message-provider>
    </n-dialog-provider>
  </n-config-provider>
</template>

<script >
import { defineComponent } from 'vue'
import {
	NConfigProvider,
	NMessageProvider,
	NDialogProvider,
	NNotificationProvider,
	NLoadingBarProvider,
} from 'naive-ui'
import App from '@/App.vue'

const themeOverrides = {
	common: {
		primaryColor: '#4fb233',
		primaryColorHover: '#4fb233',
		fontSize: '16px',
		borderRadius: '16px',
	},

}

export default defineComponent({
	name: 'Provider',
	components: { App, NConfigProvider, NMessageProvider, NDialogProvider, NNotificationProvider, NLoadingBarProvider, },
	setup () {
		return {
			themeOverrides,
		}
	},
})
</script>