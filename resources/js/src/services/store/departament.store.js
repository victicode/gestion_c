import { defineStore } from "pinia";
import ApiService from "@/services/axios/";
import JwtService from "@/services/jwt/";

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
    async getDepartamentsWithPendingPublic() {
      return await new Promise((resolve, reject) => {
          ApiService.get("/api/departament/display")
          .then(({ data }) => {
            if(data.code !== 200) throw data;
            resolve(data)
          })
          .catch((response) => {
            console.log(response)
            reject('Error al obtener departamento');
          });
      })
    },
    async getDepartamentQueueById(id) {
      return await new Promise((resolve, reject) => {
        if (JwtService.getToken()) {
          ApiService.setHeader();
          ApiService.get("/api/departament/queue/"+id)
          .then(({ data }) => {
            if(data.code !== 200) throw data;
            resolve(data)
          })
          .catch((response) => {
            console.log(response)
            reject('Error al obtener el departamento');
          });
        }
      })
    },
    async updateLimit(data) {
      return await new Promise((resolve, reject) => {
        if (JwtService.getToken()) {
          ApiService.setHeader();
          ApiService.post("/api/departament/updateLimit/"+data.id, data)
          .then(({ data }) => {
            if(data.code !== 200) throw data;
            resolve(data)
          })
          .catch((response) => {
            console.log(response)
            reject('Error al obtener el departamento');
          });
        }
      })
    } 
  },
});