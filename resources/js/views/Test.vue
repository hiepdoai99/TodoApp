<script setup>
import {$axios} from '../utils/request'
import {onMounted,ref} from "vue";
const teams = ref([])

onMounted(() => {
    $axios.get('/get-team')
        .then(
        (data) => {
            teams.value = data.data
            
        })
})

</script>
<template>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
        </tr>
        </thead>

        <tbody>
        <tr v-for="team in teams" :key="team.id">
            <td data-cell="id">{{ team.id }}</td>
            <td data-cell="name">{{ team.name }}</td>
        </tr>
        </tbody>
    </table>
</template>


<style scoped>

</style>
