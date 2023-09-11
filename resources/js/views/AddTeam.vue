<script setup>
import {$axios} from '../utils/request'
import {useRouter, useRoute} from 'vue-router'
import userVuelidate from '@vuelidate/core'
import {required} from '@vuelidate/validators'
import {
    onMounted, reactive,ref
} from "vue";
import BaseModal from '../components/BaseModal.vue'
import ViewUserModal from '../components/ViewUserModal.vue'
const router = useRouter()
const route = useRoute()
let teamDetail = ref()
let localPermissions = JSON.parse(localStorage.getItem('permissions'))
const usersOfTeam = ref([])
const projectsOfTeam = ref([])
const id = route.params.id ?? null;
let selectedToDelUserId = ref();
const modalActive = ref(null);
const modalWarningActive = ref(null);
const beforeDeleteModal = ref(null);
let userDetail = ref()
onMounted(() => {
    if (id) {
        getTeam(id)
				getData(id)
    }
})
const getTeam = (id) => {
    $axios.get('/team/' + id).then(
        (res) => {
            if (res) {
                formState.name = res.data.data.name;
								teamDetail = res.data.data
								
            }
        }
    )
}

const getData = (teamid) => {
    $axios.get(`/team/${teamid}?include=users,projects`).then((data) => {
        usersOfTeam.value = data.data.data.users
				projectsOfTeam.value = data.data.data.projects
    })
		localPermissions= localPermissions.map(e => e.name)
}
const formState = reactive({
    name: '',
})

const rules = {
    name: {required},
}

const v$ = userVuelidate(rules, formState)

const addTeam = async () => {
    //validate first
    const validateRes = await v$.value.$validate();
    if (validateRes) {
        $axios.post('/team', {
            name: formState.name,})
            .then(
                (data) => {
                    router.push('/team')
                }
            )
    }
}

const edit = () => {
    $axios.put('/team/' + id, {
        name: formState.name,

    }).then(
        (data) => {
            router.push('/team')
        }
    )
}
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
	let item = JSON.parse(JSON.stringify(usersOfTeam.value))
	item.forEach(element => {
		if (element.id === id){
			userDetail = element
		}
	});
};

const deleteUser = () => {
    $axios.post('/remove-user-team/' + {
			team_id: id,
			user_id: selectedToDelUserId
		}).then(res => {
        getData(id)
    })
}

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

</script>

<template>
    <div class="form-register">
        <h3 v-if="id" class="form-header"> Edit Team</h3>
				<h3 v-else class="form-header"> Add Team</h3>
        <form class="form-container" enctype="multipart/form-data">

            <div class="form-item">
                <label>Name</label>
                <input v-model="formState.name" class="form-control" type="text" aria-label=".form-control-lg example">

            </div>

            <div class="errtext" v-for="error in v$.name.$errors" :key="error.$uid">
                {{ error.$message }}
            </div>

						<section v-if="id" class="table-body">
							<table>
									<thead>
									<tr>
											<th>ID</th>
											<th>Team member</th>
											<th>Actions</th>
									</tr>
									</thead>
									<tbody>
									<tr v-for="user in usersOfTeam" :key="user.id">
											<td data-cell="id">{{ user.id }}</td>
											<td data-cell="Team member">{{ user.name }}</td>
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

						<section v-if="id" class="table-body">
							<table>
									<thead>
									<tr>
											<th>ID</th>
											<th>Project name</th>
									</tr>
									</thead>
									<tbody>
									<tr v-for="project in projectsOfTeam" :key="project.id">
											<td data-cell="id">{{ project.id }}</td>
											<td data-cell="Team member">{{ project.name }}</td>
									</tr>
									</tbody>

							</table>
						</section>

            <div class="form-item">
                <button v-if="id" @click="edit" class="btn-main" type="button">Update</button>
                <button v-else  @click="addTeam" class="btn-main" type="button">Submit</button>
            </div>
        </form>


    </div>

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


<style scoped lang="scss">
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
