document.addEventListener('DOMContentLoaded', function() {
    // Admin-specific JavaScript can go here
    // For example, handling product image previews

    const imageInputs = document.querySelectorAll('input[type="file"]');

    imageInputs.forEach(input => {
        input.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const preview = document.createElement('img');
                    preview.src = e.target.result;
                    preview.width = 100;
                    preview.className = 'image-preview';

                    const currentImage = input.previousElementSibling;
                    if (currentImage && currentImage.classList.contains('current-image')) {
                        currentImage.parentNode.replaceChild(preview, currentImage);
                    } else {
                        input.parentNode.insertBefore(preview, input);
                    }
                };

                reader.readAsDataURL(file);
            }
        });
    });
});
