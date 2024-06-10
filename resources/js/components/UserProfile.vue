<template>
    <div>
      <h2>User Profile</h2>
      <form @submit.prevent="updateProfile">
        <input type="text" v-model="form.pseudo" placeholder="Pseudo" required />
        <input type="email" v-model="form.email" placeholder="Email" required />
        <input type="password" v-model="form.password" placeholder="New Password" />
        <button type="submit">Update Profile</button>
        <button type="button" @click="deleteUser">Delete Account</button>
      </form>
      <div v-if="errors.length">
        <ul>
          <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
        </ul>
      </div>
    </div>
  </template>
  
  <script>
  import { ref, onMounted } from 'vue'
  import axios from 'axios'
  import { useRouter } from 'vue-router'
  
  export default {
    setup() {
      const router = useRouter()
      const form = ref({
        pseudo: '',
        email: '',
        password: ''
      })
      const errors = ref([])
  
      const fetchUserProfile = async () => {
        try {
          const response = await axios.get('/api/user', {
            headers: {
              Authorization: `Bearer ${localStorage.getItem('token')}`
            }
          })
          form.value = { ...response.data.user, password: '' }
        } catch (error) {
          console.error(error)
        }
      }
  
      const updateProfile = async () => {
        try {
          const response = await axios.put('/api/user', form.value, {
            headers: {
              Authorization: `Bearer ${localStorage.getItem('token')}`
            }
          })
          alert(response.data.message)
          errors.value = []
        } catch (error) {
          if (error.response && error.response.status === 422) {
            errors.value = Object.values(error.response.data.errors).flat()
          } else {
            console.error(error)
          }
        }
      }
  
      const deleteUser = async () => {
        try {
          const response = await axios.delete('/api/user', {
            headers: {
              Authorization: `Bearer ${localStorage.getItem('token')}`
            }
          })
          alert(response.data.message)
          localStorage.removeItem('token')
          router.push('/login')
        } catch (error) {
          console.error(error)
        }
      }
  
      onMounted(fetchUserProfile)
  
      return { form, updateProfile, deleteUser, errors }
    }
  }
  </script>
  