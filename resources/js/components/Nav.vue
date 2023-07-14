<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-light bg-dark">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#"><router-link  to="/">HOME</router-link></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><router-link to="/todo">TodoList</router-link></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><router-link to="/add-todo">AddTodo</router-link></a>
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

<style scoped>

</style>
