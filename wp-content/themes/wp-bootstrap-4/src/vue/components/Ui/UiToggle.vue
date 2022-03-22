<template>
    <button type="button"
            @click="update"
            :class="{'_bg-primary-500': active, '_bg-gray-200': !active}"
            class="_relative _p-0 _inline-flex _flex-shrink-0 _h-6 _w-11 _border-2 _border-transparent _rounded-full _cursor-pointer _transition-colors _ease-in-out _duration-200 focus:_outline-none focus:_ring-2 focus:_ring-offset-2 focus:_ring-indigo-500">
        <span class="_sr-only">
            {{ sr }}
        </span>
        <span
            :class="{'_translate-x-5': active, '_translate-x-0': !active}"
            class="_relative _inline-block _h-5 _w-5 _rounded-full _bg-white _shadow _transform _ring-0 _transition _ease-in-out _duration-200">
        <span
            :class="{'_opacity-0 _ease-out _duration-100': active, '_opacity-100 _ease-in _duration-200': !active}"
            class="_absolute _inset-0 _h-full _w-full _flex _items-center _justify-center _transition-opacity"
            :aria-hidden="active">
          <svg class="_h-3 _w-3 _text-gray-400" fill="none" viewBox="0 0 12 12">
            <path d="M4 8l2-2m0 0l2-2M6 6L4 4m2 2l2 2" stroke="currentColor"
                  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </span>
        <span
            :class="{'_opacity-100 _ease-in _duration-200': active, '_opacity-0 _ease-out _duration-100': !active}"
            class="_absolute _inset-0 _h-full _w-full _flex _items-center _justify-center _transition-opacity"
            :aria-hidden="!active">
          <svg class="_h-3 _w-3 _text-indigo-600" fill="currentColor" viewBox="0 0 12 12">
            <path
                d="M3.707 5.293a1 1 0 00-1.414 1.414l1.414-1.414zM5 8l-.707.707a1 1 0 001.414 0L5 8zm4.707-3.293a1 1 0 00-1.414-1.414l1.414 1.414zm-7.414 2l2 2 1.414-1.414-2-2-1.414 1.414zm3.414 2l4-4-1.414-1.414-4 4 1.414 1.414z"/>
          </svg>
        </span>
      </span>
    </button>
</template>

<script>
export default {
    name: 'UiToggle',
    props: {
        active: {
            type: Boolean,
            default: false,
        },
        sr: String,
    },
    emits: [
        'update:active',
        'update',
    ],
    setup: (props, { emit }) => ({
        update: () => {
            emit('update:active', !props.active)
            emit('update', !props.active) // Handle case where the Toggle is inside v-for loop
        },
    }),
}
</script>