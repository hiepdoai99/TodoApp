<script setup>

import {$axios} from '../utils/request'
// import {useRouter, useRoute} from 'vue-router'
import {ref} from "vue";
//
// const router = useRouter()
// const route = useRoute()
if (localStorage.getItem("user")){
    const info = localStorage.getItem("user")
    const user = ref([])
    user.value = JSON.parse(info)
    console.log(user.value.last_name)
}
</script>


<template>
    <div>
        <nav class="navbar navbar-expand-lg ">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">
                                <router-link to="/">Home</router-link>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <router-link to="/add-todo">Add task</router-link>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <router-link to="/todo">Tasks</router-link>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <router-link to="/team">Team</router-link>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <router-link to="/projects">Project</router-link>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a  class="nav-link" href="#">
                                <router-link to="/login">Login</router-link>
                            </a>
<!--                            <a v-else class="nav-link" href="#">-->
<!--                                <router-link to="/login">Login</router-link>-->
<!--                            </a>-->

                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <router-link to="/register">Register</router-link>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <router-link to="/admin">Admin</router-link>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</template>


<style scoped lang="scss">

.navbar {
    display: flex;
    background-color: #1D5D9B;

    .navbar-nav {
        justify-content: right;
        width: 100%;
    }

    .nav-item {

        .nav-link {
            a {
                color: white !important;
                text-decoration: unset !important;
            }
        }
    }
}
</style>
