<script setup>
import {$axios} from '../utils/request'
import { useRouter, useRoute } from 'vue-router'
const router = useRouter()
const route = useRoute()

import {
  ref,reactive
} from "vue";
const formState = reactive({
  name:'',
  email:'',
  password:''
})

const handleRegister = ()=> {
  $axios.post('register',{
    email:formState.email,
    password:formState.password,
    name:formState.name})
      .then(
      (data) => {
          router.push('/')
      }
  )
}
</script>

  <template>
    <main class="form-signin">
      <form>
        <h1 class="h3 mb-3 fw-normal">Please register</h1>

        <div class="form-floating">
          <input v-model="formState.name" class="form-control" name="name" placeholder="Name">
          <label>Name</label>
        </div>

        <div class="form-floating">
          <input v-model="formState.email" type="email" class="form-control" name="email" placeholder="name@example.com">
          <label>Email address</label>
        </div>

        <div class="form-floating">
          <input v-model="formState.password" type="password" class="form-control" name="password" placeholder="Password">
          <label>Password</label>
        </div>

        <button class="w-100 btn btn-lg btn-primary" @click="handleRegister" type="button">Submit</button>
      </form>
    </main>
  </template>


<style scoped>

</style>
