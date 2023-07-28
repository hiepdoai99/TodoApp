<script setup>
import TabSection from '../components/TabSection.vue';
import TabWrapper from '../components/TabWrapper.vue';
import statisticComponent from '../components/statisticComponent.vue';
import UserTableList from '../components/UserTablelist.vue';
import TeamTableList from '../components/TeamTableList.vue'
</script>

<template>
 <section class="statistic-section">
		<statisticComponent/>
 </section>

 <section class="tab-section">
		<TabWrapper class="tab-section">
			<TabSection title="Tab 1">
				<UserTableList/>
			</TabSection>

			<TabSection title="Tab 2">
				<TeamTableList/>
			</TabSection>
		</TabWrapper>
 </section>
</template>

<style scoped>
    .statistic-section{
			margin: 1%;
			display: flex;
			border-radius: 10px;
			background-color: #1D5D9B;
    }
		
		.tab-section{
			width: 100%;
		}
</style>