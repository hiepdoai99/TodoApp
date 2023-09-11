<script setup>
import {$axios} from '../utils/request'
import {useRouter, useRoute} from 'vue-router'
import userVuelidate from '@vuelidate/core'
import {required} from '@vuelidate/validators'

const router = useRouter()
const route = useRoute()
import {
    onMounted,
    ref, reactive
} from "vue";

const id = route.params.id ?? null;
const allRoles = ref([])
onMounted(() => {
    if (id) {
			getUser(id)
    }
		getAllRoles()
})

const formState = reactive({
    first_name: '',
    last_name: '',
    phone: '',
		user_role: '',
    password: '',

})

const rules = {
	first_name: {required},
	last_name: {required},
	phone: {},
	user_role: {required},
	password: {},
}

const v$ = userVuelidate(rules, formState)

const getUser = (id) => {
    $axios.get(`/user/${id}?include=roles`).then(
        (res) => {
            if (res) {
							
                formState.first_name = res.data.data.first_name;
                formState.last_name = res.data.data.last_name;
                formState.phone = res.data.data.phone;
								formState.user_role = res.data.data.roles[0].name;
                formState.password = res.data.data.password;
            }
        }
    )
}

const getAllRoles = () => {
    $axios.get('/roles').then((data) => {
			allRoles.value = data.data.data
			
    })
}

const edit = async () => {
	const validateRes = await v$.value.$validate();
	if (validateRes) {
		$axios.put('/user/' + id, {
			first_name: formState.first_name,
			last_name: formState.last_name,
			phone: formState.phone,
			password: formState.password,
			roles: formState.user_role
    }).then(
        (data) => {
            router.push('/')
        }
    	)
    }
}

</script>

<template>
    <div class="form-register">
        <h3 class="form-header"> Edit user</h3>
        <form class="form-container" enctype="multipart/form-data">

            <div class="form-item">
                <label>First name</label>
                <input v-model="formState.first_name" class="form-control" type="text" aria-label=".form-control-lg example">

            </div>

            <div class="errtext" v-for="error in v$.first_name.$errors" :key="error.$uid">
                {{ error.$message }}
            </div>

            <div class="form-item">
                <label>Last name</label>
                <input v-model="formState.last_name" class="form-control" type="text" aria-label=".form-control-lg example">
            </div>

            <div class="errtext" v-for="error in v$.last_name.$errors" :key="error.$uid">
                {{ error.$message }}
            </div>

            <div class="form-item">
                <label>phone</label>
                <input v-model="formState.phone" class="form-control" type="text" aria-label=".form-control-lg example">
            </div>

            <div class="errtext" v-for="error in v$.phone.$errors" :key="error.$uid">
                {{ error.$message }}
            </div>

						<div class="form-item">
                <label>Role</label>
                <select class="form-select " v-model="formState.user_role">
                    <option v-for="role in allRoles" :key="role.id" :value="role.name">
													{{ role.name }}
                    </option>
                </select>
            </div>

            <div class="errtext" v-for="error in v$.user_role.$errors" :key="error.$uid">
                {{ error.$message }}
            </div>

            <div class="form-item">
                <label>password</label>
                <input v-model="formState.password" class="form-control" type="text" aria-label=".form-control-lg example">
            </div>

            <div class="errtext" v-for="error in v$.password.$errors" :key="error.$uid">
                {{ error.$message }}
            </div>

            <div class="form-item">
                <button v-if="id" @click="edit" class="btn-main" type="button">Update</button>
            </div>
        </form>


    </div>
</template>


<style scoped>
/* Most style are from register.vue  */

.date-container {
    display: flex;
}

.date-container div:first-child {
    margin-right: 20px;
}

.date-select {
    background-color: #FDFDC9;
    color: black;
    font-size: 18px;
    border: none;
    outline: none;
    border-radius: 5px;
}

.form-item textarea {
    width: 70%;
    border-radius: 0px 15px 15px 0px;
    background-color: #FDFDC9;
}

.form-item select {
    width: 70%;
    border-radius: 0px 15px 15px 0px;
    background-color: #FDFDC9;
}
.form-item select:disabled {
   cursor: not-allowed;
   border: 1px solid #999999;
  background-color: #cccccc;
  color: #666666;
}

input[type='file'] {
    display: none;
}

.upload-form-item {
    width: 100%;
    display: flex;
    margin-bottom: 10px;
    color: white;
    justify-content: center;

}

.uploadLabel {
    display: inline-block;
    text-transform: uppercase;
    color: #fff;
    background-color: #1D5D9B;
    text-align: center;
    padding: 15px 40px;
    font-size: 18px;
    letter-spacing: 1.5px;
    user-select: none;
    cursor: pointer;
    border-radius: 15px;
}

.errtext {
    background-color: #ebeb39;
    border-radius: 15px;
    color: red;
    width: 100%;
    display: flex;
    margin-bottom: 10px;
    justify-content: center;
}


.imagePreview {
    width: 100px;
    height: 100px;
    background-size: cover;
    background-position: center center;
}

@media (max-width: 1000px) {
	.date-container{
    display: block;
  }
  .date-container div:first-child {
    margin-right: 0px;
}

}
</style>
