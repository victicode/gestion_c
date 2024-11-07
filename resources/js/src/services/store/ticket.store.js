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
            reject(response);
          });
        }
      })
    },
    async nextTicket(data) {
      return await new Promise((resolve, reject) => {
        if (JwtService.getToken()) {
          ApiService.setHeader();
          ApiService.get("/api/ticket/next/"+data)
          .then(({ data }) => {
            if(data.code !== 200) throw data;
            resolve(data)
          })
          .catch((response) => {
            reject(response);
          });
        }
      })
    },
    async recallTicket(data) {
      return await new Promise((resolve, reject) => {
        if (JwtService.getToken()) {
          ApiService.setHeader();
          ApiService.get("/api/ticket/recall/"+data)
          .then(({ data }) => {
            if(data.code !== 200) throw data;
            resolve(data)
          })
          .catch((response) => {
            if(response.code === 201) {
              reject('No hay tickets');
            }
            reject(response);
          });
        }
      })
    },
    async posNextTicket(data) {
      return await new Promise((resolve, reject) => {
        if (JwtService.getToken()) {
          ApiService.setHeader();
          ApiService.get("/api/ticket/posNext/"+data)
          .then(({ data }) => {
            if(data.code !== 200) throw data;
            resolve(data)
          })
          .catch((response) => {
            if(response.code === 201) {
              reject('No hay tickets');
            }
            reject(response);
          });
        }
      })
    },
    async deleteTicket(ticketId) {
      return await new Promise((resolve, reject) => {
        if (JwtService.getToken()) {
          ApiService.setHeader();
          ApiService.post("/api/ticket/delete/"+ticketId)
          .then(({ data }) => {
            if(data.code !== 200) throw data;
            resolve(data)
          })
          .catch((response) => {
            console.log(response)
            reject('Error al borrar el ticket');
          });
        }
      })
    },
  },
});