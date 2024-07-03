<template>
    <div v-if="post" class="post-details">
      <div class="post-header">
        <h2>{{ post.content }}</h2>
        <div class="post-meta">
          <p><strong>Tags:</strong> {{ post.tags }}</p>
          <p><strong>Publié par:</strong> {{ post.user.pseudo }}</p>
          <p><strong>Email:</strong> {{ post.user.email }}</p>
          <p><strong>Le:</strong> {{ new Date(post.created_at).toLocaleDateString() }}</p>
        </div>
      </div>
      <div class="post-actions">
        <button @click="goBack">Retour</button>
        <button @click="editPost">Modifier</button>
        <button @click="deletePost">Supprimer</button>
      </div>
      <PostForm v-if="isEditing" :post="post" @postUpdated="fetchPost" />
    </div>
  </template>

  <script>
  import { ref, onMounted } from 'vue'
  import { useRoute, useRouter } from 'vue-router'
  import axios from 'axios'
  import PostForm from './PostForm.vue'

  export default {
    components: {
      PostForm
    },
    setup() {
      const post = ref(null)
      const isEditing = ref(false)
      const route = useRoute()
      const router = useRouter()

      const fetchPost = async () => {
        try {
          const response = await axios.get(`/api/posts/${route.params.id}`)
          post.value = response.data.post
        } catch (error) {
          console.error('Error fetching post:', error)
        }
      }

      const goBack = () => {
        router.push('/')
      }

      const editPost = () => {
        isEditing.value = true
      }

      const deletePost = async () => {
        try {
          await axios.delete(`/api/posts/${route.params.id}`, {
            headers: {
              Authorization: `Bearer ${localStorage.getItem('token')}`
            }
          })
          router.push('/')
        } catch (error) {
          console.error('Error deleting post:', error)
        }
      }

      onMounted(fetchPost)

      return { post, isEditing, fetchPost, goBack, editPost, deletePost }
    }
  }
  </script>

  <style scoped>
  .post-details {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }

  .post-header {
    margin-bottom: 20px;
  }

  h2 {
    margin-bottom: 10px;
  }

  .post-meta p {
    margin-bottom: 5px;
  }

  .post-actions {
    display: flex;
    gap: 10px;
    margin-top: 20px;
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
