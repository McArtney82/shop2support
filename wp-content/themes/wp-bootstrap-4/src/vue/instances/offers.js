import { createApp, h } from 'vue'
import store from '@/store'
import OffersLayout from '@/modules/Offers/OffersLayout'
import { vmOffers } from '@/selectors'

export default () => {
    if (!vmOffers) {
        return
    }
    const { postId, userId } = vmOffers.dataset
    const categories = JSON.parse(vmOffers.dataset.categories)

    const app = createApp({
        render: () => h(OffersLayout, {
            userId,
            postId,
            categories,
        }),
    })

    app.use(store)
    app.mount(vmOffers)
}