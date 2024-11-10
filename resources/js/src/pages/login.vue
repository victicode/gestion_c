<template>
  <section id="sistemPage">
    <div />
    <div class="w-100">
      <div class="login__container" style="margin: auto;">
        <div class="header_form w-100" >
          <n-h1 class="mb-0 text-center text-white">Gestión de cola SIAMTEL</n-h1>
        </div>
        <n-card style="" class="sistem-page px-0 w-100" >
          <n-form ref="formRef" :model="user" :rules="rules">
            <n-form-item path="user" label="Usuario" style="margin-bottom: 0.5rem; margin-top: 0.8rem;">
              <n-input v-model:value="user.user" type="text" placeholder="Usuario" clearable />
            </n-form-item>
            <n-form-item path="password" label="Contraseña">
              <n-input
                type="password"
                show-password-on="click"
                placeholder="Contraseña"
                clearable
                v-model:value="user.password"
                @keydown.enter.prevent
              >
                <template #password-visible-icon>
                  <n-icon :size="'1.3rem'" :component="EyeOffOutline" />
                </template>
                <template #password-invisible-icon>
                  <n-icon :size="'1.3rem'" :component="EyeOutline" />
                </template>
              </n-input>

            </n-form-item>
            <n-checkbox size="large" label="Recuerdame" v-model:checked="remember" style="margin-bottom:12px"/>
            <n-row :gutter="[0, 24]">
              <n-col :span="24">
                <div style="display: flex; justify-content: flex-end">
                  <n-button
                    round
                    type="primary"
                    :loading="loading"
                    @click="handleValidateButtonClick($event)"
                  >
                    Ingresar
                  </n-button>
                </div>
              </n-col>
            </n-row>
          </n-form>
        </n-card>
      </div>
    </div>
    <div style="z-index: 1;" >
      <n-h6>
        desing by 
        <a href="https://github.com/victicode" target="_blank" class="design_author">
          Victicode🧙‍♂️
        </a>
      </n-h6>  
    </div>
  </section> 
</template>

<script>
import { defineComponent, ref } from "vue";
import { useMessage } from "naive-ui";
import { EyeOutline, EyeOffOutline } from '@vicons/ionicons5'
import { useAuthStore } from "@/services/store/auth.store";
import storage from "@/services/storage";
import { useRouter } from "vue-router";

export default defineComponent({
  setup() {
    const formRef = ref(null);
    const message = useMessage();
    const authStore = useAuthStore()
    const router = useRouter()
    const remember = ref(storage.getItem('isRemember') === 'true' ?? false)
    const user = ref({
      user: storage.getItem('rememberUser') ?? '',
      password: storage.getItem('rememberPassword') ?? '',
    });
    const loading = ref(false)
    const rules = {
      user: [
        {
          required: true,
          message: "Usuario es requerido",
          trigger: ["input", "blur"]
        }
      ],
      password: [
        {
          required: true,
          message: "Contraseña es requerida",
          trigger: ["input", "blur"]
        }
      ],
    };
    const handleValidateButtonClick = (e) =>  {
      e.preventDefault();
      formRef.value?.validate((errors) => {
          if (!errors) {
            login()
          } else {
            message.error("Debes completar el formulario");
          }
        });
    }
    const login = () => {
      loading.value = true
      const data = {
        email: user.value.user,
        password: user.value.password,
        remember: remember.value
      }
      authStore.login(data)
      .then((response) => {

        message.success('Inicio de sesión correcto!');
        setTimeout(() => {            
          response.data.rol_id == 1 
          ? router.push('/admin')
          : response.data.rol_id == 3 
          ? router.push('/counter')
          : router.push('/host')
          
        }, 500);
      })
      .catch((response) => {
        message.error(response.message);
        loading.value = false
      })
    }
    return {
      formRef,
      user,
      remember,
      rules,
      loading,
      EyeOutline,
      EyeOffOutline,
      handleValidateButtonClick
    };
  }
});
</script>
<style lang="scss" >
  .login__container{
    width: 40%;
  }
  .design_author{
    cursor: pointer;
  }
  .header_form{
    background: green;
    margin: auto;
    padding: 20px;
    border-top-left-radius: 30px;
    border-top-right-radius: 30px;
  }
  .n-input {
    padding: 7px;
  }

  @media screen and (max-width: 780px){
    .login__container{
      width: 90%;
    }
  }

</style>