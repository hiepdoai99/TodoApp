<script setup>

import { ref,onMounted } from "vue";
import {emitter} from '../utils/eventBus';
import {$axios} from "../utils/request.js";
import {useRouter, useRoute} from 'vue-router'
const router = useRouter()
const route = useRoute()


let isOpen = ref(false);
let adminVisible = ref(false);
let memberVisible = ref(false);
let userLoginDataReceived = ref('');
let userRoleReceived = ref('');
const openMenu = () => {
  isOpen.value = !isOpen.value;
};

onMounted(()=>{
	emitter.on("user-role-data", res => {
		userRoleReceived = res[0].name;
		//console.log(userRoleReceived);
		if (userRoleReceived === 'ROOT' || userRoleReceived ==="ADMIN"){
			adminVisible.value = !adminVisible.value
			memberVisible.value = !memberVisible.value
		} else if (userRoleReceived === 'MEMBER') {
			memberVisible.value = !memberVisible.value
		}
    });

		getUserLoginData()
		emitter.emit("add-task-user-data", userLoginDataReceived)
})

const pushdata = async () => {
	console.log("this run user-data", userLoginDataReceived)
	emitter.emit("add-task-user-data", userLoginDataReceived)
}

const getUserLoginData = () => {
	emitter.on("user-login-data", res => {
		userLoginDataReceived = res;
		console.log('loiginz',userLoginDataReceived);
   });
}
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
									WELCOME, {{ userLoginDataReceived.first_name }}
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
									<router-link @click="pushdata" to="/add-todo">Add task</router-link>
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
