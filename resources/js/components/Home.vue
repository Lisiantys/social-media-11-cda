<template>
    <div>
      <h1>Les posts</h1>
      <div v-for="post in posts" :key="post.id" @click="goToPostDetail(post.id)">
        <PostItem :post="post" />
      </div>
      <Pagination
        :currentPage="currentPage"
        :totalPages="totalPages"
        @page-changed="fetchPosts"
      />
    </div>
  </template>

  <script>
  import { ref, onMounted } from 'vue'
  import axios from 'axios'
  import PostItem from './PostItem.vue'
  import Pagination from './Pagination.vue'
  import { useRouter } from 'vue-router'

  export default {
    components: {
      PostItem,
      Pagination
    },
    setup() {
      const posts = ref([])
      const currentPage = ref(1)
      const totalPages = ref(1)
      const router = useRouter()

      const fetchPosts = async (page = 1) => {
        try {
          const response = await axios.get(`/api/posts?page=${page}`)
          posts.value = response.data.data
          currentPage.value = response.data.current_page
          totalPages.value = response.data.last_page
        } catch (error) {
          console.log('Error fetching posts:', error)
        }
      }

      const goToPostDetail = (postId) => {
        router.push(`/posts/${postId}`)
      }

      onMounted(() => {
        fetchPosts()
      })

      return { posts, currentPage, totalPages, fetchPosts, goToPostDetail }
    }
  }
  </script>

  <style scoped>
  h1 {
    margin-bottom: 20px;
  }

  div {
    cursor: pointer;
  }
  </style>
