<template>
    <div class="overflow-x-auto">
        <table class="w-full max-sm:w-[800px]">
            <thead class="text-sm font-semibold text-slate-500 bg-slate-50 border-t border-b border-slate-200">
            <tr class="[&amp;>*]:border [&amp;>*]:border-solid">
                <th class="px-2 py-3 whitespace-nowrap border border-solid font-semibold text-center">Chức năng</th>
                <th v-for="action in actions" :key="action" class="px-2 py-3 whitespace-nowrap border border-solid font-semibold text-center">{{ action }}</th>
            </tr>
            </thead>
            <tbody class="text-sm divide-y divide-slate-200 bg-white">
            <tr v-for="(item, index) in items" :key="index" class="[&amp;>*]:border [&amp;>*]:border-solid">
                <td class="px-2 py-3 whitespace-nowrap font-medium">{{ item.title }}</td>
                <td v-for="action in actions" :key="action" class="px-2 py-3 whitespace-nowrap">
                    <div class="form-check d-flex justify-content-center cursor-pointer">
                        <input
                            class="form-check-input cursor-pointer"
                            type="checkbox"
                            :id="`${item.title}-${action}`"
                            :name="`${item.title}-${action}`"
                            :checked="isPermissionGranted(`${item.title}-${action}`)"
                            @change="togglePermission(item.title, action)"
                        >
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <button @click="updatePermissions" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Update</button>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { $axios } from '../utils/request';

const actions = ['CREATE', 'UPDATE', 'READ', 'DELETE'];

const items = [
    { title: 'USER', permissions: ['USER-CREATE', 'USER-READ', 'USER-UPDATE', 'USER-DELETE'] },
    { title: 'TEAM', permissions: ['TEAM-CREATE', 'TEAM-READ', 'TEAM-UPDATE', 'TEAM-DELETE'] },
    { title: 'PROJECT', permissions: ['PROJECT-CREATE', 'PROJECT-READ', 'PROJECT-UPDATE', 'PROJECT-DELETE'] },
    // Add more items here
];

const props = defineProps({
    permissions: Array,
});

const originalPermissions = props.permissions;
const updatedPermissions = ref([...originalPermissions]);

const isPermissionGranted = (permission) => updatedPermissions.value.includes(permission);

const togglePermission = (title, action) => {
    const permission = `${title}-${action}`;
    const index = updatedPermissions.value.indexOf(permission);
    if (index === -1) {
        updatedPermissions.value.push(permission);
    } else {
        updatedPermissions.value.splice(index, 1);
    }
};

const updatePermissions = () => {
    // Remove unchecked permissions from the updatedPermissions array
    updatedPermissions.value = updatedPermissions.value.filter(permission =>
        items.some(item => item.permissions.includes(permission))
    );

    // Send the updated permissions to the server
    const data = { permissions: updatedPermissions.value };
    const roleId = 5; // Replace with the appropriate role ID
    $axios.put(`/roles/${roleId}`, data)
        .then(response => {
            console.log(response.data);
            // Handle response here
        })
        .catch(error => {
            console.error(error);
            // Handle error here
        });
};

onMounted(() => {
    // Logic to initialize or fetch permissions if needed
});
</script>

<style scoped>
/* Your styles here */
</style>
