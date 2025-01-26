<script setup lang="ts">
import Navbar from '~/components/global/Navbar.vue';
import type Sidebar from '~/components/global/Sidebar.vue';
import { useSidebarStore } from '~/stores/sidebarStore';

const store = useSidebarStore();
const { isSidebarActive } = storeToRefs(store);
</script>

<template>
    <div class="dark:bg-neutral-800 bg-neutral-100 dark:text-white">
        <Sidebar />
        <main class="dashboard-main" :class="{ active: isSidebarActive }">
            <Navbar />
            <div class="dashboard-main-body">
                <NuxtPage />
            </div>
        </main>
    </div>
</template>