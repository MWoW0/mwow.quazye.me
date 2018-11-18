<template>
    <section class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col my-2">
        <resource-table
            v-if="currentUser"
            resource="lifts"
            :fields="['emulator', 'realm', 'address']"
            :filters="{ player_id: currentUser.id }"
            ref="liftsTable"
        ></resource-table>
    </section>
</template>

<script>
    import ResourceTable from "../ResourceTable";
    export default {
        name: "game-accounts-list",
        components: {ResourceTable}
    }
</script>
