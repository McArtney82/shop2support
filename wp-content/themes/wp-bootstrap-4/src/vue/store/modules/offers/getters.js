import { GET_CATEGORY, GET_RESULTS, GET_SEARCH, GET_SORT, IS_FAVOURITES } from '@/store/types'

export default {
    /**
     *
     * @param state
     * @returns {*}
     */
    [GET_CATEGORY]: state => state.category,

    /**
     *
     * @param state
     */
    [GET_SEARCH]: state => state.search,

    /**
     *
     * @param state
     */
    [GET_SORT]: state => state.sort,

    /**
     *
     * @param state
     */
    [IS_FAVOURITES]: state => state.isFavourites,

    /**
     *
     * @param state
     */
    [GET_RESULTS]: state => state.results,
}
