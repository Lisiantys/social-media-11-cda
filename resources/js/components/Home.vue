<template>
    <div>
      <h1>All Posts</h1>
      <div v-for="post in posts" :key="post.id" @click="goToPostDetail(post.id)">
        <PostItem :post="post" />
      </div>
    </div>
  </template>
  
  <script>
  import { ref, onMounted } from 'vue'
  import axios from 'axios'
  import PostItem from './PostItem.vue'
  import { useRouter } from 'vue-router'
  
  export default {
    components: {
      PostItem
    },
    setup() {
      const posts = ref([])
      const router = useRouter()
  
      const fetchPosts = async () => {
        try {
          const response = await axios.get('/api/posts')
          posts.value = response.data.posts
        } catch (error) {
          console.error('Error fetching posts:', error)
        }
      }
  
      const goToPostDetail = (postId) => {
        router.push(`/posts/${postId}`)
      }
  
      onMounted(fetchPosts)
  
      return { posts, goToPostDetail }
    }
  }
  </script>
  
  <style>
  h1 {
    margin-bottom: 20px;
  }
  div {
    cursor: pointer;
  }
  </style>
  