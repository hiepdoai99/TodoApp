<script setup>
import { watch,computed, onMounted } from "vue";
import store from '../store/store'


//let userTeamsDataListing = ref([{id:1 , name: 'test'}])
let userTeamsData = computed(() => {
	return store.state.usersTeamData
})
let userTeamsDatasLocal = JSON.parse(localStorage.getItem('userTeams'));

onMounted(()=>{
	afterReloadTeamsCheck();
})


watch(userTeamsData,(newteams)=>{
  userTeamsData = JSON.parse(JSON.stringify(newteams))
  console.log('userTeamsDataListing watch',userTeamsData)
})

const afterReloadTeamsCheck = () =>{
  userTeamsData = userTeamsDatasLocal
  console.log('userTeamsDataListing reload',userTeamsData)

};
</script>

<template>

<main class="form-register">
      <h1 class="form-header">What do you want to do today ?</h1>
      <form class="form-container">
        <div class="form-item">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
					Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
					Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
					Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        </div>

        <div class="form-item">
          <h2 class="pickteam-header"> Pick your team to work for today</h2>
          <div class="teams-listing-container">
            <div class="team-list" v-for="team in userTeamsData" :key="team.id">
              <button class="team-btn">
                  <router-link class="link-text" to="/add-team">{{ team.name }}</router-link>
              </button>
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
