<template>
    <div class="post-item">
      <h3>{{ post.content }}</h3>
      <p>{{ post.tags }}</p>
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
  }
  </style>
  