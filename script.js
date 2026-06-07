document.addEventListener('DOMContentLoaded', function() {
    const deleteBtns = document.querySelectorAll('.delete-confirm');
    deleteBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            if(!confirm('Are you sure? This cannot be undone.')) {
                e.preventDefault();
            }
        });
    });
    const photoInput = document.getElementById('photo');
    if(photoInput) {
        photoInput.addEventListener('change', function(e) {
            const preview = document.getElementById('photo-preview');
            if(preview && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(ev) {
                    preview.src = ev.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    }
});