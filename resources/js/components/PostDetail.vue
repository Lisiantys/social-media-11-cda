<template>
  <div v-if="post">
    <h2>{{ post.content }}</h2>
    <p>{{ post.tags }}</p>
    <p>Posted by: {{ post.user.name }}</p>
    <button @click="goBack">Retour</button>
    <button @click="editPost">Modifier</button>
    <button @click="deletePost">Supprimer</button>
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

<style>
h2 {
  margin-bottom: 10px;
}
p {
  margin-bottom: 10px;
}
button {
  margin-right: 10px;
  padding: 8px 16px;
  font-size: 16px;
  cursor: pointer;
}
</style>
