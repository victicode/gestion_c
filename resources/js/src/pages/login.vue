<template>
  <section id="loginPage">
    <div />
    <div class="w-100">
      <div class="w-40" style="margin: auto;">
        <div class="header_form w-100" >
          <n-h1 class="mb-0 text-center text-white">Gestión de cola SIAMTEL</n-h1>
        </div>
        <n-card style="" class="loginPage px-0 w-100" >
          <n-form ref="formRef" :model="user" :rules="rules">
            <n-form-item path="user" label="Usuario" style="margin-bottom: 0.5rem; margin-top: 0.8rem;">
              <n-input v-model:value="user.user" type="text" placeholder="Usuario" >
              </n-input>
            </n-form-item>
            <n-form-item path="password" label="Contraseña">
              <n-input
                type="password"
                show-password-on="click"
                placeholder="Contraseña"
                v-model:value="user.password"
                @input="handlePasswordInput"
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
            <n-row :gutter="[0, 24]">
              <n-col :span="24">
                <div style="display: flex; justify-content: flex-end">
                  <n-button
                    :disabled="user.age === null"
                    round
                    type="primary"
                    @click="handleValidateButtonClick"
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

export default defineComponent({
  setup() {
    const formRef = ref(null);
    const rPasswordFormItemRef = ref(null);
    const message = useMessage();
    const user = ref({
      user: null,
      password: null,
    });
    function validatePasswordStartWith(rule, value) {
      return !!modelRef.value.password && modelRef.value.password.startsWith(value) && modelRef.value.password.length >= value.length;
    }
    function validatePasswordSame(rule, value) {
      return value === modelRef.value.password;
    }
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
          message: "Contraseña es requerida"
        }
      ],
    };
    return {
      formRef,
      user,
      rules,
      EyeOutline,
      EyeOffOutline,
      handlePasswordInput() {
        if (modelRef.value.reenteredPassword) {
          rPasswordFormItemRef.value?.validate({ trigger: "password-input" });
        }
      },
      handleValidateButtonClick(e) {
        e.preventDefault();
        formRef.value?.validate(
          (errors) => {
            if (!errors) {
              message.success("Valid");
            } else {
              console.log(errors);
              message.error("Invalid");
            }
          }
        );
      }
    };
  }
});
</script>
<style lang="scss" >
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
  #loginPage{
    display: flex;
    justify-content: space-between;
    flex-direction: column;
    align-items: center;
    height: 100%;
    background: #05A952 !important;
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
  .loginPage {
    border-top-left-radius: 0px;
    border-top-right-radius: 0px;
    border-bottom-left-radius: 30px;
    border-bottom-right-radius: 30px;
    border: 0px;
    box-shadow: #00000061 0px 7px 5px 0px;
  }
  @media screen and (max-width: 780px){
    .loginPage{
      width: 100%;
      margin: auto;
      height: 100%;
      border-radius: 0px;
      border: 0px;

      & .n-card__content{
        border: 0px;
        display: flex;
        flex-direction: column;
        justify-content: center;
      }
    }
  }

</style>