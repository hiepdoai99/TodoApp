<script setup>
import {$axios} from '../utils/request'
import { useRouter, useRoute } from 'vue-router'
        const router = useRouter()
        const route = useRoute()
import {
  ref,reactive
} from "vue";
const formState = reactive({
  email:'',
  password:''
})

const handleLogin = ()=> {
  $axios.post('login',{
    email:formState.email,
    password:formState.password}).then(
      (data) => {
        localStorage.setItem('token',data.data.access_token)
          router.push('/')
          console.log('dang nhap thanh cong')
      }
  )
}
</script>

<template>
  <main class="form-register">
    <h1 class="form-header">Please log in</h1>
    <form class="form-container">
      <div class="form-item">
        <label>Email</label>
        <input v-model="formState.email" type="email" class="form-control" name="email" placeholder="name@example.com">
      </div>

      <div class="form-item">
        <label>Password</label>
        <input v-model="formState.password" type="password" class="form-control" name="password" placeholder="Password">
      </div>

      <div class="form-item">
        <button class="btn-main" @click="handleLogin" type="button">Submit</button>
      </div>

    </form>
  </main>
</template>

<style>
.form-signin {
  width: 100%;
  max-width: 330px;
  padding: 15px;
  margin: auto;
}

.form-signin .checkbox {
  font-weight: 400;
}

.form-signin .form-floating:focus-within {
  z-index: 2;
}

.form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}

.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
</style>



