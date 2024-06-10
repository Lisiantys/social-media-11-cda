<template>
    <div>
      <h2>Register</h2>
      <form @submit.prevent="register">
        <input type="text" v-model="form.pseudo" placeholder="Pseudo" required />
        <input type="email" v-model="form.email" placeholder="Email" required />
        <input type="password" v-model="form.password" placeholder="Password" required />
        <button type="submit">Register</button>
      </form>
    </div>
  </template>
  
  <script>
  import { ref } from 'vue'
  import axios from 'axios'
  
  export default {
    setup() {
      const form = ref({
        pseudo: '',
        email: '',
        password: ''
      })
  
      const register = async () => {
        try {
          const response = await axios.post('/api/register', form.value)
          alert(response.data.message)
        } catch (error) {
          console.error(error)
        }
      }
  
      return { form, register }
    }
  }
  </script>
  