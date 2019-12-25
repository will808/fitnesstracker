import Vue from 'vue'
import Router from 'vue-router'
 import Home from '../components/Home'
import Journal from '../components/Journal'
import Profile from '../components/Profile'
import AddFood from '../components/Food/AddFood'
import AddActivity from '../components/Activity/AddActivity'
import SignIn from '../components/Authentication/SignIn'
import Register from '../components/Authentication/Register'
import SignOut from '../components/Authentication/SignOut'

Vue.use(Router)

export default new Router({
  routes: [
   
  {
      path: '/',
      name: 'home',
      component: Home,
      meta: {
        requiresAuth: true,
      }
  
    }, 
    {
      path: '/journal',
      name: 'Journal',
      component: Journal,
      meta: {
        requiresAuth: true,
      }
       
    },
    {
      path: '/profile',
      name: 'Profile',
      component: Profile,
      meta: {
        requiresAuth: true,
      }
        
    },
    {
      path: '/addFood/',
      name: 'AddFood',
      component: AddFood ,
      meta: {
        requiresAuth: true,
      }
      
    },
    {
      path: '/addActivity/',
      name: 'AddActivity',
      component: AddActivity,
      meta: {
        requiresAuth: true,
      }
       
    },
    ,
    {
      path: '/signin/',
      name: 'SignIn',
      component: SignIn,
      meta: {
        requiresVisitor: true,
      }     
    }
    ,
    {
      path: '/register/',
      name: 'Register',
      component: Register,
      meta: {
        requiresVisitor: true,
      }     
    },
    {
      path: '/signout/',
      name: 'SignOut',
      component: SignOut     
    }
  ]
})
