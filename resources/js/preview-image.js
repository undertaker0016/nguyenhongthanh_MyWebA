document.addEventListener('DOMContentLoaded', () => {
    const input = document.querySelector('#image');
    const preview = document.querySelector('.preview-image');

    if (input && preview) {
        input.addEventListener('change', function () {
            const file = this.files[0];

            if (file) {
                preview.src = URL.createObjectURL(file);
            }
        });
    }
});