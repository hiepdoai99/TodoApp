<script setup>

import { ref } from "vue";

let isOpen = ref(false);

const openMenu = () => {
  isOpen.value = !isOpen.value;
};

// const minimizeNavbar = () => {
//   isOpen.value = true;
// 	console.log('this does run')
// };
</script>

<template>

	<nav class="navbar navbar-expand-lg">
		<div class="container-fluid">
			<button class="navbar-toggler extra-opt-btn " type="button" @click="openMenu()">
				<font-awesome-icon :icon="['fas', 'bars']" style="color: #ffffff;" />

			</button>
			<div :class="isOpen === true ? 'collapse navbar-collapse show' : 'collapse navbar-collapse' " id="navbarSupportedContent">
				<ul class="navbar-nav">
					<li class="nav-item">
							<a class="nav-link active" aria-current="page" href="#">
									<router-link to="/">Home</router-link>
							</a>
					</li>
					<li class="nav-item">
							<a class="nav-link" href="#">
									<router-link to="/add-todo">Add task</router-link>
							</a>
					</li>
					<li class="nav-item">
							<a class="nav-link" href="#">
									<router-link to="/todo">Tasks</router-link>
							</a>
					</li>
					<li class="nav-item">
							<a class="nav-link" href="#">
									<router-link to="/team">Team</router-link>
							</a>
					</li>
					<li class="nav-item">
							<a class="nav-link" href="#">
									<router-link to="/projects">Project</router-link>
							</a>
					</li>
					<li class="nav-item">
							<a class="nav-link" href="#">
									<router-link to="/login">Login</router-link>
							</a>

					</li>
					<li class="nav-item">
							<a class="nav-link" href="#">
									<router-link to="/register">Register</router-link>
							</a>
					</li>
					<li class="nav-item">
							<a class="nav-link" href="#">
									<router-link to="/admin">Admin</router-link>
							</a>
					</li>
			</ul>
			</div>
		</div>
	</nav>
</template>

<style scoped lang="scss">
.extra-opt-btn{
 width: 100%;
 text-align: center;
}

.navbar-toggler{
	color: white;
}

.navbar {
    display: flex;
    background-color: #1D5D9B;

    .navbar-nav {
        justify-content: right;
        width: 100%;
    }

    .nav-item {
        .nav-link {
					a {
						color: white !important;
						text-decoration: unset !important;
					}
        }
    }
}
</style>
