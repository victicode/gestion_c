import { defineStore } from "pinia";
import ApiService from "@/services/axios/";
import JwtService from "@/services/jwt/";


export const useTicketStore = defineStore("ticket", {
  actions: {
    async createTicket(data) {
      return await new Promise((resolve, reject) => {
        if (JwtService.getToken()) {
          ApiService.setHeader();
          ApiService.post("/api/ticket", data)
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