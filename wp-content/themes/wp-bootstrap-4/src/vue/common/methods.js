/**
 *
 * @param res
 * @returns {*}
 */
export const handleErrors = (res) => {
    if (res.ok) {
        return res.json()
    }
    return res.json().then(error => Promise.reject(error))
}

/**
 *
 * @param route
 * @param input
 * @returns {Promise<Response>}
 */
export const postReq = async (route, input) => {
    return await fetch(route, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Cache-Control': 'no-cache',
        },
        body: JSON.stringify(input),
    })
}

const _getInit = () => {
    return {
        headers: {
            'Content-Type': 'application/json',
            'Cache-Control': 'no-cache',
        },
    }
}

export const req = {
    async get (route) {
        return await fetch(route, {
            method: 'GET',
            ..._getInit(),
        })
    },
    async post (route, input) {
        return await fetch(route, {
            method: 'POST',
            body: JSON.stringify(input),
            ..._getInit(),
        })
    },
}