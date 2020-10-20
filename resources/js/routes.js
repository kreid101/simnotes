import Vue from 'vue'
import VueRouter from 'vue-router'
import Login from './components/Login'
import MainComponent from './components/mainComponent'
import axios from 'axios'

Vue.use(VueRouter)

export const router = new VueRouter({
    routes: [
        {
            path: '/login',
            name: 'login',
            component: Login
        },
        {
            path: '/',
            name: 'mainComponent',
            component: MainComponent,
            beforeEnter: (to, from, next) => {
                axios.get('http://localhost:8000/api/user').then(res => {
                    if (res.data[1]) {
                        next()
                    }
                }).catch(err => {
                    next({ name: 'login' })
                    console.log(err)
                })
            }
        }

    ]
})
