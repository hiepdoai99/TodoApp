<script setup>

import { ref,watch,computed, onMounted } from "vue";
import {emitter} from '../utils/eventBus';
import {$axios} from "../utils/request.js";
import {useRouter, useRoute} from 'vue-router';
import store from '../store/store'
const router = useRouter()
const route = useRoute()

const trackRole = computed(() => {
  return store.state.userLoginRole
})

let isOpen = ref(false);
let adminVisible = ref(false);
let memberVisible = ref(false);
const openMenu = () => {
  isOpen.value = !isOpen.value;
};
onMounted(()=>{
	console.log('role check on mount:', store.state.userLoginRole)
})

watch(trackRole, (newRole)=>{
		console.log('role check on watch:', store.state.userLoginRole)
		//console.log('login data check: ', store.state.userLoginData)
		if (newRole === 'ROOT' || newRole ==="ADMIN"){
		adminVisible.value = !adminVisible.value
		memberVisible.value = !memberVisible.value
		} else if (newRole === 'MEMBER') {
			memberVisible.value = !memberVisible.value
		}
})

const logout = () =>{
    const token = localStorage.getItem('token');
    if (token) {
        $axios.post('/logout')
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        router.push('/login')
    }
}
</script>

<template>

	<nav class="navbar navbar-expand-lg">
		<div class="container-fluid">
			<button class="navbar-toggler extra-opt-btn " type="button" @click="openMenu()">
				<font-awesome-icon :icon="['fas', 'bars']" style="color: #ffffff;" />

			</button>
			<div :class="isOpen === true ? 'collapse navbar-collapse show' : 'collapse navbar-collapse' " id="navbarSupportedContent">
				<ul class="navbar-nav">
					<li v-show="memberVisible === true || adminVisible === true" class="nav-item">
						<a class="nav-link" href="#">
								<span>
									WELCOME, {{store.state.userLoginData.first_name}} {{store.state.userLoginData.last_name}}
								</span>
						</a>
					</li>
					<li class="nav-item">
							<a class="nav-link active" aria-current="page" href="#">
									<router-link to="/">Home</router-link>
							</a>
					</li>
					<li v-show="memberVisible === true" class="nav-item">
							<a class="nav-link" href="#">
									<router-link to="/add-todo">Add task</router-link>
							</a>
					</li>
					<li v-show="memberVisible === true" class="nav-item">
							<a class="nav-link" href="#">
									<router-link to="/todo">Tasks</router-link>
							</a>
					</li>
					<li v-show="memberVisible === true" class="nav-item">
							<a class="nav-link" href="#">
									<router-link to="/team">Team</router-link>
							</a>
					</li>
					<li v-show="memberVisible === true" class="nav-item">
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
							<a class="nav-link" href="/logout" @click="logout">
									Logout
							</a>
					</li>
					<li v-show="adminVisible === true" class="nav-item">
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
					color: white;
					a {
						color: white;
						text-decoration: unset;
					}
        }
    }
}
</style>
