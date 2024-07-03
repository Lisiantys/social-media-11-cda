import { defineStore } from 'pinia';
import axios from 'axios';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
  }),
  actions: {
    async checkAuth() {
      try {
        const response = await axios.get('/api/user');
        this.user = response.data.user;
      } catch (error) {
        this.user = null;
      }
    },
    async login(credentials) {
      try {
        await axios.post('/api/login', credentials);
        await this.checkAuth();
      } catch (error) {
        throw new Error('Login failed');
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
    isAuthenticated: (state) => !!state.user,
  },
});
