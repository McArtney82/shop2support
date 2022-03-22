const colors = require('tailwindcss/colors')

/**
 * @see https://github.com/tailwindlabs/tailwindcss/blob/master/stubs/defaultConfig.stub.js
 */
module.exports = {
    screens: {
        xs: '420px',
        sm: '576px',
        md: '768px',
        lg: '992px',
        xl: '1200px',
    },
    extend: {
        maxWidth: (theme) => ({
            ...theme('spacing'),
            'screen-2xl': 1536,
            'half': '50%',
        }),
        maxHeight: (theme) => ({
            ...theme('spacing'),
        }),
        minWidth: (theme) => ({
            ...theme('spacing'),
        }),
        lineHeight: (theme) => ({
            ...theme('spacing'),
            0: 0,
        }),
        inset: {
            '1/2': '50%',
            initial: 'initial'
        },
        colors: {
            gray: colors.blueGray,
            primary: {
                100: '#CCE1F7',
                200: '#99C3F0',
                300: '#66A5E8',
                400: '#3387E1',
                500: '#2586bb',
                600: '#0054AE',
                700: '#003F82',
                800: '#002A57',
                900: '#00152B',
            },
        },
        borderWidth: {
            128: '128px',
            64: '64px',
        },
        cursor: {
            help: 'help',
        },
    },
}
