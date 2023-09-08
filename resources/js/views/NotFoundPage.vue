<script setup>
</script>

<template>

	<main class="form-register">
		<h1 class="form-header">You do not have the permission to do this action !</h1>
		<form class="form-container">
			<div class="form-item">
				<router-link class="link-text" to="/">Return home</router-link>
			</div>
		</form>
	</main>

</template>
<style scoped lang="scss">
.form-item{
  display: block;
	width: 100%;
	text-align: center;
  .link-text {
		color: white;
		text-decoration: none;
		background-color: #1D5D9B;
		padding: 10px 10px 10px 10px;
		height: 100%;
		width: 100%;
		border-radius: 20px;
		border: none;
		color: white;
		text-align: center;
  }
}

</style>
