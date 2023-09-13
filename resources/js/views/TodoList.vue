<script setup>
import {$axios} from '../utils/request'
import {useRouter, useRoute} from 'vue-router'
import BaseModal from '../components/BaseModal.vue'
import ViewModal from '../components/ViewModal.vue'
import store from "../store/store";
import VPagination from "@hennge/vue3-pagination"
import "@hennge/vue3-pagination/dist/vue3-pagination.css"
import {
    onMounted,
    ref, watch
} from "vue";

const router = useRouter()
const route = useRoute()
let localPermissions = JSON.parse(localStorage.getItem('permissions'))

const modalActive = ref(null);
const modalWarningActive = ref(null);
let canEdit = ref(false);
let taskdetail = ref();
const todoList = ref([]);
const payloadData = ref([]);
let maxPage = 5;
const input = ref('');
const currentPage = ref(1);
let projectIdSelected = ref();

const toggleModal = () => {
  modalActive.value = !modalActive.value;
};

const filterPermissions = () => {
  localPermissions = localPermissions.map(e => e.name)
	store.state.storePermissions = localPermissions
};

const toggleWarningModal = () => {
  modalWarningActive.value = !modalWarningActive.value;
};

const showDetail = (id) => {
	let item = JSON.parse(JSON.stringify(todoList.value))
	item.forEach(element => {
		if (element.id === id){
			taskdetail = element
		}
	});
};

const editTaskRoleCheck = () =>{
	const requiredRole = localPermissions.find((roles)=>{
		return roles === 'TASK-UPDATE'
	})
	if (requiredRole === 'TASK-UPDATE'){
		canEdit = true
	} 
}

const deleteTaskRoleCheck = (id) =>{
	const requiredRole = localPermissions.find((roles)=>{
		return roles === 'TASK-DELETE'
	})

	if (requiredRole === 'TASK-DELETE'){
		deleteobj(id)
	} else {
		toggleWarningModal()
	}
}

