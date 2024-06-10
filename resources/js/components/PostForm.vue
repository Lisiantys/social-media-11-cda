<template>
  <div>
    <h2>{{ post ? 'Edit Post' : 'Create Post' }}</h2>
    <form @submit.prevent="submitForm">
      <textarea v-model="form.content" placeholder="Content" required></textarea>
      <input type="text" v-model="form.tags" placeholder="Tags" required />
      <button type="submit">{{ post ? 'Update Post' : 'Create Post' }}</button>
    </form>
  </div>
</template>

<script>
import { ref, watchEffect } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

export default {
  props: {
    post: {
      type: Object,
      default: null
    }
  },
  setup(props) {
    const form = ref({
      content: '',
      tags: ''
    })
    const router = useRouter()

    watchEffect(() => {
      if (props.post) {
        form.value.content = props.post.content
        form.value.tags = props.post.tags
      }
    })

    const submitForm = async () => {
      try {
        if (props.post) {
          // Update existing post
          await axios.put(`/api/posts/${props.post.id}`, form.value, {
            headers: {
              Authorization: `Bearer ${localStorage.getItem('token')}`
            }
          })
        } else {
          // Create new post
          await axios.post('/api/posts', form.value, {
            headers: {
              Authorization: `Bearer ${localStorage.getItem('token')}`
            }
          })
        }
        router.push('/')
      } catch (error) {
        console.error('Error saving post:', error)
      }
    }

    return { form, submitForm }
  }
}
</script>

<style>
form {
  display: flex;
  flex-direction: column;
  gap: 10px;
}
textarea, input {
  padding: 8px;
  font-size: 16px;
}
button {
  padding: 10px;
  font-size: 16px;
}
</style>
