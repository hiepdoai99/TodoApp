<script setup>
import {onMounted, ref, watchEffect} from 'vue';
import {$axios} from '../utils/request'

const updatedPermissions = ref([]);
const checkedPermissions = ref([]);
const props = defineProps({
    permissions: Array,
    id_role: String,
    editPermissionCheck: Boolean,
});

const items = [
    { title: 'USER', permissions: ['USER-CREATE', 'USER-READ', 'USER-UPDATE', 'USER-DELETE'] },
    { title: 'TEAM', permissions: ['TEAM-CREATE', 'TEAM-READ', 'TEAM-UPDATE', 'TEAM-DELETE'] },
    { title: 'PROJECT', permissions: ['PROJECT-CREATE', 'PROJECT-READ', 'PROJECT-UPDATE', 'PROJECT-DELETE'] },
    { title: 'TASK', permissions: ['TASK-CREATE', 'TASK-READ', 'TASK-UPDATE', 'TASK-DELETE'] },
    { title: 'COMMENT', permissions: ['COMMENT-CREATE', 'COMMENT-READ', 'COMMENT-UPDATE', 'COMMENT-DELETE'] },
    { title: 'ROLE', permissions: ['ROLE-CREATE', 'ROLE-READ', 'ROLE-UPDATE', 'ROLE-DELETE'] },
    { title: 'PERMISSION', permissions: ['PERMISSION-CREATE', 'PERMISSION-READ', 'PERMISSION-UPDATE', 'PERMISSION-DELETE'] },
];

const isPermissionGranted = (permission) => props.permissions.some(p => p.name === permission);

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
    const id = props.id_role;
    if (JSON.stringify(updatedPermissions.value) !== JSON.stringify(checkedPermissions.value)) {
        const data = { permissions: updatedPermissions.value };

        $axios.put('/roles/' + id, data)
            .then((response) => {
                console.log(response.data);
                // Cập nhật dữ liệu cập nhật sau khi gửi thành công
                checkedPermissions.value = response.data.permissions;
                updatedPermissions.value = response.data.permissions; // Cập nhật danh sách quyền đã cập nhật
            })
            .catch((error) => {
                console.error(error);
            });
    }
};
watchEffect(() => {
    updatedPermissions.value = items.flatMap(item => item.permissions.filter(permission => isPermissionGranted(permission)));
});
onMounted(() => {
    checkedPermissions.value = props.permissions;
    // changedPermissions.value = props.permissions;
});
</script>

<template>
    <div class="overflow-x-auto">
        <table class="">
            <thead class="text-sm font-semibold text-slate-500 bg-slate-50 border-t border-b border-slate-200">
            <tr class="[&amp;>*]:border [&amp;>*]:border-solid">
                <th class="px-2 py-3 whitespace-nowrap border border-solid font-semibold text-center">FUNCTIONS</th>
                <th class="px-2 py-3 whitespace-nowrap border border-solid font-semibold text-center">CREATE</th>
                <th class="px-2 py-3 whitespace-nowrap border border-solid font-semibold text-center">READ</th>
                <th class="px-2 py-3 whitespace-nowrap border border-solid font-semibold text-center">UPDATE</th>
                <th class="px-2 py-3 whitespace-nowrap border border-solid font-semibold text-center">DELETE</th>
            </tr>
            </thead>
            <tbody class="text-sm divide-y divide-slate-200 bg-white">
            <tr v-for="(item, index) in items" :key="index" class="[&amp;>*]:border [&amp;>*]:border-solid">
                <td class="px-2 py-3 whitespace-nowrap font-medium">{{ item.title }}</td>
                <td v-for="permission in item.permissions" :key="permission" class="px-2 py-3 whitespace-nowrap">
                    <div class="form-check d-flex justify-content-center cursor-pointer">
                        <input
                            class="form-check-input cursor-pointer"
                            type="checkbox"
                            :id="permission"
                            :name="permission"
                            :checked="isPermissionGranted(permission)"
                            @change="togglePermission(item.title, permission.split('-')[1])"
                            :disabled="editPermissionCheck"
                        >
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="role-manager-btn-box">
            <div v-show="editPermissionCheck === false" @click="updatePermissions" class="permission-update-btn">Update</div>
        </div>

    </div>
</template>


<style lang="scss" scoped>
.overflow-x-auto{
    table{
        width: 100%;
    }
    .role-manager-btn-box{
      align-items: center;
			width: 100%;
			display: flex;
			flex-direction: column;
			padding-top: 10px;
			.permission-update-btn{
				background-color: green;
				padding: 10px 0px 10px 0px;
				height: 100%;
				width: 30%;
				border-radius: 20px;
				border: none;
				color: white;
				text-align: center;
			}
    }
}
/* Your styles here */
</style>