const viewDetailRoleCheck =(id) =>{
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

const onClickHandler = (page) => {
		$axios.get(`/task?include=user,project,status,assignee,comments&project_id=${projectIdSelected}&per_page=2&page=${page}`).then((data) => {
        todoList.value = data.data.data
    })
  };

onMounted(() => {
	filterPermissions()
	window.addEventListener('projectId-added', () => {
    projectIdSelected = localStorage.getItem('selectedProjectId');
		getData(projectIdSelected)
		editTaskRoleCheck()
  });
	getSelectedIdlocal()
	editTaskRoleCheck()
})

const getSelectedIdlocal = () =>{
	if(projectIdSelected.value === undefined){
		projectIdSelected = localStorage.getItem('selectedProjectId');
		getData(projectIdSelected)
	}

}

const getData = (projectId) => {
    $axios.get(`/task?include=user,project,status,assignee,comments&project_id=${projectId}&per_page=2&page=1`).then((data) => {
        todoList.value = data.data.data
				payloadData.value = data.data.payload.pagination
				if(payloadData.value.total !== undefined){
					maxPage = Math.round(payloadData.value.total / data.data.payload.pagination.per_page)
				}
				console.log('maxPage :',  maxPage)
    })
}

const deleteobj = (todoId) => {
    $axios.delete('/task/' + todoId).then(res => {
        getData(projectIdSelected)
    })
}

const statusStyleSet = (statusname) =>{
	if (statusname === 'Todo'){
		return 'status shipped'
	} else if (statusname === ' Ongoing '){
		return 'status pending'
	}  else if (statusname === ' Done '){
		return 'status delivered'
	} else {
		return 'status cancelled'
	}
}

watch(input,
    async (newInput) => {
        if (newInput.length > 0) {
            $axios.get('/task?search=' + input.value + '&include=user,project,status,assignee').then((data) => {
                todoList.value = data.data.data
            })
        } else {
            $axios.get('/task?include=user,project,status,assignee').then((data) => {
                todoList.value = data.data.data
            })
        }
    })


</script>

<template>
    <body>
			<main>
					<section class="table-header">
							<h1 class="form-header">Tasks manager</h1>
							<div class="table-search-and-add-box">

									<div class="input-group">
											<input type="text" v-model="input" placeholder="Search task ..."/>
									</div>

									<button class="addtask-btn">
											<a href="/#">
												<router-link to="/add-todo">Add Todo</router-link>
											</a>
									</button>

							</div>
					</section>

					<section class="table-body">
							<table>
									<thead>
									<tr>
											<th>ID</th>
											<th>Name</th>
											<th>Description</th>
											<th>Start date</th>
											<th>End date</th>
											<th>Status</th>
											<th>Actions</th>
									</tr>
									</thead>
									<tbody>
									<tr v-for="todo in todoList" :key="todo.id">
											<td data-cell="id">{{ todo.id }}</td>
											<td data-cell="name">{{ todo.name }}</td>
											<td data-cell="description">{{ todo.description }}</td>
											<td data-cell="start date">{{ todo.start_date }}</td>
											<td data-cell="end date">{{ todo.end_date }}</td>
											<td data-cell="action">
												<span :class="statusStyleSet(todo.status.name) ">
													{{ todo.status.name }}
												</span>
											</td>
											<td data-cell="action">
													<div class="actions-box">
														<div @click="viewDetailRoleCheck(todo.id)" class="btn view-btn">
																<font-awesome-icon :icon="['fas', 'eye']" />
														</div>
														<div>
																<router-link v-if="canEdit === true" :to="{name: 'edit', params: { id: todo.id }}" class="btn edit-btn">
																	<font-awesome-icon :icon="['fas', 'pen-to-square']" />
																</router-link>																
														</div>
														<div>
																<button @click="deleteTaskRoleCheck(todo.id)" class="btn delete-btn">
																	<font-awesome-icon :icon="['fas', 'delete-left']" />
																</button>
														</div>
													</div>
											</td>
									</tr>
									</tbody>

							</table>
					</section>
					<BaseModal
						:modalActive="modalActive"
						@close-modal="toggleModal"
					>
						<ViewModal :taskdetail="taskdetail"/>
					</BaseModal>

					<BaseModal
						:modalActive="modalWarningActive"
						@close-modal="toggleWarningModal"
					>		
						We are sorry but you do not have the permission to do this action
					</BaseModal>

					<div class="pagination-body">
						<v-pagination
							v-model="currentPage"
							:pages="maxPage"
							:range-size="1"
							active-color="#FDFDC9"
							@update:modelValue="onClickHandler"
						/>
					</div>
			</main>
    </body>
</template>


<style scoped lang="scss">

main {
    margin-top: 1%;
    background-color: #75C2F6;
    border-radius: 0px 0px 15px 15px;
		width: 90%;
}

body {
    /* min-height: 80vh; */
		width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}

.pagination-body{
	width: 100%;
	.Pagination{
		justify-content: center;
	}
}

.table-header {
    width: 100%;
    justify-content: space-between;
    text-align: center;
}

.input-group {
    width: 100%;
    height: 100%;
    background-color: #fff5;
    padding: 0.5rem 1rem;
    border-radius: 2rem;

    display: flex;
    justify-content: center;
    align-items: center;

    transition: .2s;
}

.table-search-and-add-box {
    padding: 20px;
}

.actions-box{
	display: flex;
	width: 100%;
}

.actions-box div{
	width: 33.3%;
	text-align: center;
}
.view-btn {
    color: green;
}

.edit-btn {
    color: #ebc474;
}

.delete-btn {
    color: red;
}

.addtask-btn {
    background-color: #1D5D9B;
    padding: 10px 0px 10px 0px;
    margin-top: 1%;
    height: 100%;
    width: 25%;
    border-radius: 20px;
    border: none;
    color: white;
    text-align: center;
}

.addtask-btn a {
    color: white;
    text-decoration: none;
}

.table-header .input-group:hover {
    background-color: #FDFDC9;
    box-shadow: 0 .1rem .4rem #0002;
}

.table-header .input-group input {
    width: 100%;
    padding: 0 .5rem 0 .3rem;
    background-color: transparent;
    border: none;
    outline: none;
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

.status {
    border-radius: 2rem;
    text-align: center;
		padding: .5rem 1.5rem;
}
.status.shipped {
    background-color: #6fcaea;
    color: white;
}

.status.delivered {
	background-color: #86e49d;
	color: white;
}

.status.cancelled {
    background-color: #d46c85;
    color: white;
}

.status.pending {
    background-color: #ebc474;
    color: white;
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

thead th:hover {
  color: #FDFDC9;
}

</style>
