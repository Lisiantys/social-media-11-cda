<template>
    <div class="comments-section">
      <h3>Commentaires</h3>
      <div v-for="comment in localComments" :key="comment.id" class="comment">
        <p><strong>{{ comment.user.pseudo }}</strong> : {{ comment.content }}</p>
        <div v-if="isAuthenticated && comment.user.id === userId">
          <button @click="editComment(comment)">Modifier</button>
          <button @click="deleteComment(comment.id)">Supprimer</button>
        </div>
      </div>
      <form v-if="isEditing" @submit.prevent="submitEdit">
        <textarea v-model="editContent" placeholder="Modifier votre commentaire" required></textarea>
        <button type="submit">Mettre à jour</button>
      </form>
    </div>
  </template>

  <script>
  import { ref, watchEffect } from 'vue';
  import axios from 'axios';
  import { useAuthStore } from '@/store/auth';

  export default {
    props: {
      comments: {
        type: Array,
        required: true
      }
    },
    setup(props) {
      const authStore = useAuthStore();
      const isAuthenticated = authStore.isAuthenticated;
      const userId = authStore.user ? authStore.user.id : null;
      const isEditing = ref(false);
      const editContent = ref('');
      const commentToEdit = ref(null);
      const localComments = ref([]);

      watchEffect(() => {
        localComments.value = [...props.comments];
      });

      const editComment = (comment) => {
        isEditing.value = true;
        editContent.value = comment.content;
        commentToEdit.value = comment;
      };

      const submitEdit = async () => {
        try {
          await axios.put(`/api/comments/${commentToEdit.value.id}`, {
            content: editContent.value,
          }, {
            headers: {
              Authorization: `Bearer ${localStorage.getItem('token')}`
            }
          });
          isEditing.value = false;
          const index = localComments.value.findIndex(c => c.id === commentToEdit.value.id);
          localComments.value[index].content = editContent.value;
          commentToEdit.value = null;
          editContent.value = '';
        } catch (error) {
          console.error('Error updating comment:', error);
        }
      };

      const deleteComment = async (commentId) => {
        try {
          await axios.delete(`/api/comments/${commentId}`, {
            headers: {
              Authorization: `Bearer ${localStorage.getItem('token')}`
            }
          });
          // Remove the deleted comment from the local list
          localComments.value = localComments.value.filter(c => c.id !== commentId);
        } catch (error) {
          console.error('Error deleting comment:', error);
        }
      };

      return {
        isAuthenticated,
        userId,
        isEditing,
        editContent,
        editComment,
        submitEdit,
        deleteComment,
        localComments
      };
    }
  };
  </script>

  <style scoped>
  .comments-section {
    margin-top: 20px;
  }

  .comment {
    padding: 10px;
    border-bottom: 1px solid #ddd;
  }

  .comment p {
    margin: 0;
  }

  button {
    padding: 5px 10px;
    font-size: 14px;
    color: white;
    background-color: #007BFF;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    transition: background-color 0.3s;
    margin-right: 5px;
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
