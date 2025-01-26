export default defineNuxtPlugin(() => {
    const token = sessionStorage.getItem('auth_token')

    return {
        provide: {
            api: async <T>(url: string, options: any = {}): Promise<T> => {
                options.headers = options.headers || {}

                // Tambahkan token ke header Authorization jika ada
                if (token) {
                    options.headers.Authorization = `Bearer ${token}`
                }

                return await $fetch<T>(url, options)
            },
        },
    }
})
