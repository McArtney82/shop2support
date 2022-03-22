<template>
    <div class="_left-8 _right-8 _absolute _top-full md:_left-1/2 md:_right-initial _transform _-translate-y-1/2 md:_-translate-x-1/2 _z-10 md:_w-full _max-w-2xl">
        <span class="_h-full _absolute _left-4 _text-gray-500 _flex _items-center _justify-center">
            <i class="fa-search fas"></i>
        </span>
        <input type="search"
               v-model="searchQuery"
               :placeholder="placeholder"
               class="_bg-white _rounded-xl _h-16 _shadow-md _pl-12 _text-gray-500 _w-full"
        />
    </div>
</template>

<script>
import { ref, watch } from 'vue'
import { useStore } from 'vuex'
import { DISPATCH_SEARCH } from '@/store/types'
import eventBus from '@/common/event-bus'
import { RESET_STATE } from '@/common/types'

export default {
    name: 'Search',
    props: {
        placeholder: String,
    },
    setup () {
        const searchQuery = ref('')
        const store = useStore()

        watch(searchQuery, (x) => {
            store.dispatch('offers/' + DISPATCH_SEARCH, x)
        })

        eventBus.on(RESET_STATE, () => {
            searchQuery.value = ''
        })

        return {
            searchQuery,
        }
    },
}
</script>