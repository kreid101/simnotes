<template>
    <div class="app">
        <div class="add-tip" v-if="addtip">
            <div class="add-whole-block">
                <div class="add-block">
                    <b-form-textarea class="tips-textarea" rows="10" type="text" v-model="newTip.tip">  </b-form-textarea>
                    <button class="con-button" @click="addtip=false" ><font-awesome-icon :icon="['fas','times']" style="color: black; font-size: 22" /></button>
                </div>
                <b-button variant="success" @click="createTip" style="    justify-self: center;
    margin-top: 10px;">Добавить</b-button>
            </div>
        </div>
        <div class="add-tip-btn">
            <div class="add-btn-block">
                <b-button @click="addtip=true" variant="success">Добавить</b-button>
            </div>
            <div class="sign-out-block">
                <button class="sign-out-btn con-button" @click="logout"><font-awesome-icon style="font-size: 25" :icon="['fas','sign-out-alt']" />выйти</button>
            </div>
        </div>
        <div class="Tips" >
            <div v-for="(tip,index) in Tips" v-bind:key="tip.id" >
                <b-form-textarea
                    class="tips-textarea"
                    :id="index+1+'tip'"
                    rows="8"
                    readonly
                    :value="tip.tips"
                >
                </b-form-textarea>
                <button :id="index+ 'edit-btn'" @click="makeEditable(index)" class="con-button"><font-awesome-icon :icon="['fas','pencil-alt']" style="" /></button>
                <button :id="index+ 'canc-btn'" class="hid-btn con-button" @click="cancEditable(index)" ><font-awesome-icon :icon="['fas','times']" style="color: red" /></button>
                <button @click="changeTip(tip.id,index)" :id="index+'-upd-btn'" disabled class="con-button"><font-awesome-icon :icon="['fas','check']"  style="color: green" /></button>
                <button @click="deleteTips(tip.id,index)" class="con-button"> <font-awesome-icon :icon="['fas','trash']" /></button>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    const http = axios.create({
        withCredentials: true
    })
    export default {
        name: 'mainComponent',
        data: function () {
            return {
                addtip: false,
                Tips: [],
                newTip: {
                    tip: ''
                },
                btn: {
                    edit: true,
                    cancel: false
                },
                selected: null,
                style: null,
                options: [
                    { value: 0, text: 'приоритет низкий' },
                    { value: 1, text: 'приоритет средний' },
                    { value: 2, text: 'приоритет высокий' }
                ]
            }
        },
        created: function () {
            this.getuserdata()
        },
        methods: {
            getuserdata () {
                http.get('/api/user', { withCredentials: true }).then(res => {
                    this.Tips = res.data[0]
                })
            },
            deleteTips (id, index) {
                const con = confirm('Хотите удалить эту заметку?')
                if (con) {
                    http.delete('/api/destroy/' + id).then(res => {
                        this.Tips.splice(index, 1)
                    })
                }
            },
            createTip () {
                http.post('/api/create', this.newTip).then(res => {
                    this.getuserdata()
                    this.newTip.tip = ''
                    this.addtip = false
                })
            },
            changeTip (id, index) {
                http.put('/api/change/' + id, { tip: document.getElementById(index + 1 + 'tip').value }).then(res => {
                    this.Tips[index].tips = document.getElementById(index + 1 + 'tip').value
                    this.cancEditable(index)
                })
            },
            logout () {
                http.post('/logout').then(res => {
                    this.$router.push({ name: 'login' })
                })
            },
            makeEditable (id) {
                document.getElementById(id + 1 + 'tip').removeAttribute('readonly')
                document.getElementById(id + '-upd-btn').removeAttribute('disabled')
                document.getElementById(id + 'canc-btn').classList.remove('hid-btn')
                document.getElementById(id + 'edit-btn').classList.add('hid-btn')
            },
            cancEditable (index) {
                document.getElementById(index + 1 + 'tip').setAttribute('readonly', 'readonly')
                document.getElementById(index + '-upd-btn').setAttribute('disabled', 'disabled')
                document.getElementById(index + 'canc-btn').classList.add('hid-btn')
                document.getElementById(index + 'edit-btn').classList.remove('hid-btn')
                document.getElementById(index + 1 + 'tip').value = this.Tips[index].tips
            }
        }
    }
</script>

<style scoped>
    .app
    {
        overflow-y: hidden;
    }
    .Tips
    {
        display: grid ;
        grid-template-columns: auto auto auto ;
        width: 100vw;
        grid-gap: 5px;
        padding-left: 20px;
        padding-right: 20px;

    }
    .add-tip
    {
        display: grid;
        justify-content: center;
        align-items: center;
        width: 100vw;
        height: 100vh;
        position: absolute;
        background-color: rgba(0, 0, 0, 0.5);
        grid-template-columns: 40%;
    }
    .add-tip-btn
    {
        margin-bottom: 30px;
        margin-top: 30px;
        display: grid;
        grid-template-columns: 50% 50%;
    }
    .tips-textarea
    {
        resize: none;
    }
    .hid-btn
    {
        display: none;
    }
    .add-btn-block
    {
        justify-self: end;
    }
    .con-button
    {
        background-color: transparent;
        border: none;
    }
    .sign-out-btn
    {
        display: grid;
        justify-items: center;
    }
    .add-block
    {
        display: grid;
        grid-template-columns: 95% 5%;
        align-items: start;
    }
    .add-whole-block
    {
        display: grid;
    }
    .sign-out-block
    {
        justify-self: end;
        padding-left: 50px;
    }
    @media screen and (max-width: 960px) {
        .Tips {
            grid-template-columns: auto auto;
        }
    }
    @media screen and (max-width: 600px) {
        .Tips {
            grid-template-columns: auto;
        }
    }
</style>
