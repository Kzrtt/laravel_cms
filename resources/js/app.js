window.addEventListener('alert', function(event) {
    console.log(event.detail);
    Swal.fire(event.detail);
});