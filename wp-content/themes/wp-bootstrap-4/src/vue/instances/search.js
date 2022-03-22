import { createApp, h } from 'vue'
import store from '@/store'
import Search from '@/modules/Search/Search'
import { vmSearch } from '@/selectors'

export default () => {
    if (!vmSearch) {
        return
    }
    const { placeholder } = vmSearch.dataset

    const app = createApp({
        render: () => h(Search, {
            placeholder
        }),
    })

    app.use(store)
    app.mount(vmSearch)
}