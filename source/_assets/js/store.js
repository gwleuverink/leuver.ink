document.addEventListener('alpine:init', () => {

    // Darkmode preference store
    Alpine.store('darkMode', {
        enabled: null,

        init() {
            this.enabled = this.determineInitialDarkModeState()

            // Detect dynamic OS color scheme change
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                this.enabled = e.matches
            });
        },

        determineInitialDarkModeState: function () {
            if (localStorage.getItem('dark-mode') === null) {
                // No preference set. Determine from OS color scheme
                return window.matchMedia('(prefers-color-scheme: dark)').matches
            }

            return localStorage.getItem('dark-mode') === 'true'
        },

        toggle() {
            this.enabled = !this.enabled

            // When toggling manually we store the preference in localStorage
            localStorage.setItem('dark-mode', this.enabled)
        },
    })
})
