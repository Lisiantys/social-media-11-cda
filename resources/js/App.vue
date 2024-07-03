<template>
  <div id="app">
    <nav>
      <router-link to="/">Accueil</router-link>
      <router-link v-if="!isAuthenticated" to="/login">Connexion</router-link>
      <router-link v-if="!isAuthenticated" to="/register">Inscription</router-link>
      <router-link v-if="isAuthenticated" to="/profile">Profile</router-link>
      <router-link v-if="isAuthenticated" to="/create-post">Créer un post</router-link>
      <button v-if="isAuthenticated" @click="logout">Déconnexion</button>
    </nav>
    <router-view></router-view>
  </div>
</template>

<script>
import { computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from './store/auth';

export default {
  setup() {
    const authStore = useAuthStore();
    const router = useRouter();

    onMounted(() => {
      authStore.checkAuth();
    });

    const logout = async () => {
      try {
        await authStore.logout();
        router.push({ name: 'Home' });
      } catch (error) {
        console.error('Logout failed:', error);
      }
    };

    return {
      isAuthenticated: computed(() => authStore.isAuthenticated),
      logout,
    };
  },
};
</script>

  <style>
  #app {
    max-width: 800px;
    margin: 0 auto;
  }

  nav {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
    background-color: #007BFF;
    padding: 10px;
    border-radius: 5px;
  }

  nav a{
    color: white;
    text-decoration: none;
    padding: 8px 16px;
    border-radius: 5px;
    transition: background-color 0.3s;
  }

  nav a:hover {
    background-color: #0056b3;
  }

  button {
    background-color: #0056b3;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
  }

  button:hover {
    background-color: #003f7f;
  }

  button:focus {
    outline: none;
  }

  button:active {
    background-color: #003f7f;
  }
  </style>
