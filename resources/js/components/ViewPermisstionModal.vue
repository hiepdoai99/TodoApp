<script setup>
const props = defineProps({
    permissions: Object,
});
</script>

<template>
    <!--    <table>-->
    <!--        <thead>-->
    <!--        <tr>-->
    <!--            <th>ID</th>-->
    <!--            <th>Name</th>-->
    <!--            <th>CREATE</th>-->
    <!--            <th>READ</th>-->
    <!--            <th>UPDATE</th>-->
    <!--            <th>DELETE</th>-->
    <!--        </tr>-->
    <!--        </thead>-->
    <!--        <tbody>-->
    <!--        <tr v-for="role in permissions" :key="role.id">-->
    <!--            <td data-cell="id">{{ role.id }}</td>-->
    <!--            <td data-cell="name"> {{ role.name }}</td>-->
    <!--            <td data-cell="name"> {{ role.name }}</td>-->
    <!--            <td data-cell="name"> {{ role.name }}</td>-->
    <!--            <td data-cell="name"> {{ role.name }}</td>-->
    <!--            <td data-cell="name"> {{ role.name }}</td>-->
    <!--        </tr>-->
    <!--        </tbody>-->
    <!--    </table>-->
    <div class="overflow-x-auto">
        <table class="w-full max-sm:w-[800px]">
            <thead class="text-sm font-semibold text-slate-500 bg-slate-50 border-t border-b border-slate-200">
            <tr class="[&amp;>*]:border [&amp;>*]:border-solid">
                <th class="px-2 py-3 whitespace-nowrap border border-solid font-semibold text-center">Chức năng</th>
                <th class="px-2 py-3 whitespace-nowrap border border-solid font-semibold text-center">CREATE</th>
                <th class="px-2 py-3 whitespace-nowrap border border-solid font-semibold text-center">UPDATE</th>
                <th class="px-2 py-3 whitespace-nowrap border border-solid font-semibold text-center">READ</th>
                <th class="px-2 py-3 whitespace-nowrap border border-solid font-semibold text-center">DELETE</th>
            </tr>
            </thead>
            <tbody class="text-sm divide-y divide-slate-200 bg-white">
            <tr class="[&amp;>*]:border [&amp;>*]:border-solid">
                <td class="px-2 py-3 whitespace-nowrap font-medium">USER</td>
                <td class="px-2 py-3 whitespace-nowrap">
                    <div class="form-check d-flex justify-content-center cursor-pointer"><input
                        class="form-check-input cursor-pointer" type="checkbox" id="defaultCheck1"></div>
                </td>
                <td class="px-2 py-3 whitespace-nowrap">
                    <div class="form-check d-flex justify-content-center cursor-pointer"><input
                        class="form-check-input cursor-pointer" type="checkbox" id="defaultCheck1"></div>
                </td>
                <td class="px-2 py-3 whitespace-nowrap">
                    <div class="form-check d-flex justify-content-center cursor-pointer"><input
                        class="form-check-input cursor-pointer" type="checkbox" id="defaultCheck1"></div>
                </td>
                <td class="px-2 py-3 whitespace-nowrap">
                    <div class="form-check d-flex justify-content-center cursor-pointer"><input
                        class="form-check-input cursor-pointer" type="checkbox" id="defaultCheck1"></div>
                </td>
            </tr>
            <tr class="[&amp;>*]:border [&amp;>*]:border-solid">
                <td class="px-2 py-3 whitespace-nowrap font-medium">TEAM</td>
                <td class="px-2 py-3 whitespace-nowrap">
                    <div class="form-check d-flex justify-content-center cursor-pointer"><input
                        class="form-check-input cursor-pointer" type="checkbox" id="defaultCheck1"></div>
                </td>
                <td class="px-2 py-3 whitespace-nowrap">
                    <div class="form-check d-flex justify-content-center cursor-pointer"><input
                        class="form-check-input cursor-pointer" type="checkbox" id="defaultCheck1"></div>
                </td>
                <td class="px-2 py-3 whitespace-nowrap">
                    <div class="form-check d-flex justify-content-center cursor-pointer"><input
                        class="form-check-input cursor-pointer" type="checkbox" id="defaultCheck1"></div>
                </td>
                <td class="px-2 py-3 whitespace-nowrap">
                    <div class="form-check d-flex justify-content-center cursor-pointer"><input
                        class="form-check-input cursor-pointer" type="checkbox" id="defaultCheck1"></div>
                </td>
            </tr>
            <tr class="[&amp;>*]:border [&amp;>*]:border-solid">
                <td class="px-2 py-3 whitespace-nowrap font-medium">PROJECT</td>
                <td class="px-2 py-3 whitespace-nowrap">
                    <div class="form-check d-flex justify-content-center cursor-pointer"><input
                        class="form-check-input cursor-pointer" type="checkbox" id="defaultCheck1"></div>
                </td>
                <td class="px-2 py-3 whitespace-nowrap">
                    <div class="form-check d-flex justify-content-center cursor-pointer"><input
                        class="form-check-input cursor-pointer" type="checkbox" id="defaultCheck1"></div>
                </td>
                <td class="px-2 py-3 whitespace-nowrap">
                    <div class="form-check d-flex justify-content-center cursor-pointer"><input
                        class="form-check-input cursor-pointer" type="checkbox" id="defaultCheck1"></div>
                </td>
                <td class="px-2 py-3 whitespace-nowrap">
                    <div class="form-check d-flex justify-content-center cursor-pointer"><input
                        class="form-check-input cursor-pointer" type="checkbox" id="defaultCheck1"></div>
                </td>
            </tr>
            <tr class="[&amp;>*]:border [&amp;>*]:border-solid">
                <td class="px-2 py-3 whitespace-nowrap font-medium">TASK</td>
                <td class="px-2 py-3 whitespace-nowrap">
                    <div class="form-check d-flex justify-content-center cursor-pointer"><input
                        class="form-check-input cursor-pointer" type="checkbox" id="defaultCheck1"></div>
                </td>
                <td class="px-2 py-3 whitespace-nowrap">
                    <div class="form-check d-flex justify-content-center cursor-pointer"><input
                        class="form-check-input cursor-pointer" type="checkbox" id="defaultCheck1"></div>
                </td>
                <td class="px-2 py-3 whitespace-nowrap">
                    <div class="form-check d-flex justify-content-center cursor-pointer"><input
                        class="form-check-input cursor-pointer" type="checkbox" id="defaultCheck1"></div>
                </td>
                <td class="px-2 py-3 whitespace-nowrap">
                    <div class="form-check d-flex justify-content-center cursor-pointer"><input
                        class="form-check-input cursor-pointer" type="checkbox" id="defaultCheck1"></div>
                </td>
            </tr>
            <tr class="[&amp;>*]:border [&amp;>*]:border-solid">
                <td class="px-2 py-3 whitespace-nowrap font-medium">COMMENT</td>
                <td class="px-2 py-3 whitespace-nowrap">
                    <div class="form-check d-flex justify-content-center cursor-pointer"><input
                        class="form-check-input cursor-pointer" type="checkbox" id="defaultCheck1"></div>
                </td>
                <td class="px-2 py-3 whitespace-nowrap">
                    <div class="form-check d-flex justify-content-center cursor-pointer"><input
                        class="form-check-input cursor-pointer" type="checkbox" id="defaultCheck1"></div>
                </td>
                <td class="px-2 py-3 whitespace-nowrap">
                    <div class="form-check d-flex justify-content-center cursor-pointer"><input
                        class="form-check-input cursor-pointer" type="checkbox" id="defaultCheck1"></div>
                </td>
                <td class="px-2 py-3 whitespace-nowrap">
                    <div class="form-check d-flex justify-content-center cursor-pointer"><input
                        class="form-check-input cursor-pointer" type="checkbox" id="defaultCheck1"></div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<style scoped>
/*display: none;*/
/*}*/

/*td {*/
/*    display: grid;*/
/*    gap: 0.5rem;*/
/*    grid-template-columns: 15ch auto;*/
/*    padding: 0.5rem 1rem;*/
/*}*/

/*td:first-child {*/
/*    padding-top: 2rem;*/
/*}*/

/*td:last-child {*/
/*    padding-bottom: 2rem;*/
/*}*/

/*td::before {*/
/*    content: attr(data-cell) ": ";*/
/*    font-weight: 700;*/
/*    text-transform: capitalize;*/
/*}*/

/*tbody tr:hover {*/
/*    background-color: none;*/
/*}th {*/

</style>
