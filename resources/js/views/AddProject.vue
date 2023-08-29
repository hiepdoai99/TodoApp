<script setup>
import {$axios} from '../utils/request'
import {useRouter, useRoute} from 'vue-router'
import BaseModal from '../components/BaseModal.vue'
import {
    onMounted,
    ref, reactive
} from "vue";
const router = useRouter()
const route = useRoute()

const id = route.params.id ?? null;
const teamList = ref([])
let userlist = ref([])
let teamlistParse = ref([])
const users = ref([])
const modalActive = ref(null)

let userRoleData = ref('')
let userDatas = ref('')

onMounted(() => {
		userRoleData = localStorage.getItem('loginRole');
		userDatas = JSON.parse(localStorage.getItem('user'));
		console.log('role check', userRoleData)
		console.log('data user check', userDatas)
    if (id) {
      getProject(id)
    }
		getTeams()
		getUser()
})

const toggleModal = () => {
  modalActive.value = !modalActive.value;

};

const getUser = () => {
    $axios.get('/user').then((data) => {
        users.value = data.data.data
				if(userRoleData === 'ROOT' || userRoleData === 'ADMIN'){
					userlist = JSON.parse(JSON.stringify(users.value))
				} else if (userRoleData === 'MEMBER'){
					userlist = [{
						id: userDatas.id,
						name: userDatas.first_name + userDatas.last_name
					}]
					console.log('member new data check', userlist)
				}
				
    })
}
const getProject = (id) => {
    $axios.get('/project/' + id).then(
        (res) => {
            if (res) {
                formState.name = res.data.data.name;
            }
        }
    )
}

const getTeams = () => {
    $axios.get('/team?include=projects,created_by_user,users&per_page=3&page=1').then((data) => {
			teamList.value = data.data.data
			teamlistParse = JSON.parse(JSON.stringify(teamList.value))
			console.log('team return in project', teamlistParse)
    })
}
const formState = reactive({
    name: '',
    teams: [],
		user: ''
})

const addProject = async () => {
    //validate first
		const teamDatacheck = JSON.parse(JSON.stringify(formState.teams));
			if(teamDatacheck.length !== 0  && formState.name !== ''){
				$axios.post('/project', {
            name: formState.name,
						teams: formState.teams,
        }).then(
						(data) => {
								router.push('/projects')
						}
				)
			} else if (formState.user !== '' && formState.name !== ''){
				$axios.post('/project', {
            name: formState.name,
						user_id: formState.user
        }).then(
						(data) => {
								router.push('/projects')
						}
				)
			} else{
				toggleModal()
			}
       
}

const edit = () => {
    $axios.put('/project/' + id, {
        name: formState.name,

    }).then(
        (data) => {
            router.push('/projects')
        }
    )
}

</script>

<template>
    <div class="form-register">
        <h3 v-if="id" class="form-header"> Edit Project</h3>
        <h3 v-else class="form-header"> Add Project</h3>
        <form class="form-container" enctype="multipart/form-data">
						<div class="autocomplete-item">
							<v-text-field v-model="formState.name" clearable label="Project name" variant="underlined"></v-text-field>
						</div>

						<div v-if="userRoleData === 'ROOT' || userRoleData === 'ADMIN' " class="autocomplete-item">
							<v-autocomplete
								v-model="formState.teams"
								:items="teamlistParse"
								chips
								closable-chips
								label="Select team"
								item-title="name"
								item-value="id"						
								multiple
							></v-autocomplete>
						</div>

						<div class="autocomplete-item">
							<v-autocomplete
								v-model="formState.user"
								:items="userlist"
								label="Select user"
								item-title="name"
								item-value="id"
							></v-autocomplete>
						</div>

            <div class="form-item">
                <button v-if="id" @click="edit" class="btn-main" type="button">Update</button>
                <button v-else  @click="addProject" class="btn-main" type="button">Submit</button>
            </div>
        </form>

    </div>

		<BaseModal
			:modalActive="modalActive"
			@close-modal="toggleModal"
		>		
			you are missing some data
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
</style>
