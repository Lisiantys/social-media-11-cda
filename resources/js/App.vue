<template>
    <div id="app">
      <nav>
        <router-link to="/">Home</router-link>
        <router-link v-if="!isAuthenticated" to="/login">Login</router-link>
        <router-link v-if="!isAuthenticated" to="/register">Register</router-link>
        <router-link v-if="isAuthenticated" to="/profile">Profile</router-link>
        <button v-if="isAuthenticated" @click="goToCreatePost">Create Post</button>
      </nav>
      <router-view></router-view>
    </div>
  </template>
  
  <script>
  import { ref } from 'vue'
  import { useRouter } from 'vue-router'
  
  export default {
    setup() {
      const isAuthenticated = ref(!!localStorage.getItem('token'))
      const router = useRouter()
  
      const goToCreatePost = () => {
        router.push('/create-post')
      }
  
      return { isAuthenticated, goToCreatePost }
    }
  }
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
  }
  button {
    margin-bottom: 20px;
  }
  </style>
  