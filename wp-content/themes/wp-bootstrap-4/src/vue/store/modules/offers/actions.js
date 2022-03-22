import eventBus from '@/common/event-bus'
import {
    DISPATCH_CATEGORY,
    DISPATCH_FAVOURITES, DISPATCH_RESULTS,
    DISPATCH_SEARCH, RESET_ALL,
    SET_CATEGORY,
    SET_FAVOURITES,
    SET_RESULTS,
    SET_SEARCH,
} from '@/store/types'
import { RESET_STATE } from '@/common/types'

export default {
    /**
     *
     * @param commit
     * @param payload
     */
    [DISPATCH_CATEGORY] ({ commit }, payload) {
        commit(SET_CATEGORY, payload)
    },

    /**
     *
     * @param commit
     * @param payload
     */
    [DISPATCH_SEARCH] ({ commit }, payload) {
        commit(SET_SEARCH, payload)
    },

    /**
     *
     * @param commit
     * @param payload
     */
    [DISPATCH_FAVOURITES] ({ commit }, payload) {
        commit(SET_FAVOURITES, payload)
    },

    /**
     *
     * @param commit
     * @param payload
     */
    [DISPATCH_RESULTS] ({ commit }, payload) {
        commit(SET_RESULTS, payload)
    },

    /**
     *
     * @param commit
     */
    [RESET_ALL] ({ commit }) {
        commit(SET_RESULTS, [])
        commit(SET_SEARCH, '')
        commit(SET_FAVOURITES, false)
        commit(SET_CATEGORY, [])
        eventBus.emit(RESET_STATE)
    },
}
