document.addEventListener('alpine:init', () => {

    // Darkmode preference store
    Alpine.store('darkMode', {
        enabled: window.localStorage.getItem('dark-mode'),

        init() {
            // Default to system color scheme
            if (this.enabled === null) {
                this.set(window.matchMedia('(prefers-color-scheme: dark)').matches)
            }

            // Detect dynamic OS color scheme change
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                this.set(e.matches)
            });
        },

        set(value) {
            this.enabled = value
            window.localStorage.setItem('dark-mode', value)
        },

        toggle() {
            this.set(!this.enabled)
        },
    })
})
