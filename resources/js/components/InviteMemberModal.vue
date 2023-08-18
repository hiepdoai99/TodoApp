<script setup>
import {$axios} from '../utils/request'
import {useRouter, useRoute} from 'vue-router'
import BaseModal from '../components/BaseModal.vue'
import {onMounted, ref, reactive} from "vue";
const router = useRouter()
const route = useRoute()
const users = ref([])
const modalActive = ref(null);
let usersArrayFormData = ref([])
let usersNameOnly = []
onMounted(() => {
    getNoTeamMember()
})

const toggleModal = () => {
  modalActive.value = !modalActive.value;

};

const getNoTeamMember = () => {
	//get-team
    $axios.get('/noTeam').then((data) => {
        users.value = data.data.data
				usersArrayFormData = JSON.parse(JSON.stringify(users.value))
				usersNameOnly = usersArrayFormData.map(e =>{
					return {
						name: e.name,
						id: e.id,
						email: e.email
					}
				})
				console.log(users.value)
				console.log('filtered value',usersArrayFormData)
				console.log('user by name only ',usersNameOnly)
    })
}

const formState = reactive({
		id: '',
		name:'',
		email:'',
})


const sendInvitation = async () => {
		// later when send team id it should be team_id NOT teamID or any other shit
    if (formState.id !== '') {
        $axios.post('/invite', {
					id: formState.id,
				}).then(
            (data) => {
                router.push('/team')
            }
        )
    } else if(formState.email !== '') {
			$axios.post('/invite', {
					email: formState.email
				}).then(
            (data) => {
                router.push('/team')
            }
        )
		} else {
			toggleModal()
		}
}

</script>

<template>
    <div class="form-register">
			<h3 class="form-header"> Invite new member</h3>
				<form class="form-container" enctype="multipart/form-data">

				<div class="autocomplete-item">
					<v-autocomplete
						v-model="formState.id"
						label="Members"
						item-title="name"
						item-value="id"
						:items="usersNameOnly"
					></v-autocomplete>
				</div>

					<div class="form-item">
							<button  @click="sendInvitation()" class="btn-main" type="button">Send</button>
					</div>
				</form>
    </div>

		<BaseModal
			:modalActive="modalActive"
			@close-modal="toggleModal"
		>		
			There nothing to send
		</BaseModal>
		
</template>


<style scoped>
/* Most style are from register.vue  */

.autocomplete-item{
    width: 100%;
    display: flex;
    margin-bottom: 10px;
    color: white;
    justify-content: center;

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
