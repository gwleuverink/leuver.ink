document.addEventListener('alpine:init', () => {

    // Darkmode preference store
    Alpine.store('darkMode', {
        enabled: null,

        init() {
            this.set(this.determineInitialDarkModeState())

            // Detect dynamic OS color scheme change
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                this.set(e.matches)
            });
        },

        set(value) {
            this.enabled = value

            // When toggling manually we store the preference in localStorage,
            // but only if the value is different from the OS color scheme
            // so it falls back to the OS default after a refresh
            if (this.operatingSystemInDarkMode() !== this.enabled) {
                localStorage.setItem('dark-mode', this.enabled)
            } else {
                localStorage.removeItem('dark-mode')
            }
        },

        toggle() {
            this.set(!this.enabled)
        },

        determineInitialDarkModeState: function () {
            if (localStorage.getItem('dark-mode') === null) {
                // No preference set. Determine from OS color scheme
                return this.operatingSystemInDarkMode()
            }

            return localStorage.getItem('dark-mode') === 'true'
        },

        operatingSystemInDarkMode() {
            return window.matchMedia('(prefers-color-scheme: dark)').matches
        }
    })
})
