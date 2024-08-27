<template>
    <div>
      <h2>S'enregistrer</h2>
      <form @submit.prevent="register">
        <input type="text" v-model="form.pseudo" placeholder="Pseudo" required />
        <input type="email" v-model="form.email" placeholder="Email" required />
        <input type="password" v-model="form.password" placeholder="Password" required />
        <button type="submit">Valider</button>
      </form>
      <div v-if="errors.length" class="errors">
      <ul>
        <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
      </ul>
    </div>
    </div>
  </template>

  <script>
import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from "vue-router"

export default {
  setup() {
    const form = ref({
      pseudo: '',
      email: '',
      password: ''
    })

    const errors = ref([]);
    const router = useRouter();

    const register = async () => {
      try {
        const response = await axios.post('api/register', form.value);
        alert(response.data.message);
        errors.value = [];
        router.push('/');
      } catch (error) {
        if (error.response) {
          errors.value = Object.values(error.response.data.errors || { message: error.response.data.message })
          console.log('Error response data:', error.response.data)
        } else if (error.request) {
          errors.value = ['No response received from the server.']
          console.log('Error request data:', error.request)
        } else {
          errors.value = [error.message]
          console.log('Error message:', error.message)
        }
      }
    }

    return { form, register, errors }
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

.errors {
  color: red;
  margin-top: 10px;
}
</style>
