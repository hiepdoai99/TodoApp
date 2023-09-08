<script setup>
import { watch,computed, onMounted,ref } from "vue";
import store from '../store/store'
import {$axios} from '../utils/request'

//let userTeamsDataListing = ref([{id:1 , name: 'test'}])
let userTeamsData = computed(() => {
	return store.state.usersTeamData
})
let userTeamsDatasLocal = JSON.parse(localStorage.getItem('userTeams'));
let projects = ref([])
let projectsLocal = JSON.parse(localStorage.getItem('projectsFromTeamLocal'));
let showProjects = ref(false)
onMounted(()=>{
	afterReloadTeamsCheck();
  projectLengthCheck();
})


watch(userTeamsData,(newteams)=>{
  userTeamsData = JSON.parse(JSON.stringify(newteams))
})

const projectLengthCheck = ()=>{
  if(  userTeamsDatasLocal === null){
    if(projects.value.length !== 0){
    showProjects = true
    } else if (projects.value.length === 0){
      showProjects = false
    }
  }
    
}

const afterReloadTeamsCheck = () =>{
  if( userTeamsDatasLocal !== null){
    store.state.usersTeamData = userTeamsDatasLocal
  }

  if(projectsLocal !== null){
    projects = projectsLocal
    if(projects.length !== 0){
    showProjects = true
    } else if (projects.length === 0){
      showProjects = false
    }
  }

};

const passSelectedTeamId = (id) =>{
  $axios.get(`/get-project?team_id=${id}`).then((data) => {
        projects.value = data.data.data
        localStorage.setItem('projectsFromTeamLocal',(JSON.stringify(data.data.data)))
        if(projects.value.length !== 0){
          showProjects = true
        }
    })
};

const passSelectedProjectId = (id) =>{
  localStorage.setItem('selectedProjectId',id)
  store.state.selectedProjectId = localStorage.getItem('selectedProjectId')
  window.dispatchEvent(new CustomEvent('projectId-added', {
    detail: {
      storage: localStorage.getItem('selectedProjectId')
    }
  }));
};
</script>

<template>

<main class="form-register">
      <form class="form-container">
        <div class="form-item">
          <h2 class="pickteam-header"> Pick your team to work for today</h2>
          <div class="teams-listing-container">
            <div class="team-list" v-for="team in userTeamsData" :key="team.id">
              <div @click="passSelectedTeamId(team.id)" class="team-btn">
                 {{ team.name }}
              </div>
            </div>
          </div>

          <h3 v-show="showProjects === true" class="pickteam-header"> Now, pick your projects</h3>
          <div v-show="showProjects === true" class="teams-listing-container">
            <div class="team-list" v-for="projectsItems in projects" :key="projectsItems.id">
              <div @click="passSelectedProjectId(projectsItems.id)" class="team-btn">
                 <router-link class="link-text" to="/todo">{{ projectsItems.name }}</router-link>
              </div>
            </div>
          </div>
        </div>

      </form>
    </main>
</template>
<style scoped lang="scss">
.form-item{
  display: block;
  
  .pickteam-header{
    text-align: center;
    background-color: #1D5D9B;
    border-radius: 15px;
    padding: 5px;
  }
  
  .teams-listing-container{
    display: flex;
    width: 100%;
    margin-bottom: 15px;
    .team-list{
      width: 100%;
      margin-right: 10px;
      .team-btn{
        background-color: #1D5D9B;
				padding: 10px 0px 10px 0px;
				height: 100%;
				width: 100%;
				border-radius: 20px;
				border: none;
				color: white;
				text-align: center;
      .link-text {
        color: white;
        text-decoration: none;
      }
    }
    }
      
  
  }

}




</style>
