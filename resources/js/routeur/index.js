import { createRouter, createWebHistory } from 'vue-router'
import Login from '../components/Login.vue'
import Register from '../components/Register.vue'
import UserProfile from '../components/UserProfile.vue'
import PostForm from '../components/PostForm.vue'
import Home from '../components/Home.vue'
import PostDetail from '../components/PostDetail.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/', name: 'Home', component: Home },
    { path: '/login', name: 'Login', component: Login },
    { path: '/register', name: 'Register', component: Register },
    { path: '/profile', name: 'UserProfile', component: UserProfile, meta: { requiresAuth: true } },
    { path: '/posts/:id', name: 'PostDetail', component: PostDetail, props: true },
    { path: '/create-post', name: 'CreatePost', component: PostForm, meta: { requiresAuth: true } }
  ]
})

export default router



