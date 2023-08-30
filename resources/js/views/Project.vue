<script setup>
import {$axios} from '../utils/request'

import VPagination from "@hennge/vue3-pagination"
import "@hennge/vue3-pagination/dist/vue3-pagination.css"

let localPermissions = JSON.parse(localStorage.getItem('permissions'))
let canEdit = ref(false)
let canAddProject = ref(false)
import {
    onMounted,
    ref
} from "vue";

const projects = ref([])
const currentPage = ref(1);
const payloadData = ref([]);
let maxPage = 5;
onMounted(() => {
    getData()
		editProjectRoleCheck()
		addProjectRoleCheck()
})

const editProjectRoleCheck = () =>{
	const requiredRole = localPermissions.find((roles)=>{
		return roles === 'PROJECT-UPDATE'
	})
	if (requiredRole === 'PROJECT-UPDATE'){
		canEdit = true
	} 
}

const addProjectRoleCheck = () =>{
	const requiredRole = localPermissions.find((roles)=>{
		return roles === 'PROJECT-CREATE'
	})
	if (requiredRole === 'PROJECT-CREATE'){
		canAddProject = true
	} 
}

const deleteProjectRoleCheck = (id) =>{
	const requiredRole = localPermissions.find((roles)=>{
		return roles === 'PROJECT-DELETE'
	})

	if (requiredRole === 'PROJECT-DELETE'){
		deleteobj(id)
	} else {
		toggleWarningModal()
	}
}


const onClickHandler = (page) => {
		$axios.get(`/project?per_page=1&page=${page}`).then((data) => {
			projects.value = data.data.data
    })
  };

const getData = () => {
    $axios.get('/project?per_page=1&page=1').then((data) => {
        projects.value = data.data.data
        payloadData.value = data.data.payload.pagination
				//console.log('projects.value',projects.value)
				//console.log('payloadData.value',payloadData.value)
				maxPage = Math.round(data.data.payload.pagination.total / data.data.payload.pagination.per_page)
    })
    localPermissions= localPermissions.map(e => e.name)
}
const deleteobj = (projectId) => {
    $axios.delete('/project/' + projectId).then(res => {
        getData()
    })
}


</script>

<template>
    <body>
    <main>
        <section class="table-header">
            <h1 class="form-header">Project manager</h1>
            <div class="table-search-and-add-box">
                <button v-if="canAddProject === true" class="addtask-btn">
                    <a href="#">
											<router-link to="/add-project"> Add project</router-link>
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
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="project in projects" :key="project.id">
                    <td data-cell="id">{{ project.id }}</td>
                    <td data-cell="name">{{ project.name }}</td>
										<td data-cell="action">
											<div class="actions-box">
												<div v-if="canEdit === true">
														<router-link :to="{name: 'edit-project', params: { id: project.id }}" class="btn edit-btn">
															<font-awesome-icon :icon="['fas', 'pen-to-square']" />
														</router-link>
												</div>
												<div>
														<button @click="deleteProjectRoleCheck(project.id)" class="btn delete-btn">
															<font-awesome-icon :icon="['fas', 'delete-left']" />
														</button>
												</div>
											</div>
										</td>
                </tr>
                </tbody>
            </table>
        </section>

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


<style scoped>
main {
    margin-top: 5%;
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

.task-setting {
    width: 10vh;
}

.task-setting span {
    margin-right: 5px;
    cursor: pointer;
}

.table-search-and-add-box {
    padding: 20px;
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
