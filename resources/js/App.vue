<template>
  <div id="app">
    <nav>
      <router-link to="/">Home</router-link>
      <router-link to="/login">Login</router-link>
      <router-link to="/register">Register</router-link>
      <!-- <router-link to="/profile">Profile</router-link> -->
      <!-- <router-link to="/create-post">Create Post</router-link> -->
      <!-- <router-link  v-if="isAuthenticated" @click="handleLogout">Logout</router-link> -->
    </nav>
    <router-view></router-view>
  </div>
</template>

<script>

export default {

}
</script>

  <style>
  #app {
    max-width: 800px;
    margin: 0 auto;
  }
  
  nav {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
    background-color: #007BFF;
    padding: 10px;
    border-radius: 5px;
  }
  
  nav a{
    color: white;
    text-decoration: none;
    padding: 8px 16px;
    border-radius: 5px;
    transition: background-color 0.3s;
  }
  
  nav a:hover {
    background-color: #0056b3;
  }
  
  button {
    background-color: #0056b3;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
  }
  
  button:hover {
    background-color: #003f7f;
  }
  
  button:focus {
    outline: none;
  }
  
  button:active {
    background-color: #003f7f;
  }
  </style>