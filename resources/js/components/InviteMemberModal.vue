<script setup>
import {$axios} from '../utils/request'
import {useRouter, useRoute} from 'vue-router'
import userVuelidate from '@vuelidate/core'
import {required} from '@vuelidate/validators'

const router = useRouter()
const route = useRoute()
import {onMounted, ref, reactive} from "vue";
const users = ref([])


onMounted(() => {
    getNoTeamMember()
})

const getNoTeamMember = () => {
    $axios.get('/noTeam').then((data) => {
        users.value = data.data.data
				console.log(users.value)
    })
}

const formState = reactive({
		id: '',
})

const rules = {
		id: {required},
}

const v$ = userVuelidate(rules, formState)

const sendInvitation = async () => {
    //validate first
    const validateRes = await v$.value.$validate();
    if (validateRes) {
        $axios.post('/invite', {id: formState.id}).then(
            (data) => {
                router.push('/team')
            }
        )
    }
}

</script>

<template>
    <div class="form-register">
			<h3 class="form-header"> Invite new member</h3>
				<form class="form-container" enctype="multipart/form-data">
					<div class="form-item">
							<label for="exampleFormControlInput1">Member</label>
							<select class="form-select " v-model="formState.id" >
									<option v-for="assigner in users" :key="assigner.id" :value="assigner.id">
										{{ assigner.name }}
									</option>
							</select>
					</div>


					<div class="errtext" v-for="error in v$.id.$errors" :key="error.$uid">
							{{ error.$message }}
					</div>

					<div class="form-item">
							<button  @click="sendInvitation()" class="btn-main" type="button">Send</button>
					</div>
				</form>
    </div>
</template>


<style scoped>
/* Most style are from register.vue  */
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

input[type='file'] {
    display: none;
}
.form-container {
    width: 100%;
    background-color: #75C2F6;
    padding: 10px 25px 5px 25px;
    box-shadow: none;
    border-radius: 0px 0px 15px 15px;
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

</style>
