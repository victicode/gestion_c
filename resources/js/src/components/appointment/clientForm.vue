<template>
  <div class="form__container mt-2"> 
    <n-card  class="host-page px-0 w-100 h-100" style="max-height:100%" >
      <div>
        <div class="flex justify-between items-center w-100">
          <div class=" text-h5 " style="margin-bottom:5px">Bienvenidos a nuestro sistema de citas🩺 </div>
          <div class=" text-h5 " style="margin-bottom:5px">Paso 1/3</div>
        </div>
        <div class=" text-h2 w-100 text-bold " style="margin-bottom:5px">Ingresa tus datos</div>
        <div class="form-ticket">
          <n-form ref="formTicket" :model="client" :rules="rules" class="clientTicketForm">
            <n-form-item label="Departamento" style="" class="">
              <n-select
                v-model:value="client.dep"
                filterable
                clearable
                placeholder="Departamento al cual asistiré"  
                size="large"
                label-field="name"
                value-field="id"
                class=""
                menu-size="large"
                :options="departaments"
                @update:value="validateToSend"
              />
            </n-form-item>
            <div style="display:flex; flex-wrap:wrap; margin-top:1%">
              <n-form-item path="ci" label="Cédula de identidad" class="items__ticket-form">
                <n-input 
                  v-model:value="client.ci" 
                  type="text" 
                  placeholder="Cédula de indentidad" 
                  clearable 
                  size="large" 
                  maxlength="8" 
                  @input="validateToSend()"
                  :allow-input="onlyAllowNumber"
                />
              </n-form-item>
              <n-form-item path="name" label="Nombre completo" style="" class="items__ticket-form">
                <n-input 
                  v-model:value="client.name" 
                  type="text" 
                  placeholder="Nombre completo" 
                  clearable 
                  size="large"
                  @input="validateToSend()"
                  :allow-input="onlyName"
                />
              </n-form-item>
              <n-form-item path="phone" label="Teléfono" style="" class="items__ticket-form">
                <n-input 
                  v-model:value="client.phone" 
                  type="text" 
                  placeholder="Número telefónico" 
                  clearable 
                  size="large" 
                  maxlength="11"
                  :allow-input="onlyAllowNumber"
                  @input="validateToSend()"
                />
              </n-form-item>
              <n-form-item path="email" label="Correo electrónico (opcional)" style="" class="items__ticket-form">
                <n-input 
                  v-model:value="client.email" 
                  type="text" 
                  placeholder="Correo@gmail.com" 
                  clearable 
                  size="large"
                  @keyup="validateToSend()"
                />
              </n-form-item>
              
            </div>
          </n-form>
        </div>
      </div>
    </n-card>
  </div>
</template>
<script>
import { defineComponent, onMounted, ref, watch} from "vue";
import { useMessage } from "naive-ui";
import { useClientStore } from '@/services/store/client.store.js'
import { useDepartamentStore } from "@/services/store/departament.store";

