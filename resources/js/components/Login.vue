<template>
    <div class="app">
        <div class="switcher">
            <h4 @click="login=true,register=false, switcherlog()" class="switch-btn" v-bind:class="{active: logActive }">Вход</h4>
            <h4 @click="login=false,register=true, switcherreg()" class="switch-btn" v-bind:class="{active: regActive }">Регистрация</h4>
        </div>
        <div class="login-form" v-if="login" >
            <h6 v-if="logErrors">
                <div v-for="(error,index) in logErrors" v-bind:key="index">
                    <b-alert variant="danger" show >{{error[0]}}</b-alert>
                </div>
            </h6>
            <form @submit="getuser" style="display: grid">
                <b-form-input class="mb-4" v-model="formData.email" placeholder="Email" required></b-form-input>
                <b-form-input class="mb-4" v-model="formData.password" type="password" placeholder="Пароль" required></b-form-input>
                <b-button variant="success" type="submit" style="justify-self: center">Вход</b-button>
            </form>
        </div>
        <div class="register-form" v-if="register">
            <h6 v-if="regErrors">
                <div v-for="(error,index) in regErrors" v-bind:key="index">
                    <b-alert variant="danger" show >{{error[0]}}</b-alert>
                </div>
            </h6>
            <form @submit="registerUser" style="display: grid">
                <b-form-input class="mb-4" type="text" v-model="registerForm.name" placeholder="логин" required></b-form-input>
                <b-form-input class="mb-4" type="email" v-model="registerForm.email" placeholder="email" required></b-form-input>
                <b-form-input class="mb-4" type="password" v-model="registerForm.password" placeholder="пароль" required></b-form-input>
                <b-form-input class="mb-4" type="password" v-model="registerForm.password_confirmation" placeholder="подтвердите пароль" required></b-form-input>
                <b-button variant="success" type="submit" style="justify-self: center">Регистрация</b-button>
            </form>

        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    const http = axios.create({
        withCredentials: true
    })

    export default {
        name: 'Login',
        data: function () {
            return {
                formData: {
                    email: '',
                    password: ''
                },
                registerForm: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                },
                error: '',
                register: false,
                login: true,
                logActive: true,
                regActive: false,
                logErrors: [],
                regErrors: []
            }
        },
        methods: {
            getuser () {
                http.get('/sanctum/csrf-cookie').then(response => {
                    console.log(response)
                    http.post('/login', this.formData).then(res => {
                        this.$router.push({ name: 'mainComponent' })
                    }).catch(err => {
                        this.logErrors = err.response.data.errors
                    })
                })
            },
            registerUser () {
                    http.post('/register', this.registerForm).then(res => {
                        this.$router.push({ name: 'mainComponent' })
                    }).catch(err => {
                        this.regErrors = err.response.data.errors
                    })
            },
            switcherlog () {
                if (this.logActive !== true) {
                    this.logActive = !this.logActive
                    this.regActive = !this.regActive
                }
            },
            switcherreg () {
                if (this.regActive !== true) {
                    this.logActive = !this.logActive
                    this.regActive = !this.regActive
                }
            }
        }
    }
</script>

<style scoped>
    .login-form
    {
        justify-content: center;
        display: grid;
        justify-items: center;
        align-items: center;
        align-self: start;
    }
    .active
    {
        border-bottom: 4px solid #1e7e34;
    }
    .switcher
    {
        align-self: end;
        display: grid;
        grid-template-columns: auto auto;
        grid-gap: 15px;
    }
    .switch-btn
    {
        cursor: pointer;
    }
    .switcher-active
    {
        border-bottom: 4px solid green;
    }
    .register-form
    {
        justify-content: center;
        display: grid;
        justify-items: center;
        align-items: center;
        align-self: start;
    }
    .app
    {
        display: grid;
        grid-template-rows: 30% 70%;
        justify-content: center;
        height: 100vh;
        grid-row-gap: 20px;
    }
</style>
