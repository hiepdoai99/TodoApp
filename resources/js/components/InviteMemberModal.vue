<script setup>
import {$axios} from '../utils/request'
import {useRouter} from 'vue-router'
import BaseModal from '../components/BaseModal.vue'
import {onMounted, ref, reactive} from "vue";
const router = useRouter()

const emailRes = ref([])
const teams = ref([])
const modalActive = ref(null);

let teamsArrayFormData = ref([])

let emailArrayFormData = ref([])
let emailArrayFormDataFiltered = ref([])

onMounted(() => {
    getTeams()
		getEmails()
})

const toggleModal = () => {
  modalActive.value = !modalActive.value;

};

const getTeams = () => {
    $axios.get('/get-team').then((data) => {
        teams.value = data.data
				
				teamsArrayFormData = JSON.parse(JSON.stringify(teams.value))
				
    })
}

const getEmails = () => {
    $axios.get('/user?filter[email]=').then((data) => {
				emailRes.value = data.data.data
				emailArrayFormData = JSON.parse(JSON.stringify(emailRes.value))
				emailArrayFormDataFiltered = emailArrayFormData.map((e)=>{
					return {
						id: e.id,
						email: e.email
					}
				})
				
    })
}

const formState = reactive({
		id: '',
		team_id:'',
		email:'',
})


const sendInvitation = async () => {
		// later when send team id it should be team_id NOT teamID or any other shit
    if (formState.team_id !== '' && formState.id !== '') {
        $axios.post('/invite', {
					team_id: formState.team_id,
					id: formState.id,
				}).then(
            (data) => {
                router.push('/team')
            }
        )
    } else if(formState.email !== '') {
			$axios.post('/invite', {
					team_id: formState.team_id,
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
						v-model="formState.team_id"
						label="Teams"
						item-title="name"
						item-value="id"
						:items="teamsArrayFormData"
					></v-autocomplete>
				</div>

				<div class="autocomplete-item">
					<v-autocomplete
						v-model="formState.id"
						label="emails"
						item-title="email"
						item-value="id"
						:items="emailArrayFormDataFiltered"
					></v-autocomplete>
				</div>

				<div class="autocomplete-item">
					<v-text-field v-model="formState.email" clearable label="New mail" variant="underlined"></v-text-field>
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
