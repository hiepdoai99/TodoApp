<script setup>
import {$axios} from '../utils/request'
import {useRouter, useRoute} from 'vue-router'
import BaseModal from '../components/BaseModal.vue'
import ViewUserModal from '../components/ViewUserModal.vue'
import {
    onMounted,
    ref, reactive
} from "vue";
const router = useRouter()
const route = useRoute()
let localPermissions = JSON.parse(localStorage.getItem('permissions'))
const id = route.params.id ?? null;
const teamList = ref([])
let userlist = ref([])
let teamlistParse = ref([])
const users = ref([])
const usersInProject = ref([])
const modalActive = ref(null)
const modalWarningActive = ref(null);
const beforeDeleteModal = ref(null);
let selectedToDelUserId = ref();
let userDetail = ref()
let userRoleData = ref('')
let userDatas = ref('')

onMounted(() => {
		userRoleData = localStorage.getItem('loginRole');
		userDatas = JSON.parse(localStorage.getItem('user'));
    if (id) {
      getProject(id)
    }
		getTeams()
		getUser()
})

const toggleModal = () => {
  modalActive.value = !modalActive.value;
};

const toggleWarningModal = () => {
  modalWarningActive.value = !modalWarningActive.value;
};

const toggleBeforeDeleteModal = () => {
  beforeDeleteModal.value = !beforeDeleteModal.value;
};

const showDetail = (id) => {
	let item = JSON.parse(JSON.stringify(usersInProject.value))
	item.forEach(element => {
		if (element.id === id){
			userDetail = element
		}
	});
};

const viewUserRoleCheck =(id) =>{
	const requiredRole = localPermissions.find((roles)=>{
		return roles === 'TASK-READ'
	})

	if (requiredRole === 'TASK-READ'){
		toggleModal()
		showDetail(id)
	} else {
		toggleWarningModal()
	}
}

const deleteTaskRoleCheck = (userId) =>{
	const requiredRole = localPermissions.find((roles)=>{
		return roles === 'TASK-DELETE'
	})

	if (requiredRole === 'TASK-DELETE'){
		selectedToDelUserId = userId
		toggleBeforeDeleteModal()
	} else {
		toggleWarningModal()
	}
}
const deleteUser = () => {
    $axios.post('/remove-user-project/', {
			project_id: id,
			user_id: selectedToDelUserId
		}).then(res => {
			beforeDeleteModal.value = !beforeDeleteModal.value;
			getProject(id)
    })
		
}
const getUser = () => {
    if(userRoleData === 'ROOT' || userRoleData === 'ADMIN'){
        $axios.get('/user').then((data) => {
					users.value = data.data.data
					userlist = JSON.parse(JSON.stringify(users.value))
    	})
    } else if (userRoleData === 'TEAMLEADER'){
			$axios.get('/get-all-user-team').then((data) => {
					users.value = data.data
					userlist = JSON.parse(JSON.stringify(users.value))
					userlist = userlist.map((e)=>{
						return {
							id: e.id,
							name: e.first_name + e.last_name,
						}
					})
    	})
    } else{
        userlist = [{
						id: userDatas.id,
						name: userDatas.first_name + userDatas.last_name
					}]
    }
}
const getProject = (id) => {
    $axios.get(`/project/${id}?include=users`).then(
        (res) => {
            if (res) {
                formState.name = res.data.data.name;
								usersInProject.value = res.data.data.users;
            }
        }
    )
		localPermissions= localPermissions.map(e => e.name)
}

