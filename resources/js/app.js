window.addEventListener('alert', function(event) {
    console.log(event.detail);
    Swal.fire({
        ...event.detail,
        scrollbarPadding: false, // desativa o ajuste de padding na scrollbar
        target: document.body,
    });
});