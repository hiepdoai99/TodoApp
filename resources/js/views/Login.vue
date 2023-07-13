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
  <main class="form-signin">
    <form>
      <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

      <div class="form-floating">
        <input v-model="formState.email" type="email" class="form-control" name="email" placeholder="name@example.com">
        <label>Email</label>
      </div>

      <div class="form-floating">
        <input v-model="formState.password" type="password" class="form-control" name="password" placeholder="Password">
        <label>Password</label>
      </div>

      <button class="w-100 btn btn-lg btn-primary" @click="handleLogin" type="button">Submit</button>
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



