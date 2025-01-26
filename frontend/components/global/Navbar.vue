<script setup lang="ts">
import { useSidebarStore } from "~/stores/sidebarStore";
import { FwbDropdown, FwbListGroup, FwbListGroupItem } from "flowbite-vue";
import { useRouter } from 'vue-router'

const router = useRouter()

const { toggleSidebar, toggleTheme } = useSidebarStore();
const { isDarkTheme } = storeToRefs(useSidebarStore());

function logout() {
  // Hapus token dari sessionStorage
  sessionStorage.removeItem('auth_token')

  // Redirect ke halaman login
  router.push('/login')
}
</script>

<template>
  <div
    class="navbar-header border-b border-neutral-200 dark:border-neutral-600"
  >
    <div class="flex items-center justify-between">
      <div class="col-auto">
        <div class="flex flex-wrap items-center gap-[16px]">
          <button type="button" class="sidebar-toggle" @click="toggleSidebar">
            <Icon name="heroicons:bars-3-solid" class="icon non-active"></Icon>
            <Icon name="iconoir:arrow-right" class="icon active"></Icon>
          </button>
          <button type="button" class="sidebar-mobile-toggle">
            <Icon name="heroicons:bars-3-solid" class="icon"></Icon>
          </button>
          <form class="navbar-search">
            <input type="text" name="search" placeholder="Search" />
            <Icon name="ion:search-outline" class="icon"></Icon>
          </form>

          <!-- <span class="max-w-[244px] w-full p-6 h-3 bg-red-600 text-white flex items-center justify-center rounded-[50px]">tesdgxt</span> -->
        </div>
      </div>
      <div class="col-auto">
        <div class="flex flex-wrap items-center gap-3">
          <button
            type="button"
            id="theme-toggle"
            class="w-10 h-10 bg-neutral-200 dark:bg-neutral-700 dark:text-white rounded-full flex justify-center items-center"
            @click="toggleTheme"
          >
            <span id="theme-toggle-dark-icon" v-if="!isDarkTheme">
              <Icon
                name="solar:sun-outline"
                class="text-neutral-900 dark:text-white text-xl"
              ></Icon>
            </span>
            <span id="theme-toggle-light-icon" v-else>
              <Icon
                name="majesticons:moon-line"
                class="text-neutral-900 dark:text-white text-xl"
              ></Icon>
            </span>
          </button>

          <!-- Message Dropdown Start  -->
          <button
            data-dropdown-toggle="dropdownMessage"
            class="has-indicator w-10 h-10 bg-neutral-200 dark:bg-neutral-700 rounded-full flex justify-center items-center"
            type="button"
          >
            <Icon
              name="mage:email"
              class="text-neutral-900 dark:text-white text-xl"
            ></Icon>
          </button>
          <!-- Message Dropdown End  -->

          <!-- Notification Start  -->
          <button
            data-dropdown-toggle="dropdownNotification"
            class="has-indicator w-10 h-10 bg-neutral-200 dark:bg-neutral-700 rounded-full flex justify-center items-center"
            type="button"
          >
            <Icon
              name="iconoir:bell"
              class="text-neutral-900 dark:text-white text-xl"
            ></Icon>
          </button>
          <!-- Notification End  -->

          <fwb-dropdown align-to-end close-inside>
            <template #trigger>
              <img
                src="/assets/images/user.png"
                alt="image"
                class="w-10 h-10 object-fit-cover rounded-full"
              />
            </template>
            <fwb-list-group>
              <fwb-list-group-item>
                <div
                  class="py-3 px-4 rounded-lg bg-primary-50 dark:bg-primary-600/25 mb-4 flex items-center justify-between gap-2"
                >
                  <div>
                    <p class="text-lg text-neutral-900 font-semibold mb-0">
                      Administrator
                    </p>
                    <span class="text-neutral-500">Admin</span>
                  </div>
                  <!-- <button type="button" class="hover:text-danger-600">
            <Icon name="radix-icons:cross-1" class="icon text-xl"></Icon>
          </button> -->
                </div>
              </fwb-list-group-item>
              <fwb-list-group-item>
                <a
                  class="text-black px-0 py-2 hover:text-primary-600 flex items-center gap-4"
                  href="view-profile.html"
                >
                  <Icon name="solar:user-linear" class="icon text-xl"></Icon>
                  My Profile</a
                >
              </fwb-list-group-item>
              <fwb-list-group-item>
                <a
                  class="text-black px-0 py-2 hover:text-primary-600 flex items-center gap-4"
                  href="company.html"
                >
                  <Icon
                    name="icon-park-outline:setting-two"
                    class="icon text-xl"
                  ></Icon>
                  Setting</a
                >
              </fwb-list-group-item>
              <fwb-list-group-item>
                <a
                  class="text-black px-0 py-2 hover:text-danger-600 flex items-center gap-4 cursor-pointer"
                  @click="logout"
                >
                  <Icon name="lucide:power" class="icon text-xl"></Icon>
                  Log Out</a
                >
              </fwb-list-group-item>
            </fwb-list-group>
          </fwb-dropdown>
        </div>
      </div>
    </div>
  </div>
</template>
