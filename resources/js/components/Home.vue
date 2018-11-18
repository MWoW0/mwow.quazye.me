<template>
    <div class="font-sans antialiased h-screen" id="home">
        <!-- Sidebar -->
        <div class="bg-grey-lightest relative h-full min-h-screen">
            <div class="xl:py-2">

                <!-- Dashboard -->
                <div class="group relative sidebar-item">
                    <router-link exact :to="{ name: 'home.dashboard' }" class="block xl:flex xl:items-center text-center xl:text-left shadow-light xl:shadow-none py-6 xl:py-2 xl:px-4 hover:bg-blue-lighter">
                        <font-awesome-icon icon="tachometer" class="h-6 w-6 text-grey-darker fill-current xl:mr-2"></font-awesome-icon>
                        <div class="text-grey-darker text-xs">{{ __('Dashboard') }}</div>
                    </router-link>
                </div>

                <!-- User details -->
                <div class="group relative sidebar-item">
                    <router-link exact :to="{ name: 'home.user.details' }" class="block xl:flex xl:items-center text-center xl:text-left shadow-light xl:shadow-none py-6 xl:py-2 xl:px-4 hover:bg-blue-lighter">
                        <font-awesome-icon icon="user" class="h-6 w-6 text-grey-darker fill-current xl:mr-2"></font-awesome-icon>
                        <div class="text-grey-darker text-xs">{{ __('User details') }}</div>
                    </router-link>
                </div>

                <!-- Game accounts -->
                <div class="group relative sidebar-item">
                    <router-link exact :to="{ name: 'home.game-accounts.list' }" class="block xl:flex xl:items-center text-center xl:text-left shadow-light xl:shadow-none py-6 xl:py-2 xl:px-4 hover:bg-blue-lighter">
                        <font-awesome-icon icon="user" class="h-6 w-6 text-grey-darker fill-current xl:mr-2"></font-awesome-icon>
                        <div class="text-grey-darker text-xs">{{ __('Game accounts') }}</div>
                    </router-link>
                </div>

                <!-- Notifications -->
                <div class="group relative sidebar-item">
                    <router-link exact :to="{ name: 'home.notifications' }" class="block xl:flex xl:items-center text-center xl:text-left shadow-light xl:shadow-none py-6 xl:py-2 xl:px-4 hover:bg-blue-lighter">
                        <font-awesome-icon icon="comments" class="h-6 w-6 text-grey-darker fill-current xl:mr-2"></font-awesome-icon>
                        <div class="text-grey-darker text-xs">{{ __('Notifications') }}</div>
                    </router-link>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="flex items-center">
            <div class="w-full h-full mx-auto">
                <div class="rounded">
                    <div class="p-3 rounded-b">
                        <transition name="fade">
                            <router-view></router-view>
                        </transition>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Heading from "./Typography/Heading";
    export default {
        components: {Heading}

        //
    };
</script>
