<script setup>
import {$axios} from '../utils/request'
import { useRouter, useRoute } from 'vue-router'
const router = useRouter()
const route = useRoute()

import {
  ref,reactive
} from "vue";
const formState = reactive({
  first_name:'',
  last_name:'',
  email:'',
  password:'',
    password_confirmation:''
})

const handleRegister = ()=> {
  $axios.post('register',{
      email:formState.email,
      password:formState.password,
      password_confirmation:formState.password_confirmation,
      first_name:formState.first_name,
      last_name:formState.last_name,
  })
      .then(
      (data) => {
          router.push('/')
      }
  )
}
</script>

  <template>
    <main class="form-register">
      <h1 class="form-header">Registration</h1>
      <form class="form-container">
        <div class="form-item">
          <label>First name</label>
          <input v-model="formState.first_name" class="form-control" name="first_name" placeholder="First name">
        </div>

        <div class="form-item">
          <label>Last name</label>
          <!-- <input v-model="formState.name" class="form-control" name="name" placeholder="First name">      -->
          <input v-model="formState.last_name" class="form-control"  name="last_name" placeholder="Last name">
        </div>

        <div class="form-item">
          <label>Email</label>
          <input v-model="formState.email" type="email" class="form-control" name="email" placeholder="Name@example.com">
        </div>

        <div class="form-item">
          <label>Password</label>
          <input v-model="formState.password" type="password" class="form-control" name="password" placeholder="Password">
        </div>

        <div class="form-item">
          <label>Confirm Password</label>
          <!-- <input v-model="formState.password" type="password" class="form-control" name="password" placeholder="Password">    -->
          <input v-model="formState.password_confirmation"  type="password" class="form-control" name="password_confirmation" placeholder="Re-enter Password">
        </div>

        <div class="form-item">
          <button class="btn-main" @click="handleRegister" type="button">Register</button>
        </div>
      </form>
    </main>
  </template>


<style>

  .form-register {
    width: 100%;
    max-width: 600px;
    padding: 0px;
    margin: 10px auto auto auto;
    background-color: #75C2F6;
    border-radius: 0px 0px 15px 15px;
  }
  .form-header{
    background-color: #1D5D9B;
    color: white;
    border-radius: 0px 0px 15px 15px;
    padding: 10px;
    text-align: center;
  }
  .btn-main{
    background-color: #1D5D9B;
    padding: 10px 0px 10px 0px;
    height: 100%;
    width: 30%;
    border-radius: 20px;
    border: none;
    color: white;
    text-align: center;
  }

  .form-item{
    width: 100%;
    display: flex;
    margin-bottom: 10px;
    color: white;
    justify-content: center;

  }
  .form-item label{
    background-color: #1D5D9B;
    width: 30%;
    border-radius: 15px 0px 0px 15px;
    color: white;
    text-align:left;
    padding: 15px;
  }
  .form-item input{
    width: 70%;
    border-radius: 0px 15px 15px 0px;
    background-color: #FDFDC9;
  }
  .form-item .form-floating:focus-within {
    z-index: 2;
  }
  .form-container {
    width: 100%;
    background-color: #75C2F6;
    padding: 10px 25px 5px 25px;
    box-shadow: -30px 30px 20px rgba(0, 0, 0, 0.2);
    border-radius: 0px 0px 15px 15px;
  }


</style>
