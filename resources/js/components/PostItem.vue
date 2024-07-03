<template>
    <div class="post-item">
      <h3>{{ post.content }}</h3>
      <p><strong>Tags:</strong> {{ post.tags }}</p>
      <p><strong>Publié par:</strong> {{ post.user.pseudo }}</p>
      <p><strong>Le :</strong> {{ new Date(post.created_at).toLocaleDateString() }}</p>
    </div>
  </template>

  <script>
  export default {
    props: {
      post: {
        type: Object,
        required: true
      }
    }
  }
  </script>

  <style scoped>
  .post-item {
    border: 1px solid #ddd;
    padding: 16px;
    margin-bottom: 16px;
    border-radius: 8px;
    background-color: #fff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s, box-shadow 0.2s;
  }

  .post-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  }

  h3 {
    margin-bottom: 8px;
    font-size: 1.5em;
    color: #333;
  }

  p {
    margin: 4px 0;
    color: #666;
  }

  p strong {
    color: #333;
  }
  </style>
