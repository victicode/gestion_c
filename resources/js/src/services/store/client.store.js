import { defineStore } from "pinia";
import ApiService from "@/services/axios/";
import JwtService from "@/services/jwt/";


export const useClientStore = defineStore("client", {
  actions: {
    async getClientByCi(CI) {
      return await new Promise((resolve, reject) => {
        if (JwtService.getToken()) {
          ApiService.setHeader();
          ApiService.get("/api/client/byCi?ci="+CI+'&')
          .then(({ data }) => {
            if(data.code !== 200) throw data;
            resolve(data)
          })
          .catch((response) => {
            console.log(response)
            reject('Error al cliente');
          });
        }
      })
    },
  },
});