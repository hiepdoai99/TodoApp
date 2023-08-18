<script setup>
import TabSection from '../components/TabSection.vue';
import TabWrapper from '../components/TabWrapper.vue';
import StatisticComponent from '../components/StatisticComponent.vue';
import UserTableList from '../components/UserTablelist.vue';
import TeamTableList from '../components/TeamTableList.vue'
import RolesList from '../components/Permisstions.vue'
</script>

<template>
 <section class="statistic-section">
		<StatisticComponent/>
 </section>

 <section class="tab-section">
		<TabWrapper>

			<TabSection title="Users table">
				<UserTableList/>
			</TabSection>

			<TabSection title="Teams table">
				<TeamTableList/>
			</TabSection>

            <TabSection title="Roles table">
				<RolesList/>
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
