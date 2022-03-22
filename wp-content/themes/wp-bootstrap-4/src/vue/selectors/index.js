/**
 *
 * @param id
 * @returns {HTMLElement}
 */
const getVm = (id) => {
    return document.getElementById(id)
}

export const vmSearch = getVm('vm-search')
export const vmOffers = getVm('vm-offers')