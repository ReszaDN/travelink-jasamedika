<template>
    <h3>Master Kota</h3>
    <fwb-button @click="showModal">Tambah Data Kota</fwb-button>
    <fwb-table>
      <fwb-table-head>
        <fwb-table-head-cell>No</fwb-table-head-cell>
        <fwb-table-head-cell>Kota</fwb-table-head-cell>
        <fwb-table-head-cell>#</fwb-table-head-cell>
      </fwb-table-head>
      <fwb-table-body>
        <fwb-table-row v-for="(list, index) in listKota">
          <fwb-table-cell>{{ index + 1 }}</fwb-table-cell>
          <fwb-table-cell>{{ list.nama_kota }}</fwb-table-cell>
          <fwb-table-cell>
            <fwb-button style="background: red;" @click="hapusKota(list.uuid)">Hapus</fwb-button>
          </fwb-table-cell>
        </fwb-table-row>
      </fwb-table-body>
    </fwb-table>

    <template>
      
    </template>
    <div style="align-items: center;">
      <fwb-modal v-if="isShowModal" @close="closeModal" class="max-w-2xl" position="center">
        <template #header>
          <div class="flex items-center text-lg">
            Tamabah Data Kota
          </div>
        </template>
        <template #body>
          <fwb-input v-model="namaKota" label="Kota" placeholder="enter your name" size="sm" />
        </template>
        <template #footer>
          <div class="flex justify-between">
            <fwb-button @click="tambahKota" color="green">
              Simpan
            </fwb-button>
          </div>
        </template>
      </fwb-modal>
    </div>
      
  </template>
  
  <script setup>
  import {
    FwbA,
    FwbTable,
    FwbTableBody,
    FwbTableCell,
    FwbTableHead,
    FwbTableHeadCell,
    FwbTableRow,
    FwbButton,
    FwbModal,
    FwbInput, 
  } from 'flowbite-vue'
  import { fetch } from "~/utils/fetchWrapper";
  import {ref} from "vue";
  

  const listKota = ref([]);
  const namaKota = ref("");

  onMounted(()=> {
    //   console.log(import.meta.env.VITE_BASE_URL) //Pemanggilan API
    getKota()
  })

  function getKota(){
      fetch.get(import.meta.env.VITE_BASE_URL + '/get-kota').then((response)=> {
        console.log(response)
        listKota.value = response.data.kota
      })
  }

  async function tambahKota() {
  try {
    const payload = {
      nama_kota: namaKota.value, // Properti yang dikirim ke server
    };

    const response = await fetch.post(import.meta.env.VITE_BASE_URL + '/add-kota', payload);

    if (response.success) {
      // alert("Data kota berhasil ditambahkan!");
      closeModal(); // Tutup modal
      getKota(); // Refresh data kota setelah penambahan
    } else {
      alert("Gagal menambahkan data kota.");
    }
  } catch (error) {
    console.error("Error:", error);
    alert("Terjadi kesalahan saat menyimpan data.");
  }
}

async function hapusKota(uuidKota) {
  try {
    // Payload hanya berisi uuid yang diklik
    const payload = { uuid: uuidKota }; 

    // Mengirimkan POST request untuk mengubah status kota di backend
    const response = await fetch.post(`${import.meta.env.VITE_BASE_URL}/delete-kota`, payload);

    // if (response.success) {
      getKota(); // Refresh data kota setelah penghapusan
    // } else {
      // alert("Gagal menghapus data kota.");
    // }
  } catch (error) {
    console.error("Error:", error);
    alert("Terjadi kesalahan saat menghapus data.");
  }
}



const isShowModal = ref(false)

function closeModal () {
  isShowModal.value = false
}
function showModal () {
  isShowModal.value = true
}



  </script>