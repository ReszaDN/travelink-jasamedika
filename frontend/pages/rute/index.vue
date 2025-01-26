<template>
    <h3>Master Rute Keberangkatan dan Tujuan</h3>
    <fwb-button @click="showModal">Tambah Rute</fwb-button>
    <fwb-table>
      <fwb-table-head>
        <fwb-table-head-cell>No</fwb-table-head-cell>
        <fwb-table-head-cell>Kota Keberangkatan</fwb-table-head-cell>
        <fwb-table-head-cell>Kota Tujuan</fwb-table-head-cell>
        <fwb-table-head-cell>#</fwb-table-head-cell>
      </fwb-table-head>
      <fwb-table-body>
        <fwb-table-row v-for="(list, index) in listRute">
          <fwb-table-cell>{{ index + 1 }}</fwb-table-cell>
          <fwb-table-cell>{{ list.keberangkatan }}</fwb-table-cell>
          <fwb-table-cell>{{ list.tujuan }}</fwb-table-cell>
          <fwb-table-cell>
            <fwb-button style="background: red;" @click="hapusRute(list.norec_rute)">Hapus</fwb-button>
          </fwb-table-cell>
        </fwb-table-row>
      </fwb-table-body>
    </fwb-table>



    <fwb-modal v-if="isShowModal" @close="closeModal">
      <template #header>
        <div class="flex items-center text-lg">
          Tambah Data Rute
        </div>
      </template>
      <template #body>
        <fwb-select v-model="selectedKeberangkatan" :options="listKota" label="Kota Keberangkatan"/>
        <fwb-select v-model="selectedTujuan" :options="listKota" label="Kota Tujuan"/>
      </template>
      <template #footer>
        <div class="flex justify-between">
          <fwb-button @click="tambahRute" color="green">
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
    FwbSelect,
  } from 'flowbite-vue'
  import { fetch } from "~/utils/fetchWrapper";
  import {ref} from "vue";

  
  const listRute = ref([]);
  const listKota = ref([]);
  const selectedKeberangkatan = ref("");
  const selectedTujuan = ref("");

  onMounted(()=> {
    //   console.log(import.meta.env.VITE_BASE_URL) //Pemanggilan API
    getRute();
    getKota();
    console.log(listKota);
  })

  function getKota() {
  fetch
    .get(import.meta.env.VITE_BASE_URL + '/get-kota')
    .then((response) => {
      console.log(response);
      listKota.value = response.data.kota.map((kota) => ({
        value: kota.uuid, 
        name: kota.nama_kota,
      }));
      console.log(listKota.value, "LIST KOTA COMBOBOX")
    })
    .catch((error) => {
      console.error("Error fetching kota data:", error);
    });
  }

   function getRute(){
      fetch.get(import.meta.env.VITE_BASE_URL + '/get-rute').then((response)=> {
        console.log(response)
        listRute.value = response.data.rute
      })
   }

   async function tambahRute() {
  try {
    // Pastikan keberangkatan dan tujuan telah dipilih
    if (!selectedKeberangkatan.value || !selectedTujuan.value) {
      console.error("Keberangkatan dan tujuan harus dipilih");
      return;
    }

    // Siapkan payload untuk pengiriman data
    const payload = {
      keberangkatan: selectedKeberangkatan.value,
      tujuan: selectedTujuan.value,
    };

    // Kirim request POST untuk menambah rute
    const response = await fetch.post(
      `${import.meta.env.VITE_BASE_URL}/add-rute`,
      payload
    );

    // Cek apakah response sukses
    if (response.success) {
      // Tutup modal
      closeModal();
      // Refresh data rute setelah penambahan
      getRute();
    } else {
      // Menampilkan pesan jika gagal menambahkan rute
      alert("Gagal menambahkan data rute.");
    }
  } catch (error) {
    // Tangani error jika terjadi kesalahan pada request
    console.error("Error:", error);
    alert("Terjadi kesalahan saat menyimpan data.");
  }
}


async function hapusRute(uuidRute) {
  try {
    // Payload hanya berisi uuid yang diklik
    const payload = { uuid: uuidRute }; 

    // Mengirimkan POST request untuk mengubah status kota di backend
    const response = await fetch.post(`${import.meta.env.VITE_BASE_URL}/delete-rute`, payload);

    // if (response.success) {
    getRute(); // Refresh data kota setelah penghapusan
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