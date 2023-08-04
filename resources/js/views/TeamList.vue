<script setup>

import {$axios} from '../utils/request'
import {useRouter, useRoute} from 'vue-router'

const router = useRouter()
const route = useRoute()
import {
    onMounted,
    ref, watch
} from "vue";
const teams = ref([])

onMounted(() => {
    getData()
})

const getData = () => {
    $axios.get('/team').then((data) => {
        teams.value = data.data.data
    })
}
const deleteobj = (teamId) => {
    $axios.delete('/team/' + teamId).then(res => {
        getData()
    })
}

</script>

<template>
    <body>
    <main>
        <section class="table-header">
            <h1 class="form-header">Team manager</h1>
            <div class="table-search-and-add-box">

                <button class="addteam-btn">
                    <a href="/add-team">Add Team</a>
                </button>
            </div>
        </section>

        <section class="table-body">
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
                </thead>

                <tbody>
                <tr v-for="team in teams" :key="team.id">
                    <td>{{ team.id }}</td>
                    <td>{{ team.name }}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <router-link :to="{name: 'details', params: { id: team.id }}" class="btn btn-primary">Show
                            </router-link>
                        </div>
                        <div class="btn-group" role="group">
                            <button @click="deleteobj(team.id)" class="btn btn-danger">Delete</button>
                        </div>
                        <div class="btn-group" role="group">
                            <router-link :to="{name: 'edit-team', params: { id: team.id }}" class="btn btn-primary">Edit
                            </router-link>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </section>
    </main>
    </body>
</template>


<style scoped>

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: sans-serif;
}

main {
    margin-top: 5%;
    min-width: 500px;
    background-color: #75C2F6;
    border-radius: 0px 0px 15px 15px;
}

body {
    /* min-height: 80vh; */
    display: flex;
    justify-content: center;
    align-items: center;
}


.table-header {
    width: 100%;
    height: 10%;
    justify-content: space-between;
    text-align: center;
}

.input-group {
    width: 100%;
    height: 100%;
    background-color: #fff5;
    padding: 0.5rem 1rem;
    border-radius: 2rem;

    display: flex;
    justify-content: center;
    align-items: center;

    transition: .2s;
}

.task-setting {
    width: 10vh;
}

.task-setting span {
    margin-right: 5px;
    cursor: pointer;
}

.table-search-and-add-box {
    padding: 20px;
}

.view-btn {
    color: green;
}

.edit-btn {
    color: #ebc474;
}

.delete-btn {
    color: red;
}

.addteam-btn {
    background-color: #1D5D9B;
    padding: 10px 0px 10px 0px;
    margin-top: 1%;
    height: 100%;
    width: 25%;
    border-radius: 20px;
    border: none;
    color: white;
    text-align: center;
}

.addteam-btn a {
    color: white;
    text-decoration: none;
}

.table-header .input-group:hover {
    background-color: #FDFDC9;
    box-shadow: 0 .1rem .4rem #0002;
}

.table-header .input-group input {
    width: 100%;
    padding: 0 .5rem 0 .3rem;
    background-color: transparent;
    border: none;
    outline: none;
}

.table-body {
    width: 95%;
    max-height: calc(89% - 1.6rem);
    background-color: #fffb;

    margin: .8rem auto;
    border-radius: .6rem;

    overflow: auto;
    overflow: overlay;
}

.table-body::-webkit-scrollbar {
    width: 0.5rem;
    height: 0.5rem;
}

.table-body::-webkit-scrollbar-thumb {
    border-radius: .5rem;
    background-color: #0004;
    visibility: hidden;
}

.table-body:hover::-webkit-scrollbar-thumb {
    visibility: visible;
}

table {
    width: 100%;
}

table, th, td {
    border-collapse: collapse;
    padding: 1rem;
    text-align: left;
}

thead th {
    position: sticky;
    top: 0;
    left: 0;
    background-color: #1D5D9B;
    color: white;
    cursor: pointer;
    text-transform: capitalize;
}

tbody tr:hover {
    background-color: #fff6 !important;
}

tbody tr td,
tbody tr td p {
    transition: .2s ease-in-out;
}

.status {
    padding: .4rem 0.8rem;
    border-radius: 2rem;
    text-align: center;
}

.status.delivered {
    background-color: #86e49d;
    color: white;
}

.status.cancelled {
    background-color: #d893a3;
    color: white;
}

.status.pending {
    background-color: #ebc474;
    color: white;
}

.status.shipped {
    background-color: #6fcaea;
    color: white;
}

@media (max-width: 1000px) {
    /* td:not(:first-of-type) {
        min-width: 12.1rem;
    } */
}

thead th:hover {
    color: #FDFDC9;
}


</style>
