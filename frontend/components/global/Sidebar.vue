<script lang="ts" setup>
import { Title } from '#build/components';
import { useSidebarStore } from '~/stores/sidebarStore';

const store = useSidebarStore();
const { isSidebarActive } = storeToRefs(store);

// Menus
const menus = ref([
  {
    title: 'Dashboard',
    url: '/dashboard',
    icon: 'solar:home-smile-angle-outline',
    dropdown: false,
  },
  {
    title: 'Managemen Master',
    icon: 'material-symbols-light:co-present-outline-sharp',
    dropdown: true,
    children: [
      {
        title: 'Master Kota',
        url: '/kota',
        icon: 'material-symbols-light:10k-sharp',
      },
      {
        title: 'Master Kendaraan',
        url: '/kendaraan',
        icon: 'flowbite:clock-outline',
      },
      {
        title: 'Master Rute',
        url: '/rute',
        icon: 'flowbite:clock-outline',
      },
      {
        title: 'Master Jadwal',
        url: '/jadwal',
        icon: 'flowbite:clock-outline',
      },
    ]
  },
  {
    title: 'Pelaporan',
    icon: 'material-symbols-light:co-present-outline-sharp',
    dropdown: true,
    children: [
      {
        title: 'Laporan Riwayat Penumpang',
        url: '/kota',
        icon: 'material-symbols-light:10k-sharp',
      },
      {
        title: 'Laporan Pemesan',
        url: '/kendaraan',
        icon: 'flowbite:clock-outline',
      }
    ]
  },
  {
    title: 'List Pesanan',
    url: '/pesananlist',
    icon: 'solar:home-smile-angle-outline',
    dropdown: false,
  }
])
</script>

<template>
  <aside class="sidebar" :class="{ active: isSidebarActive }">
    <button type="button" class="sidebar-close-btn">
      <Icon mode="svg" name="radix-icons:cross-2"></Icon>
    </button>
    <div>
      <a href="index.html" class="sidebar-logo">
        <img src="/assets/images/logo.png" alt="site logo" class="light-logo" />
        <img
          src="/assets/images/logo-light.png"
          alt="site logo"
          class="dark-logo"
        />
        <img
          src="/assets/images/logo-icon.png"
          alt="site logo"
          class="logo-icon"
        />
      </a>
    </div>
    <div class="sidebar-menu-area">
      <ul class="sidebar-menu" id="sidebar-menu">
        <li
          :class="{dropdown: menu.dropdown}"
          v-for="(menu, index) in menus"
          :key="index"
          @click="store.toggleDropdown($event.target.closest('.dropdown'))"
        >
          <a :href="menu.url || 'javascript:void(0)'">
            <Icon mode="svg" :name="menu.icon" class="menu-icon" />
            <span>{{ menu.title }}</span>
          </a>

          <!-- Submenu -->
          <ul class="sidebar-submenu" v-if="menu.dropdown">
            <li v-for="(submenu, subIndex) in menu.children" :key="subIndex">
              <a :href="submenu.url">
                <Icon mode="svg" :name="submenu.icon" class="menu-icon" />
                {{ submenu.title }}
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </aside>
</template>