export default defineComponent({
  props: {
    'dataClient': Object
  },
  emits: ['selectedUser'],
  setup (props, { emit }) {
    const clientStore = useClientStore()
    const departamentStore = useDepartamentStore()

    const formTicket = ref(null);
    const departaments = ref([]);
    const departament = ref(0);

    
    const message = useMessage();
    const loadingInput = ref(true)

    console.log(props)
    const client = ref({
      id:  props.dataClient.id ?? null,
      name:  props.dataClient.name ?? '',
      ci: props.dataClient.ci ?? '',
      phone:  props.dataClient.phone ?? '',
      email:  props.dataClient.email ?? '',
      dep: props.dataClient.departament ?? 0
    });

    const rules = {
      name: [
        {
          validator(rule, value) {
            if (!value) {
              return new Error("El nombre es requerido");
            } 
            else if ((/[0-9,%"'=@:();&|<>]/.test(value)) ) {
              return new Error("Nombre no valido");
            }
            return true;
          },
          trigger: ["input", "blur"]
        }
      ],
      ci: [
        {
          validator(rule, value) {
            if (!value) {
              return new Error("El número de cédula es requerido");
            } else if (!/^\d*$/.test(value)) {
              return new Error("Deben ser solo números");
            } else if (value.length < 7) {
              return new Error("Número de cédula no valido");
            }
            return true;
          },
          trigger: ["input", "blur"]
        }
      ],
      phone: [
        {
          validator(rule, value) {
            if (!value) {
              return new Error("El número de teléfono es requerido");
            } else if (!/^\d*$/.test(value)) {
              return new Error("Deben ser solo números");
            } else if (value.length < 11) {
              return new Error("Número de teléfono no valido");
            }
            return true;
          },
          trigger: ["input", "blur"]
        }
      ],
      email: [
        {
          validator(rule, value) {
            if ((/[,%"'= :();&|<>]/.test(value)) ) {
              return new Error("Correo no valido");
            }
            return true;
          },
          trigger: ["input", "blur"]
        }
      ],
    };
    const searchClient = () => {
      if(client.value.ci.length < 7) return

      loadingInput.value = true
      loadingInputAction()

      clientStore.getClientByCi(client.value.ci)
      .then((response) => {
        setUser(response.data ?? {})
        if(!response.data) { 
          loadingInput.value = false
          return
        }
        formTicket.value?.validate()
        emit('selectedUser', {...client.value, check:false})
      })
      .catch((response) => {
        console.log()
      })
    }
    
    const loadingInputAction = () => {
      client.value.name   = 'Cargando...';
      client.value.phone  = 'Cargando...';
      client.value.email  = 'Cargando...';
    } 

    const setUser = ({name, phone, email, id,}) => {
      client.value.name   = name ?? '';
      client.value.phone  = phone ?? '';
      client.value.email  = email ?? '';
      client.value.id  = id ?? null;
    }

    const validateToSend = () =>  {
      let check = true
      if(!client.value.ci) check = false
      if(!client.value.name) check = false
      if(!client.value.phone || client.value.phone.length < 11)  check = false
      if(!client.value.dep)  check = false
      emit('selectedUser', {...client.value, check})
      
    }
    
    const getDepartaments = () =>{
      departamentStore.getDepartamentsPublicApp()
      .then((response) => {
        if(response.code !== 200) throw response
        departaments.value = [
          {id:0, name:'Selecciona un departamento'},
          ...response.data
        ]
      })
    }
    onMounted(() => {
      getDepartaments()
    })

    return {
      formTicket,
      client,
      rules,
      departaments,
      loadingInput,
      validateToSend,
      searchClient,
      onlyAllowNumber: (value) => !value || /^\d+$/.test(value),
      onlyName: (value) => !value || !/[0-9,%"'=@:();&|<>]/.test(value),
    };
  }
});
</script>
<style lang="scss">
  .n-base-select-menu .n-base-select-option.n-base-select-option--show-checkmark{
    margin-top: 10px;
  }
  .form-ticket{
    margin-top: 5%
  }
  .clientTicketForm{
    & .n-input .n-input-wrapper {
      height:45px;
    }
    & .n-input__input-el{
      transform: translateY(3px)
    }
  }
  .items__ticket-form{
    width:50%;

    & .n-input.n-input--disabled{
      background-color: #e3e3e3;
      
      & .n-input__input-el{
        color:#0000007e!important;
      }
    }
    &:nth-child(even){
      padding-left: 10px;
    }
  }
  .form__container{
    padding: 0px 25%;
    & .n-card.n-card--bordered {
      padding: 0px 0%;
    }
  }
  @media screen and (max-width: 780px){ 
    .form__container{
      padding: 0px 2%;
      & .n-card.n-card--bordered {
        padding: 0px 5%;
      }
    }
    .items__ticket-form{
      width:100%;
      &:nth-child(even){
        padding-left: 0px;
      }
    }
  }
</style>