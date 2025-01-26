export default defineNuxtRouteMiddleware((to, from) => {
    // Ambil token dari sessionStorage
    const token = sessionStorage.getItem('auth_token')
  
    // Jika token tidak ada dan pengguna bukan di halaman auth, arahkan ke auth
    if (!token && to.path !== '/auth') {
      return navigateTo('/auth')
    }
  
    // Jika pengguna sudah auth dan mencoba mengakses auth, arahkan ke dashboard
    if (token && to.path === '/auth') {
      return navigateTo('/dashboard')
    }
  })
  