const getTeams = () => {
    $axios.get('/team?include=projects,created_by_user,users&per_page=3&page=1').then((data) => {
			teamList.value = data.data.data
			teamlistParse = JSON.parse(JSON.stringify(teamList.value))
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

						<div v-if="userRoleData === 'ROOT' || userRoleData === 'ADMIN' || userRoleData === 'TEAMLEADER'" class="autocomplete-item">
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

						<section v-if="id" class="table-body">
							<table>
									<thead>
									<tr>
											<th>ID</th>
											<th>Name</th>
											<th>Actions</th>
									</tr>
									</thead>
									<tbody>
									<tr v-for="user in usersInProject" :key="user.id">
											<td data-cell="id">{{ user.id }}</td>
											<td data-cell="name">{{ user.name }}</td>
											<td data-cell="action">
													<div class="actions-box">
														<div @click="viewUserRoleCheck(user.id)" class="btn view-btn">
																<font-awesome-icon :icon="['fas', 'eye']" />
														</div>
														<div>
																<div @click="deleteTaskRoleCheck(user.id)" class="btn delete-btn">
																	<font-awesome-icon :icon="['fas', 'delete-left']" />
																</div>
														</div>
													</div>
											</td>
									</tr>
									</tbody>

							</table>
						</section>

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

		<BaseModal
			:modalActive="modalActive"
			@close-modal="toggleModal"
		>
			<ViewUserModal :userdetail="userDetail"/>
		</BaseModal>

		<BaseModal
			:modalActive="modalWarningActive"
			@close-modal="toggleWarningModal"
		>		
			We are sorry but you do not have the permission to do this action
		</BaseModal>

		<BaseModal
			:modalActive="beforeDeleteModal"
			@close-modal="toggleBeforeDeleteModal"
		>		
			<div class="delete-modal-box">
				<h3>Are you sure u want to delete this user?</h3>
				<div class="delete-btn-box">
					<div @click="deleteUser" class="btn-main" type="button">Delete</div>
				</div>

			</div>
		</BaseModal>
</template>


<style lang="scss" scoped>
/* Most style are from register.vue  */
.delete-modal-box{
    
		.delete-btn-box{
			display: flex;
			align-items: center;
			flex-direction: column;
			.btn-main{
				background-color: rgb(170, 16, 16);
			}
		}
	}
.table-header {
    width: 100%;
    justify-content: space-between;
    text-align: center;
}

.actions-box{
	display: flex;
	width: 100%;
}

.actions-box div{
	width: 50%;
	text-align: center;
}
.view-btn {
    color: green;
}

.delete-btn {
    color: red;
}


.table-body {
    width: 95%;
    max-height: calc(89% - 1.6rem);
    background-color: #fffb;

    margin: .8rem auto;
    border-radius: .6rem;

    overflow: auto;
    overflow: overlay;
}

.table-body::-webkit-scrollbar {
    width: 0.5rem;
    height: 0.5rem;
}

.table-body::-webkit-scrollbar-thumb {
    border-radius: .5rem;
    background-color: #0004;
    visibility: hidden;
}

.table-body:hover::-webkit-scrollbar-thumb {
    visibility: visible;
}

table {
    width: 100%;
}

table, th, td {
    border-collapse: collapse;
    padding: 1rem;
    text-align: left;
}

thead th {
    position: sticky;
    top: 0;
    left: 0;
    background-color: #1D5D9B;
    color: white;
    cursor: pointer;
    text-transform: capitalize;
}

tbody tr:nth-child(even) {
    background-color: #0000000b;
}

tbody tr {
    --delay: .1s;
    transition: .5s ease-in-out var(--delay), background-color 0s;
}


tbody tr:hover {
    background-color: #fff6 !important;
}

tbody tr td,
tbody tr td p {
    transition: .2s ease-in-out;
}

@media (max-width: 1000px) {
	th{
		display: none;
	}

	td{
		display: grid;
		gap: 0.5rem;
		grid-template-columns: 15ch auto;
		padding: 0.5rem 1rem;
	}

	td:first-child{
		padding-top: 2rem;
	}

	td:last-child{
		padding-bottom: 2rem;
	}

	td::before{
		content: attr(data-cell) ": ";
		font-weight: 700;
		text-transform: capitalize;
	}
}
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


</style>
