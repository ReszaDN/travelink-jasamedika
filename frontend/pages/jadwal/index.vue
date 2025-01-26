<template>
    <h3>Master Jadwal</h3>
    <fwb-button @click="showModal">Tambah Data</fwb-button>
    <fwb-table>
      <fwb-table-head>
        <fwb-table-head-cell>No</fwb-table-head-cell>
        <fwb-table-head-cell>Tanggal Berangkat</fwb-table-head-cell>
        <fwb-table-head-cell>Rute</fwb-table-head-cell>
        <fwb-table-head-cell>Harga/kursi</fwb-table-head-cell>
        <fwb-table-head-cell>Kapasitas</fwb-table-head-cell>
        <fwb-table-head-cell>No. Kendaraan</fwb-table-head-cell>
        <fwb-table-head-cell>#</fwb-table-head-cell>
      </fwb-table-head>
      <fwb-table-body>
        <fwb-table-row v-for="(list, index) in listJadwal">
          <fwb-table-cell>{{ index + 1 }}</fwb-table-cell>
          <fwb-table-cell>{{ list.tgl_keberangkatan }}</fwb-table-cell>
          <fwb-table-cell>{{ list.rute }}</fwb-table-cell>
          <fwb-table-cell>{{ list.harga }}</fwb-table-cell>
          <fwb-table-cell>{{ list.kuota }}</fwb-table-cell>
          <fwb-table-cell>{{ list.no_kendaraan }}</fwb-table-cell>
          <fwb-table-cell>
            <fwb-button style="background: red;" @click="hapusJadwal(list.norec_jadwal)">Hapus</fwb-button>
          </fwb-table-cell>
        </fwb-table-row>
      </fwb-table-body>
    </fwb-table>



    <fwb-modal v-if="isShowModal" @close="closeModal">
      <template #header>
        <div class="flex items-center text-lg">
          Tambah Jadwal
        </div>
      </template>
      <template #body>
        <label for="datetime" class="block text-sm font-medium text-gray-700" style="color: white">
             Pilih Tanggal Keberangkatan
        </label>
        <input type="date" style="color: black" v-model="tglKeberangkatan" label="Kota" placeholder="enter your name" size="sm">
        <fwb-input v-model="harga" label="Harga" placeholder="enter your name" size="sm" />
        <fwb-input v-model="kuota" label="Kuota" placeholder="enter your name" size="sm" />
        <fwb-select v-model="rute" :options="listRute" label="Rute Perjalanan"/>
        <fwb-select v-model="kendaraan" :options="listKendaraan" label="Kendaraan"/>
      </template>
      <template #footer>
        <div class="flex justify-between">
          <fwb-button @click="addJadwal" color="green">
            I accept
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
    FwbInput,
  } from 'flowbite-vue'
  import { fetch } from "~/utils/fetchWrapper";
  import { ref } from "vue";

  const listJadwal = ref([]);
  const listRute = ref([]);
  const listKendaraan = ref([]);

  const formattedTglKeberangkatan = computed(() => {
  if (!tglKeberangkatan.value) return ""; // Jika kosong, kembalikan string kosong
  const date = new Date(tglKeberangkatan.value);
  return date.toISOString().split("T")[0]; // Format yyyy-mm-dd
  });

  const tglKeberangkatan = ref("");
  const harga = ref("");
  const kuota = ref("");
  const rute = ref("");
  const kendaraan = ref("");

  onMounted(()=> {
    //   console.log(import.meta.env.VITE_BASE_URL) //Pemanggilan API
    getJadwal();
    getRute();
    getKendaraan();
  })

  function getJadwal(){
      fetch.get(import.meta.env.VITE_BASE_URL + '/get-jadwal').then((response)=> {
        console.log(response)
        listJadwal.value = response.data.jadwal
      })
  }


  function getRute() {
  fetch
    .get(import.meta.env.VITE_BASE_URL + '/get-rute')
    .then((response) => {
      console.log(response);
      listRute.value = response.data.rute.map((rute) => ({
        value: rute.norec_rute, 
        name: rute.ruteTujuan,
      }));
      console.log(listRute.value, "LIST KOTA COMBOBOX")
    })
    .catch((error) => {
      console.error("Error fetching kota data:", error);
    });
  }

  function getKendaraan() {
  fetch
    .get(import.meta.env.VITE_BASE_URL + '/get-kendaraan')
    .then((response) => {
      console.log(response);
      listKendaraan.value = response.data.kendaraan.map((kendaraan) => ({
        value: kendaraan.uuid, 
        name: kendaraan.no_kendaraan,
      }));
      console.log(listKendaraan.value, "LIST KOTA COMBOBOX")
    })
    .catch((error) => {
      console.error("Error fetching kota data:", error);
    });
  }


  async function addJadwal() {
  try {
    const payload = {
      tgl_keberangkatan: formattedTglKeberangkatan.value, // Tanggal keberangkatan dalam format yyyy-mm-dd
      harga: harga.value,
      kuota: kuota.value,
      id_rute: rute.value, // Selected value
      id_kendaraan: kendaraan.value, // Selected value
    };

    const response = await fetch.post(import.meta.env.VITE_BASE_URL + '/add-jadwal', payload);

    if (response.success) {
      // Jika berhasil, tampilkan notifikasi atau pesan sukses
      // alert("Data rute berhasil ditambahkan!");
      closeModal(); // Tutup modal
      getJadwal(); // Refresh data rute setelah penambahan
    } else {
      alert("Gagal menambahkan data jadwal.");
    }
  } catch (error) {
    console.error("Error:", error);
    alert("Terjadi kesalahan saat menyimpan data.");
  }
}

async function hapusJadwal(uuidJadwal) {
  try {
    // Payload hanya berisi uuid yang diklik
    const payload = { uuid: uuidJadwal }; 

    // Mengirimkan POST request untuk mengubah status kota di backend
    const response = await fetch.post(`${import.meta.env.VITE_BASE_URL}/delete-jadwal`, payload);

    // if (response.success) {
     getJadwal(); // Refresh data kota setelah penghapusan
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