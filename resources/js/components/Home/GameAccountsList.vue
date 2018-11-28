<template>
    <section class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col my-2">
        <resource-table
                v-if="currentUser"
                :fields="tableFields"
                ref="gameAccountsTable"
                :filters="{ player_id: currentUser.id }"
                resource="GameAccounts"
                :searchable="false"
        ></resource-table>
    </section>
</template>

<script>
    import ResourceTable from "../ResourceTable";
    import {mapGetters} from 'vuex';

    export default {
        name: "game-accounts-list",
        components: {ResourceTable},

        computed: {
            ...mapGetters([
                'currentUser'
            ]),

            tableFields() {
                return [
                    {
                        name: 'Account',
                        attribute: 'account.name'
                    },
                    {
                        name: 'Realm',
                        attribute: 'realm.name',
                    },
                    {
                        name: 'Address',
                        attribute: 'realm.address'
                    }
                ];
            }
        },
    }
</script>
