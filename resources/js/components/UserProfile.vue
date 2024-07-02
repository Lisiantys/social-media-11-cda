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
      password: '',
      image: null
    })
    const errors = ref([])

    const fetchUserProfile = async () => {
      try {
        const response = await axios.get('/api/user', {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`
          }
        })
        form.value = { ...response.data.user, password: '', image: null }
      } catch (error) {
        console.error(error)
      }
    }

    const updateProfile = async () => {
      try {
        const formData = new FormData()
        formData.append('pseudo', form.value.pseudo)
        formData.append('email', form.value.email)
        if (form.value.password) {
          formData.append('password', form.value.password)
          formData.append('password_confirmation', form.value.password)
        }
        if (form.value.image) {
          formData.append('image', form.value.image)
        }

        const response = await axios.post('/api/user', formData, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`,
            'Content-Type': 'multipart/form-data'
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


<style scoped> 
.profile-container {
max-width: 600px;
margin: 0 auto;
padding: 20px;
background-color: #f9f9f9;
border-radius: 5px;
box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h2 {
color: #007BFF;
margin-bottom: 20px;
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

.button-group {
display: flex;
gap: 10px;
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
margin-top: 20px;
color: red;
}

.errors ul {
list-style-type: none;
padding: 0;
}

.errors li {
margin-bottom: 5px;
}
</style>
