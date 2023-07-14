<script setup>
import {$axios} from '../utils/request'
import {useRouter, useRoute} from 'vue-router'

const router = useRouter()
const route = useRoute()
import {
    onMounted,
    ref
} from "vue";

const todoList = ref([])

onMounted(() => {
    getData()
})
const getData = () => {
    $axios.get('/todo?include=status,user').then((data) => {
        todoList.value = data.data.data
    })
}
const deleteobj = (todoId) => {
    $axios.delete('/todo/' + todoId).then(res => {
        getData()
    })
}

</script>

<template>
    <div>
        <div>
            <button class="btn btn-danger">
                <router-link to="/add-todo">AddTodo</router-link>
            </button>
        </div>
        <h3 class="text-center">All todos</h3><br/>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Start date</th>
                <th>End date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="todo in todoList" :key="todo.id">
                <td>{{ todo.id }}</td>
                <td>{{ todo.name }}</td>
                <td>{{ todo.description }}</td>
                <td>{{ todo.start_date }}</td>
                <td>{{ todo.end_date }}</td>
                <td>{{ todo.status.name }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <router-link :to="{name: 'details', params: { id: todo.id }}" class="btn btn-primary">Show
                        </router-link>
                    </div>
                    <div class="btn-group" role="group">
                        <button @click="deleteobj(todo.id)" class="btn btn-danger">Delete</button>
                    </div>
                    <div class="btn-group" role="group">
                        <router-link :to="{name: 'edit', params: { id: todo.id }}" class="btn btn-primary">Edit
                        </router-link>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>


