<template>
    <div>
        <nav class="navbar navbar-expand-lg ">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#"><router-link  to="/">Home</router-link></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><router-link to="/todo">Tasks</router-link></a>
                        </li>

												<li class="nav-item">
                            <a class="nav-link" href="#"><router-link to="/team">Team</router-link></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><router-link to="/add-todo">Add task</router-link></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><router-link to="/login">Login</router-link></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><router-link to="/register">Register</router-link></a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</template>

<script>
export default {
    name: "Nav"
}
</script>

<style scoped lang="scss">

    .navbar {
			display: flex;
			background-color: #1D5D9B;

		.navbar-nav{
			justify-content: right;
			width: 100%;
		}
		
    .nav-item {

        .nav-link {
            a {
							color: white !important;
							text-decoration: unset!important;
            }
        }
    	}
    }
</style>
