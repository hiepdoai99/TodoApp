<script setup>
import {$axios} from '../utils/request'
import { useRouter, useRoute } from 'vue-router'
const router = useRouter()
const route = useRoute()
import {
    onMounted,
    ref,reactive
} from "vue";
const users = ref([])
const status = ref([])

onMounted(()=>{
    getUser()
    getStatus()
})
const getUser = () => {
    $axios.get('/user').then((data)=>{
        console.log(data.data.data)
        users.value = data.data.data
    })
}
const getStatus = () => {
    $axios.get('/status').then((data)=>{
        status.value = data.data.data
    })
}
const formState = reactive({
    name:'',
    description:'',
    status_id:'',
    user_id:'',
    start_date:'',
    end_date:''
})
const addTodo = ()=> {
    $axios.post('/todo',{
        name:formState.name,
        description:formState.description,
        status_id:formState.status_id,
        user_id:formState.user_id,
        start_date:formState.start_date,
        end_date:formState.end_date}).then(
        (data) => {
            router.push('/todo')
            console.log(' thanh cong')
        }
    )
}

</script>

<template>
    <div class="container ">
        <h3> Add Todo</h3>
        <form>
            <label for="exampleFormControlInput1" class="form-label">Name</label>
            <input v-model="formState.name" class="form-control form-control-lg" type="text"  aria-label=".form-control-lg example">

            <label for="exampleFormControlInput1" class="form-label">Description</label>
            <textarea v-model="formState.description" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>

            <label for="exampleFormControlInput1" class="form-label">User</label>
            <select class="form-select" v-model="formState.user_id">
                <option v-for="user in users" :key="user.value" :value="user.id">
                    {{ user.name }}
                </option>
            </select>

            <label for="exampleFormControlInput1" class="form-label mt-3">Status</label>
            <select class="form-select" v-model="formState.status_id">
                <option v-for="stt in status" :key="stt.value" :value="stt.id">
                    {{ stt.name }}
                </option>
            </select>
            <br>

            <label for="exampleFormControlInput1" class="form-label m-lg-3 ">Start date</label>
            <input type = "date" name = "date" v-model="formState.start_date">

            <label for="exampleFormControlInput1" class="form-label m-lg-3 ">End date</label>
            <input type = "date" name = "date" v-model="formState.end_date">

            <button @click="addTodo" class="w-100 btn btn-lg btn-primary mt-5" type="button">Submit</button>

        </form>

    </div>
</template>



<style scoped>

</style>
