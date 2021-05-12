import { createRouter, createWebHistory } from 'vue-router'
import Home from '../components/ImageSlider/ImageSlider'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/character/:id',
    name: 'Character',
    component: () => import('../components/Character/Character.vue')
  },
  {
    path: '/characters',
    name: 'Characters',
    component: () => import('../components/Characters/Characters.vue')
  },
  {
    path: '/location/:name',
    name: 'Location',
    component: () => import('../components/Location/Location.vue')
  },
  {
    path: '/episode/:id',
    name: 'Episode',
    component: () => import('../components/Episode/Episode.vue')
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
