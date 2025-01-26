export const fetch = {
    post: async <T = any>(url: string, data: any, options: any = {}): Promise<T> => {
        const { $api } = useNuxtApp();
        return $api<T>(url, {
            method: "POST",
            body: data,
            ...options,
        });
    },

    get: async <T = any>(url: string, options: any = {}): Promise<T> => {
        const { $api } = useNuxtApp();
        return $api<T>(url, {
            method: "GET",
            ...options,
        });
    },

    put: async <T = any>(url: string, data: any, options: any = {}): Promise<T> => {
        const { $api } = useNuxtApp();
        return $api<T>(url, {
            method: "PUT",
            body: data,
            ...options,
        });
    },

    delete: async <T = any>(url: string, options: any = {}): Promise<T> => {
        const { $api } = useNuxtApp();
        return $api<T>(url, {
            method: "DELETE",
            ...options,
        });
    },
};
