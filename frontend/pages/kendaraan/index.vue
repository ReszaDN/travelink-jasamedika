<template>
    <h3>Master Kendaraan</h3>
    <fwb-button @click="showModal">Tambah Data Kendaraan</fwb-button>
    <fwb-table>
      <fwb-table-head>
        <fwb-table-head-cell>No</fwb-table-head-cell>
        <fwb-table-head-cell>Kode Kendaraan</fwb-table-head-cell>
        <fwb-table-head-cell>No Kendaraan</fwb-table-head-cell>
        <fwb-table-head-cell>#</fwb-table-head-cell>
      </fwb-table-head>
      <fwb-table-body>
        <fwb-table-row v-for="(list, index) in listKendaraan">
          <fwb-table-cell>{{ index + 1 }}</fwb-table-cell>
          <fwb-table-cell>{{ list.kode_kendaraan }}</fwb-table-cell>
          <fwb-table-cell>{{ list.no_kendaraan }}</fwb-table-cell>
          <fwb-table-cell>
            <fwb-button style="background: red;" @click="hapusKendaraan(list.uuid)">Hapus</fwb-button>
          </fwb-table-cell>
        </fwb-table-row>
      </fwb-table-body>
    </fwb-table>



    <fwb-modal v-if="isShowModal" @close="closeModal">
      <template #header>
        <div class="flex items-center text-lg">
          Terms of Service
        </div>
      </template>
      <template #body>
        <fwb-input v-model="kdKendaraan" label="Kode Kendaraan" placeholder="Kode Kendaraan" size="sm" />
        <fwb-input v-model="noKendaraan" label="No Kendaraan" placeholder="No Kendaraan" size="sm" />
      </template>
      <template #footer>
        <div class="flex justify-between">
          <fwb-button @click="tambahKendaraan" color="green">
            Simpan
          </fwb-button>
        </div>
      </template>
    </fwb-modal>
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

  const kdKendaraan = ref("");
  const noKendaraan = ref("");
  

  const listKendaraan = ref([])

  onMounted(()=> {
    //   console.log(import.meta.env.VITE_BASE_URL) //Pemanggilan API
    getKendaraan()
  })

  function getKendaraan(){
      fetch.get(import.meta.env.VITE_BASE_URL + '/get-kendaraan').then((response)=> {
        console.log(response)
        listKendaraan.value = response.data.kendaraan
      })
  }

  async function tambahKendaraan() {
  try {
    // Validasi input
    if (!kdKendaraan.value || !noKendaraan.value) {
      alert("Kode kendaraan dan nomor kendaraan harus diisi.");
      return;
    }

    const payload = {
      kode_kendaraan: kdKendaraan.value,
      no_kendaraan: noKendaraan.value,
    };

    console.log("Sending payload:", payload); // Debug payload

    const response = await fetch.post(import.meta.env.VITE_BASE_URL + '/add-kendaraan', payload);

    console.log("Response from server:", response); // Debug response

    if (response.success) {
      // alert("Data kendaraan berhasil ditambahkan!");
      closeModal(); // Tutup modal
      getKendaraan(); // Refresh data kendaraan
    } else {
      alert("Gagal menambahkan data kendaraan.");
    }
  } catch (error) {
    console.error("Error:", error);
    alert("Terjadi kesalahan saat menyimpan data.");
  }
}

async function hapusKendaraan(uuidKendaraan) {
  try {
    // Payload hanya berisi uuid yang diklik
    const payload = { uuid: uuidKendaraan }; 

    // Mengirimkan POST request untuk mengubah status kota di backend
    const response = await fetch.post(`${import.meta.env.VITE_BASE_URL}/delete-kendaraan`, payload);

    // if (response.success) {
      getKendaraan(); // Refresh data kota setelah penghapusan
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