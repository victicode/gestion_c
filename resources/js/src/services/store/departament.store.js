import { defineStore } from "pinia";
import ApiService from "@/services/axios/";
import JwtService from "@/services/jwt/";
import storage from "@/services/storage";

export const useDepartamentStore = defineStore("departament", {
  actions: {
    async getDepartamentsWithPending() {
      return await new Promise((resolve, reject) => {
        if (JwtService.getToken()) {
          ApiService.setHeader();
          ApiService.get("/api/departament/get_pendings")
          .then(({ data }) => {
            if(data.code !== 200) throw data;
            resolve(data)
          })
          .catch((response) => {
            console.log(response)
            reject('Error al obtener departamento');
          });
        }
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
  },
});