import { defineStore } from "pinia";
import ApiService from "@/services/axios/";
import JwtService from "@/services/jwt/";
import storage from "@/services/storage";

export const useAuthStore = defineStore("auth", {
  state: () => ({
    count: 0,
    errors: [],
    isAuthenticated: !!JwtService.getToken(),
    user: {},
  }),
  actions: {
    setAuth(user){
      this.isAuthenticated = true;
      this.errors = {};
      console.log(user)

      this.setUser(user.data)
      this.setIsAdmin(user.data)
    },
    setUser(user){
      this.user = user;
    },
    setIsAdmin(user){
      console.log(user)
      storage.setItem("is_admin",  user.rol_id);
      storage.setItem("user_unique_id",user.id);
    },
    setRememberAccount({email, password, remember}){
      storage.setItem("rememberUser", email);
      storage.setItem("rememberPassword", password);
      storage.setItem("isRemember", remember);
    },
    clearRememberAccount(){
      storage.deleteItem("rememberUser");
      storage.deleteItem("rememberPassword");
      storage.deleteItem("isRemember");
    },
    preLogin(credentials){
      this.clearRememberAccount()
      if(credentials.remember == true) this.setRememberAccount(credentials)
    },
    logoutAction(){
      storage.deleteItem("is_admin");
      storage.deleteItem("user_unique_id");
      this.isAuthenticated = false;
      this.user = {};
      this.errors = {};
      JwtService.destroyToken()
    },
    async login(credentials) {
      this.preLogin(credentials)
      return await new Promise((resolve, reject) => {
        ApiService.post("/api/auth/login", credentials)
          .then(({ data }) => {
            if(!data.data.access_token) throw data;
            
            JwtService.saveToken(data.data.access_token);
            if (JwtService.getToken()) {
              ApiService.setHeader();
              ApiService.get("api/user")
              .then((dataUser) => {

                if(dataUser.data.code !== 200) throw dataUser
                this.setAuth(dataUser.data)
                resolve(dataUser.data);

              }).catch( (response) => {
                console.log(response)
                reject(response);
              })
            }
          })
          .catch(({ response }) => {
            reject(response ? response.data.error : {});
          });
      })
    },
    async logout(){
      return await new Promise((resolve) => {
        if (JwtService.getToken()) {
          ApiService.setHeader();
          ApiService.get("api/auth/logout")
            .then(({ data }) => {
              if(data.code !== 200){
                throw data;
              }
              this.logoutAction()
              resolve(data)
            })
        }
      })
      .catch(( response ) => {
        console.log(response)
        resolve('Error al cerrar sesión');
      });
    },
    async register(credentials) {
      return await new Promise((resolve) => {
        ApiService.post("api/auth/register", credentials)
          .then(({ data }) => {
            if(!data.code){
              throw data;
            }
            this.login(credentials).then((dataUser) => {
              resolve(dataUser)
            })
            
          })
          .catch(({ response }) => {
            console.log(response.data)
            resolve(response.data);
          });
      })
    },
    async currentUser() {
      return await new Promise((resolve) => {
        if (JwtService.getToken()) {
          ApiService.setHeader();
          ApiService.get("/api/auth/current_user")
            .then(({ data }) => {
              if(data.code !== 200){
                throw data;
              }
              this.setUser(data.data)
              resolve(data)
            }).catch(( response ) => {
              console.log(response)
              resolve('Error al cerrar sesión');
            });
        }
      })
      .catch(( response ) => {
        console.log(response)
        resolve('Error al cerrar sesión');
      });
    }
  },
  getters: {
    doubleCount: (state) => {
      return state.count * 2;
    },
    doublePlusOne() {
      return this.doubleCount + 1
    },
  },
});