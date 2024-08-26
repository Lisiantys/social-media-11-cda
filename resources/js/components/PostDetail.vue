<template>
  
    <div v-if="post" class="post-details">
      <button @click="goBack">Retour</button>
      <div class="post-header">
        <img v-if="post.image" :src="`/storage/${post.image}`" alt="Post Image" class="post-image" />
        <div class="post-meta">
          <p><strong>Tags:</strong> {{ post.tags }}</p>
          <p><strong>Posted by:</strong> {{ post.user.pseudo }}</p>
          <p><strong>Posted on:</strong> {{ new Date(post.created_at).toLocaleDateString() }}</p>
        </div>
        <p>{{ post.content }}</p>
      </div>
      <div class="post-actions">
        <button v-if="isAuthenticated" @click="editPost">Modifier</button>
        <button v-if="isAuthenticated" @click="deletePost">Supprimer</button>
      </div>
      <PostForm v-if="isEditing" :post="post" @postUpdated="fetchPost" />
      <CommentList :comments="post.comments" />
      <button v-if="isAuthenticated" @click="showCommentForm = !showCommentForm">Créer un commentaire</button>
      <form v-if="showCommentForm" @submit.prevent="submitComment">
        <textarea v-model="newComment.content" placeholder="Votre commentaire" required></textarea>
        <button type="submit">Envoyer</button>
      </form>
    </div>
  </template>

  <script>
  import { ref, onMounted } from 'vue';
  import { useRoute, useRouter } from 'vue-router';
  import axios from 'axios';
  import PostForm from './PostForm.vue';
  import CommentList from './CommentList.vue';
  import { useAuthStore } from '@/store/auth';

  export default {
    components: {
      PostForm,
      CommentList
    },
    setup() {
      const post = ref(null);
      const isEditing = ref(false);
      const route = useRoute();
      const router = useRouter();
      const authStore = useAuthStore();
      const showCommentForm = ref(false);
      const newComment = ref({
        content: ''
      });

      const fetchPost = async () => {
        try {
          const response = await axios.get(`/api/posts/${route.params.id}`);
          post.value = response.data.post;
        } catch (error) {
          console.error('Error fetching post:', error);
        }
      };

      const goBack = () => {
        router.push('/');
      };

      const editPost = () => {
        isEditing.value = true;
      };

      const deletePost = async () => {
        try {
          await axios.delete(`/api/posts/${route.params.id}`, {
            headers: {
              Authorization: `Bearer ${localStorage.getItem('token')}`
            }
          });
          router.push('/');
        } catch (error) {
          console.error('Error deleting post:', error);
        }
      };

      const submitComment = async () => {
        try {
          await axios.post(`/api/comments`, {
            content: newComment.value.content,
            post_id: post.value.id,
            user_id: authStore.user.id
          }, {
            headers: {
              Authorization: `Bearer ${localStorage.getItem('token')}`
            }
          });
          showCommentForm.value = false;
          newComment.value.content = '';
          fetchPost();
        } catch (error) {
          console.error('Error creating comment:', error);
        }
      };

      onMounted(() => {
        fetchPost();
      });

      return {
        post,
        isEditing,
        fetchPost,
        goBack,
        editPost,
        deletePost,
        showCommentForm,
        newComment,
        submitComment,
        isAuthenticated: authStore.isAuthenticated
      };
    }
  };
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

  .post-image {
    max-width: 100%;
    height: auto;
    margin-bottom: 20px;
    border-radius: 8px;
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

  form {
    margin-top: 20px;
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  textarea {
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
    transition: border-color 0.3s;
  }

  textarea:focus {
    border-color: #007BFF;
    outline: none;
  }

  form button {
    padding: 10px 20px;
    font-size: 16px;
    color: white;
    background-color: #28a745;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
  }

  form button:hover {
    background-color: #218838;
  }

  form button:focus {
    outline: none;
  }

  form button:active {
    background-color: #1e7e34;
  }
  </style>
