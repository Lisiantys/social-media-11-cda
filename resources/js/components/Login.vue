<template>
    <div>
      <h2>Connexion</h2>
      <form @submit.prevent="login">
        <input type="email" v-model="form.email" placeholder="Email" required />
        <input type="password" v-model="form.password" placeholder="Password" required />
        <button type="submit">Valider</button>
      </form>
    </div>
  </template>

  <script>
import { ref } from 'vue'
import axios from 'axios'
import { useAuthStore } from '../store/auth';
import { useRouter } from "vue-router";

export default {
  setup() {
    const form = ref({
      email: '',
      password: ''
    })

    const authStore = useAuthStore();
    const router = useRouter();

    const login = async () => {
      try {
        authStore.login(form.value);
        router.push('/');
      } catch (error) {
        console.log('Error during login:', error)
      }
    }

    return { form, login }
  }
}
</script>

  <style scoped>
  .auth-container {
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }

  h2 {
    color: #007BFF;
    margin-bottom: 20px;
    text-shadow: 1px 1px 2px black;
  }

  form {
    display: flex;
    flex-direction: column;
    gap: 15px;
  }

  input {
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
    transition: border-color 0.3s;
  }

  input:focus {
    border-color: #007BFF;
    outline: none;
  }

  button {
    padding: 10px 20px;
    font-size: 16px;
    color: white;
    background-color: #007BFF;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
  }

  button:hover {
    background-color: #0056b3;
  }

  button:focus {
    outline: none;
  }

  button:active {
    background-color: #003f7f;
  }
  </style>
