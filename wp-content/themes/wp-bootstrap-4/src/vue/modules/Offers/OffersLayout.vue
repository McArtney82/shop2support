<template>
    <div v-if="isLoaded" class="_py-8 _px-4 _max-w-screen-2xl _mx-auto">
        <offers-filters :is-logged-in="userId !== 0"
                        :categories="categories"
        />
        <div v-if="args.results.length" class="o-grid o-grid--tighter">
            <template v-for="result in args.results">
                <offer-card :offer="result" :userId="userId"/>
            </template>
        </div>
        <div v-else class="_text-center _py-8">
            <img :src="noResultImg" alt="No result" width="100">
            <span class="_block _mt-8 _mb-2 _font-medium">
            No result matches your criterias
        </span>
            <a href="javascript:void(0)" @click="resetFilters">
                Reset filters
            </a>
        </div>
    </div>
    <div v-if="isLoading"
        class="_p-8 _text-center _flex _items-center _justify-center">
        <i class="fa-spinner fas _animate-spin"></i>
        <span class="_font-bold _text-xs _text-gray-700 _ml-4">
            Loading results...
        </span>
    </div>
</template>

<script>
import { reactive, ref, toRefs, onMounted, computed, watch } from 'vue'
import { useStore } from 'vuex'
import { debounce } from 'lodash-es'
import noResultImg from '@/../assets/no-result.svg'
import OfferCard from '@/modules/Offers/Card/OfferCard'
import OffersFilters from '@/modules/Offers/OffersFilters'
import { useLoading } from '@/composables'
import { handleErrors, req } from '@/common/methods'
import { DISPATCH_RESULTS, GET_CATEGORY, GET_RESULTS, GET_SEARCH, IS_FAVOURITES, RESET_ALL } from '@/store/types'

export default {
    name: 'OffersLayout',
    components: {
        OffersFilters,
        OfferCard,
    },
    props: {
        userId: Number,
        postId: String,
        categories: Object,
    },
    setup (props) {
        const routes = {
            get: '/wp-json/custom/v1/offers'
        }

        const { userId, postId } = toRefs(props)
        const isLoaded = ref(false)

        const store = useStore()
        const args = reactive({
            offset: 0,
            total: 0,
            perPage: 10,
            search: computed(() => store.getters['offers/' + GET_SEARCH]),
            results: computed(() => store.getters['offers/' + GET_RESULTS]),
            favouritesOnly: computed(() => store.getters['offers/' + IS_FAVOURITES]),
            category: computed(() => store.getters['offers/' + GET_CATEGORY])
        })

        const { load, isLoading } = useLoading()

        watch(() => args.category, () => {
            reset()
            loadMore(true)
        })

        watch(() => args.favouritesOnly, () => {
            reset()
            loadMore(true)
        })

        watch(() => args.search, () => {
            reset()
            loadMore(true)
        })

        onMounted(() => {
            load(fetchOffers).then(({ results }) => {
                store.dispatch('offers/' + DISPATCH_RESULTS, results)
                isLoaded.value = true

                window.addEventListener('scroll', debounce(() => {
                    console.log(window.innerHeight + window.scrollY)
                    console.log(document.body.offsetHeight - 1500)
                    if ((window.innerHeight + window.scrollY) >= (document.body.offsetHeight - 1500)) {
                        loadMore()
                    }
                }, 500, { leading: true }))
            })
        })

        function reset () {
            args.offset = 0
            args.perPage = 10
        }

        function fetchOffers () {
            let route = `${routes.get}?post_id=${postId.value}&offset=${args.offset}&per_page=${args.perPage}`

            if (args.category.id) {
                route += `&category=${args.category.id}`
            }

            if (userId.value) {
                route += `&user_id=${userId.value}`
            }

            if (args.favouritesOnly) {
                route += `&favourites=true`
            }

            if (args.search) {
                route += `&search=${args.search}`
            }

            return req.get(route)
                .then(handleErrors)
                .then(res => {
                    args.total = res.total
                    args.offset += args.perPage
                    return res
                })
                .catch(error => error)
        }

        function resetFilters () {
            store.dispatch('offers/' + RESET_ALL)
        }

        /**
         *
         * @param erase
         */
        function loadMore (erase) {
            if (!erase && args.results.length >= args.total) {
                return
            }
            load(fetchOffers).then(({ results }) => {
                if (erase) {
                    store.dispatch('offers/' + DISPATCH_RESULTS, results)
                    return
                }
                store.dispatch('offers/' + DISPATCH_RESULTS, [
                    ...args.results,
                    ...results
                ])
            })
        }

        return {
            noResultImg,
            isLoading,
            args,
            isLoaded,
            loadMore,
            resetFilters,
        }
    },
}
</script>