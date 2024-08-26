<template>
    <div class="pagination">
      <button @click="previousPage" :disabled="currentPage === 1"><</button>
      <span>{{ currentPage }} / {{ totalPages }}</span>
      <button @click="nextPage" :disabled="currentPage === totalPages">></button>
    </div>
  </template>

  <script>
  export default {
    props: {
      currentPage: {
        type: Number,
        required: true
      },
      totalPages: {
        type: Number,
        required: true
      }
    },
    methods: {
      previousPage() {
        this.$emit('page-changed', this.currentPage - 1);
      },
      nextPage() {
        this.$emit('page-changed', this.currentPage + 1);
      }
    }
  }
  </script>

  <style scoped>
  .pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
    margin-top: 20px;
  }

  button {
    padding: 10px;
    border-radius: 100px;
    font-size: 16px;
  }
  </style>
