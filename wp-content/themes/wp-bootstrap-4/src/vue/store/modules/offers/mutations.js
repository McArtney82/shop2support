import { SET_CATEGORY, SET_FAVOURITES, SET_RESULTS, SET_SEARCH, SET_SORT } from '@/store/types'

export default {
    /**
     *
     * @param state
     * @param payload
     */
    [SET_CATEGORY] (state, payload) {
        state.category = payload
    },

    /**
     *
     * @param state
     * @param payload
     */
    [SET_SEARCH] (state, payload) {
        state.search = payload
    },

    /**
     *
     * @param state
     * @param payload
     */
    [SET_FAVOURITES] (state, payload) {
        state.isFavourites = payload
    },

    /**
     *
     * @param state
     * @param payload
     */
    [SET_SORT] (state, payload) {
        state.sort = payload
    },

    /**
     *
     * @param state
     * @param payload
     */
    [SET_RESULTS] (state, payload) {
        state.results = payload
    },
}
