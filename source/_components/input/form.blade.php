<form
    x-data="{
        form: {}, // For  binding inputs

        state: {
            success: false,
            exception: false,
            submitting: false,
        },

        submit() {
            this.state.submitting = true

            fetch($el.getAttribute('action'), {
                method: 'post',
                body: this.formData,
            })
            .then(() => this.handleSuccess())
            .catch(() => this.handleException())
        },

        handleSuccess() {
            this.state.success = true
            this.state.exception = false
            this.state.submitting = false
        },

        handleException() {
            this.state.exception = true
            this.state.success = false
            this.state.submitting = false
        },

        get formData() {
            let formData = new FormData()
            Object.keys(this.form).forEach(key => {
                formData.append(key, this.form[key])
            });

            return formData
        }
    }"
    x-on:submit.prevent="submit"

    {{ $attributes->merge([
        'accept-charset' => 'UTF-8',
        'enctype' => 'multipart/form-data',
        'method' => 'POST'
    ]) }}
>

    {{ $slot }}

</form>
