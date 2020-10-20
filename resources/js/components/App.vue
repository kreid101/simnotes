<template>
    <div class="app">
        <router-view></router-view>
    </div>

</template>

<script>
    import axios from 'axios'
    const http = axios.create({
        baseURL: 'http://localhost:8000',
        withCredentials: true
    })

    export default {
        name: 'app',
        methods: {
            getuser () {
                http.get('http://localhost:8000/sanctum/csrf-cookie').then(response => {
                    http.post('http://localhost:8000/login', this.formData).then(res => {
                        this.getuserdata()
                    }).catch(err => { this.error = err.response.data.message })
                })
            },
            getuserdata () {
                http.get('http://localhost:8000/api/user', { withCredentials: true }).then(res => {
                    console.log('get data')
                    this.Tips = res.data
                })
            },
            deleteTips (id) {
                http.delete('/api/destroy/' + id).then(res => {
                    console.log(res)
                })
            },
            createTip () {
                http.post('/api/create', this.newtip).then(res => {
                    console.log(res)
                    this.getuserdata()
                    this.newtip.tip = ''
                })
            },
            changeTip (id) {
                const a = this.Tips.find(o => o.id === id)
                console.log(this.Tips.indexOf(a))
                const chtip = {
                    tip: a.tips
                }
                http.put('/api/change/' + id, chtip).then(res => {
                    a.tips = res.data.tip
                    console.log(res)
                })
            },
            logout () {
                http.post('/logout').then(res => {
                    console.log(res)
                })
            }
        }
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
