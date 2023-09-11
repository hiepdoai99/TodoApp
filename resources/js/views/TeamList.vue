<script setup>
import {$axios} from '../utils/request'

import VPagination from "@hennge/vue3-pagination"
import "@hennge/vue3-pagination/dist/vue3-pagination.css"

import BaseModal from '../components/BaseModal.vue'
import InviteMemberModal from '../components/InviteMemberModal.vue'
import ViewTeamModal from '../components/ViewTeamModal.vue'

import {
    onMounted,
    ref
} from "vue";

let localPermissions = JSON.parse(localStorage.getItem('permissions'))
const viewDetailModal = ref(null);
const inviteMemberModal = ref(null)
let teamdetail = ref()
let canEdit = ref(false)
let canAddTeam = ref(false)
const teams = ref([])
const currentPage = ref(1);
const payloadData = ref([]);
let maxPage = 5;
onMounted(() => {
    getData()
		editTeamRoleCheck()
		addTeamRoleCheck()
})

const editTeamRoleCheck = () =>{
	const requiredRole = localPermissions.find((roles)=>{
		return roles === 'TEAM-UPDATE'
	})
	if (requiredRole === 'TEAM-UPDATE'){
		canEdit = true
	} 
}

const addTeamRoleCheck = () =>{
	const requiredRole = localPermissions.find((roles)=>{
		return roles === 'TEAM-CREATE'
	})
	if (requiredRole === 'TEAM-CREATE'){
		canAddTeam = true
	} 
}


const deleteTeamRoleCheck = (id) =>{
	const requiredRole = localPermissions.find((roles)=>{
		return roles === 'TEAM-DELETE'
	})

	if (requiredRole === 'TEAM-DELETE'){
		deleteobj(id)
	} else {
		toggleWarningModal()
	}
}

const viewTeamRoleCheck =(id) =>{
	const requiredRole = localPermissions.find((roles)=>{
		return roles === 'TEAM-READ'
	})

	if (requiredRole === 'TEAM-READ'){
		toggleModal()
		showDetail(id)
	} else {
		toggleWarningModal()
	}
}

const toggleModal = () => {
  viewDetailModal.value = !viewDetailModal.value;
};

const toggleInviteModal = () => {
  inviteMemberModal.value = !inviteMemberModal.value;
};

const onClickHandler = (page) => {
		$axios.get(`/team?include=projects,created_by_user,users&per_page=3&page=${page}`).then((data) => {
			teams.value = data.data.data
    })
  };

const showDetail = (id) => {

	$axios.get(`/team/${id}?include=projects,users`).then((data) => {
			teamdetail.value = data.data.data
			
    })
};

const getData = () => {
    $axios.get('/team?include=projects,created_by_user,users&per_page=3&page=1').then((data) => {
        teams.value = data.data.data
				payloadData.value = data.data.payload.pagination
				maxPage = Math.round(data.data.payload.pagination.total / data.data.payload.pagination.per_page)
				
    })
	localPermissions= localPermissions.map(e => e.name)
}
const deleteobj = (teamId	) => {
    $axios.delete('/team/' + teamId).then(res => {
        getData()
    })
}

</script>

<template>
    <body>
    <main>
        <section class="table-header">
            <h1 class="form-header">Team manager</h1>
            <div class="table-search-and-add-box">

            	<div class="main-btn-container">
								<div v-if="canAddTeam === true" class="main-btn-box">
									<button class="main-btn">
											<router-link class="linktext" to="/add-team">Add Team</router-link>
									</button>
								</div>

								<div class="main-btn-box">
									<button  @click="toggleInviteModal()" class="main-btn">
										Invite new member
									</button>
								</div>
							</div>
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
                <tr v-for="team in teams" :key="team.id">
                    <td data-cell="id">{{ team.id }}</td>
                    <td data-cell="name">{{ team.name }}</td>
										<td data-cell="action">
											<div class="actions-box">
												<div @click="viewTeamRoleCheck(team.id)" class="btn view-btn">
														<font-awesome-icon :icon="['fas', 'eye']" />
												</div>
												<div>
														<router-link v-if="canEdit" :to="{name: 'edit-team', params: { id: team.id }}" class="btn edit-btn">
															<font-awesome-icon :icon="['fas', 'pen-to-square']" />
														</router-link>
												</div>
												<div>
														<button @click="deleteTeamRoleCheck(team.id)" class="btn delete-btn">
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
						:modalActive="viewDetailModal"
						@close-modal="toggleModal"
					>		
						<ViewTeamModal :taskdetail="teamdetail"/>
					</BaseModal>

					<BaseModal
						:modalActive="inviteMemberModal"
						@close-modal="toggleInviteModal"
					>		
						<InviteMemberModal/>
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


<style lang="scss" scoped>

main {
    margin-top: 1%;
    background-color: #75C2F6;
    border-radius: 0px 0px 15px 15px;
		width: 75%;
}

body {
    /* min-height: 80vh; */
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

.actions-box{
	display: flex;
	width: 100%;
}

.actions-box div{
	width: 33.3%;
	text-align: center;
}
.table-header {
    width: 100%;
    height: 10%;
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
		span {
			margin-right: 5px;
			cursor: pointer;
		}
}


.table-search-and-add-box {
    padding: 20px;
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


.main-btn-container{
	width: 100%;
	display: flex;
	.main-btn-box{
		width: 50%;
		text-align: center;
		margin: 1% 10px;
			.main-btn {
				background-color: #1D5D9B;
				padding: 10px 0px 10px 0px;
				height: 100%;
				width: 100%;
				border-radius: 20px;
				border: none;
				color: white;
				text-align: center;
			.linktext {
				color: white;
				text-decoration: none;
			}
		}
	}

	
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

thead th:hover {
    color: #FDFDC9;
}


</style>
