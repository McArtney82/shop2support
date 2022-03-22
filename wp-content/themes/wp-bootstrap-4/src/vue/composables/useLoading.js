import { ref } from 'vue'

export default function useLoading () {
    let isLoading = ref(false)

    /**
     *
     * @param callback
     * @returns {Promise<*>}
     */
    async function load (callback) {
        isLoading.value = true
        const res = await callback.apply(...arguments)
        isLoading.value = false
        return res
    }

    return {
        load,
        isLoading,
    }
}