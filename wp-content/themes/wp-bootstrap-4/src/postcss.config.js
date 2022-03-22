const tailwindcss = require('tailwindcss')
const autoprefixer = require('autoprefixer')
const purgecss = require('@fullhuman/postcss-purgecss')

const getPurgeConfig = () => {
    return {
        content: [
            '../**/*.php',
            './vue/**/*.vue',
            './vue/**/*.js',
            './css/**/*.scss',
        ],
        whitelistPatterns: [
            /^_Icon-/,
            /^_Button--/,
            /^_Alert--/,
            /^/
        ],
        defaultExtractor: content => content.match(/[\w-/:]+(?<!:)/g) || []
    }
}

module.exports = () => {
    const isProduction = process.env.npm_lifecycle_script === 'encore production'

    return {
        plugins: [
            tailwindcss(),
            autoprefixer(),
            ...(isProduction ? [purgecss(getPurgeConfig())] : [])
        ]
    }
}
