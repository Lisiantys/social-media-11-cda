<template>
    <div>
      <h2>Login</h2>
      <form @submit.prevent="login">
        <input type="email" v-model="form.email" placeholder="Email" required />
        <input type="password" v-model="form.password" placeholder="Password" required />
        <button type="submit">Login</button>
      </form>
    </div>
  </template>
  
  <script>
  import { ref } from 'vue'
  import axios from 'axios'
  
  export default {
    setup() {
      const form = ref({
        email: '',
        password: ''
      })
  
      const login = async () => {
        try {
          const response = await axios.post('/api/login', form.value)
          localStorage.setItem('token', response.data.token)
          alert(response.data.message)
        } catch (error) {
          console.error(error)
        }
      }
  
      return { form, login }
    }
  }
  </script>
  