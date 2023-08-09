<script setup>
import { useStore } from 'vuex'
import { computed } from 'vue'

const store = useStore()
store.dispatch("fetchAllTeam")
const teams = computed(()=>store.state.team)
console.log(teams)
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
					<a href="/add-todo" class="text-decoration-none">
						Plan yourself now
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-square-fill" viewBox="0 0 16 16">
								<path d="M0 14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v12zm4.5-6.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5a.5.5 0 0 1 0-1z"></path>
						</svg>
					</a>
        </div>
      </form>
    </main>
</template>
<style scoped>

</style>
