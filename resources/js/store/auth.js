import { defineStore } from 'pinia';
import { useRouter } from "vue-router";

import axios from 'axios';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
  }),
  actions: {
    async checkAuth() {
      if (!this.user) { // Ne fait la requête que si l'utilisateur n'est pas déjà dans l'état
        try {
          const response = await axios.get('/api/user');
          this.user = response.data.user;
        } catch (error) {
          this.user = null;
          if (error.response && error.response.status !== 401) {
            console.error('Erreur lors de la vérification de l\'authentification :', error);
          }
        }
      }
    },
    async getCsrfToken(){
      return await axios.get('/sanctum/csrf-cookie');
    },
    async login(credentials) {
      try {
        await this.getCsrfToken();
        const res = await axios.post('/api/login', credentials);
        this.user = res.data.user;
        console.log(res);
        await this.checkAuth();
      } catch (error) {
        console.log(error);
      }
    },
    async logout() {
      try {
        await axios.post('/api/logout');
        this.user = null;
      } catch (error) {
        console.error('Logout failed:', error);
        throw new Error('Logout failed');
      }
    },
    async register(data) {
      try {
        await axios.post('/api/register', data);
        await this.checkAuth();
      } catch (error) {
        throw new Error('Registration failed');
      }
    },
  },
  getters: {
    //utilisé pour afficher ou masquer des éléments d'interface utilisateur en fonction de l'état de l'authentification
    isAuthenticated: (state) => !!state.user,
  },
  persist: true,
});
