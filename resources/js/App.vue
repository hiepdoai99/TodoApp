<script setup>
import AppNav from "./components/NavigateBar.vue";
import AppFooter from './components/footer.vue'
</script>
<template>
    <div class="page-container">
			<AppNav/>
        <div class="content-wrap">
            <router-view></router-view>
        </div>
				<AppFooter/>
    </div>

</template>

<style>
    .page-container {
        position: relative;
        min-height: 100vh;
    }

		.content-wrap {
			padding-bottom: 5rem;    /* Footer height */
		}
</style>

