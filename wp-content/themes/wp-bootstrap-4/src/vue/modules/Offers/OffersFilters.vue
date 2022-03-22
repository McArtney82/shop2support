<template>
    <div class="_flex _flex-col sm:_flex-row sm:_items-end sm:_justify-between _py-4 _mb-4 _border-b">
        <div v-if="isLoggedIn" class="_flex _items-center sm:_order-1 _mb-6 sm:_mb-0">
            <span class="_font-medium _text-gray-800 _mr-4">
                Show favourites only
            </span>
            <ui-toggle :active="args.favouritesOnly"
                       @update="setFavourites"
                       sr="Favourites only?"
            />
        </div>
        <div>
            <select class="js-example-basic-single _w-80">
                <option value="" selected disabled>
                    Search a category
                </option>
                <option v-for="category in categories"
                        :value="category.id">
                    {{ category.name }}
                </option>
            </select>
            <div v-if="args.category.id" class="_mt-4">
                <span @click="resetCategory"
                      class="_Badge _cursor-pointer">
                    {{ args.category.name }}
                    <i class="fa-times fas"></i>
                </span>
            </div>
        </div>
    </div>
</template>

<script>
import { reactive, ref, toRefs, computed, onMounted, watch } from 'vue'
import { useStore } from 'vuex'
import { DISPATCH_FAVOURITES, DISPATCH_CATEGORY, GET_CATEGORY, IS_FAVOURITES } from '@/store/types'
import { UiToggle } from '@/components/Ui'

export default {
    name: 'OffersFilters',
    components: {
        UiToggle,
    },
    props: {
        isLoggedIn: Boolean,
        categories: Object,
    },
    setup (props) {
        const store = useStore()
        const item = ref('')

        const { categories } = toRefs(props)

        const options = [{ country: 'Canada', code: 'CA' }]

        const args = reactive({
            favouritesOnly: computed(() => store.getters['offers/' + IS_FAVOURITES]),
            category: computed(() => store.getters['offers/' + GET_CATEGORY])
        })

        onMounted(() => {
            jQuery(document).ready(function () {
                jQuery('.js-example-basic-single').select2()

                jQuery('.js-example-basic-single').on('select2:select', function (e) {
                    setCategory({
                        id: e.target.value,
                        name: Object.values(categories.value).find(x => {
                            return x.id == e.target.value
                        }).name
                    })
                })
            })
        })

        watch(() => args.category, (x) => {
            jQuery('.js-example-basic-single').val(x.id)
            jQuery('.js-example-basic-single').trigger('change')
        })

        function resetCategory () {
            store.dispatch('offers/' + DISPATCH_CATEGORY, [])
        }

        function setFavourites (e) {
            store.dispatch(`offers/${DISPATCH_FAVOURITES}`, e)
        }

        function setCategory (category) {
            store.dispatch(`offers/${DISPATCH_CATEGORY}`, category)
        }

        return {
            args,
            item,
            options,
            resetCategory,
            setFavourites,
        }
    },
}
</script>