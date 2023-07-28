<script setup>
		import { ref, provide, useSlots } from "vue";
		const tabTitles = ref();
		tabTitles.value = useSlots()?.default?.().map((tab) => tab?.props?.title);
		const selectedTitle = ref(tabTitles.value[0]);
		provide("selectedTitle", selectedTitle);
</script>x

<template>
	<div class="tabs">
		<ul class="tabs-header">
			<li 
				v-for="title in tabTitles" 
				:class="{selected: title == selectedTitle}" 
				:key="title" 
				@click="selectedTitle = title"
			>
				{{ title }}
			</li>
		</ul>
		<slot></slot> 
	</div>
</template>


<style scoped>
 .tabs{
	margin: 1%;
	background-color: #75C2F6;
	border-radius: 10px;
 }
 .tabs-header{
	margin-bottom: 10px;
	list-style: none;
	padding: 0;
	display: flex;
	width: 100%;
 }

 .tabs-header li {
	width: 50%;
	text-align: center;
	padding: 10px 20px;
	background-color: #749BC2;
	border-radius: 0px 0px 10px 10px;
	color: white;
	cursor: pointer;
	transition: 0.4s all ease-out;
 }

 .tabs-header li.selected{
	background-color: #1D5D9B;
	color: white;
 }
</style>