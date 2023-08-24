<template>

</template>

<script setup>
import {$axios} from '../utils/request'
import {useRouter, useRoute} from 'vue-router'
import {onMounted, watch} from "vue";

const router = useRouter()
const route = useRoute()

onMounted(() => {
        const token = localStorage.getItem('token');
        if (token) {
            $axios.post('/logout/')
            localStorage.removeItem('token');
            localStorage.removeItem('user');
            localStorage.removeItem('permissions');
            localStorage.removeItem('loginRole');
            localStorage.removeItem('userTeams');
            router.push('/login')
        }

})

</script>

<style scoped>

</style>
