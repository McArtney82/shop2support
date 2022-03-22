<template>
    <div class="o-col-12 sm:o-col-6 lg:o-col-4 xl:o-col-3">
        <div class="_h-full _flex _flex-col _relative _shadow-sm _bg-white _rounded-md _border">
            <div class="_px-6 _pt-6 _flex-1">
                <div v-if="offer.category"
                     @click.prevent.stop="setCategory"
                     :title="offer.category.name"
                     :style="{borderTopColor: offer.category.color, borderRightColor: offer.category.color, borderLeftColor: 'transparent', borderBottomColor: 'transparent'}"
                     class="_absolute _top-0 _right-0 _border-r-64 _border-b-128 _rounded-tr-md _cursor-pointer _filter hover:_grayscale">
                    <i class="_absolute _top-8 _left-8 _transform _-translate-y-1/2"
                       :class="`fas fa-${offer.category.icon} _text-white`"></i>
                </div>
                <div v-if="offer.image.url">
                    <img :src="offer.image.url"
                         :alt="offer.image.alt"
                         class="_h-20 _max-w-half"
                    />
                </div>
                <div class="_mt-4 _mb-6">
                    <h3 class="_text-lg _font-bold _text-gray-700 _mb-0 _leading-tight" v-if="offer.name">
                        {{ offer.name }}
                    </h3>
                    <span class="_block _text-xs _font-bold _text-primary-500 _mb-4">
                  {{ offer.shortText }}
                </span>
                    <p class="_text-sm _text-gray-700 _mb-0">
                        {{ offer.description }}
                    </p>
                </div>
            </div>
            <div class="_flex _border-t _px-6 _py-4">
                <button class="_Button _Button--outline _mr-2"
                        data-tippy
                        @click.stop.prevent="toggleFavourite"
                        @mouseenter="isHoveringStart = true"
                        @mouseleave="isHoveringStart = false"
                        type="button">
                    <i class="fa-star _text-yellow-500"
                       :class="isHoveringStart || offer.isFavourite ? 'fas' : 'far'">
                    </i>
                </button>
                <a :href="offer.url"
                   target="_blank"
                   class="_Button _Button--outline--primary _w-full">
                    Shop now
                </a>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, toRefs, onMounted, computed, reactive } from 'vue'
import { useStore } from 'vuex'
import tippy from 'tippy.js'
import { handleErrors, req } from '@/common/methods'
import { DISPATCH_CATEGORY, GET_CATEGORY, IS_FAVOURITES } from '@/store/types'

export default {
    name: 'OfferCard',
    props: {
        offer: Object,
        userId: Number|null
    },
    setup (props) {
        const routes = {
            toggleFavourite: '/wp-json/custom/v1/favourites'
        }
        const isHoveringStart = ref(false)
        const { offer, userId } = toRefs(props)

        const store = useStore()

        const args = reactive({
            favouritesOnly: computed(() => store.getters['offers/' + IS_FAVOURITES]),
            category: computed(() => store.getters['offers/' + GET_CATEGORY])
        })

        onMounted(() => {
            tippy('[data-tippy]', {
                duration: 0,
                content: 'Favourite',
            })
        })

        function setCategory () {
            if (!args.category.hasOwnProperty('id') || offer.value.category.id !== args.category.id) {
                store.dispatch(`offers/${DISPATCH_CATEGORY}`, offer.value.category)
            }
        }

        function toggleFavourite () {
            if (document.body.classList.contains('logged-in')) {
                req.post(routes.toggleFavourite, { user_id: userId.value, offer_id: offer.value.id })
                    .then(handleErrors)
                    .then((res) => {
                        offer.value.isFavourite = !offer.value.isFavourite
                    })
                    .catch(error => error)

                return
            }

            jQuery('#login-modal').modal('show')
        }

        return {
            args,
            isHoveringStart,
            toggleFavourite,
            setCategory,
        }
    },
}
</script>