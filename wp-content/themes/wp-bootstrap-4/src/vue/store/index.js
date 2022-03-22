import { createStore } from 'vuex'
import { OffersModule as offers } from './modules'

const strict = process.env.NODE_ENV !== 'production'

export default createStore({
    modules: {
        offers,
    },
    strict,
})
