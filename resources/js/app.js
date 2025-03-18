import './bootstrap';

window.addEventListener('DOMContentLoaded', event => {
    // Simple-DataTables
    const datatablesSimple = document.getElementById('datatablesSimple');
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (datatablesSimple) {
        new simpleDatatables.DataTable(datatablesSimple);
    }

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

    $(document).on('change', '.change-status', function () {

        let orderId = $(this).data('order-id');
        let csrfToken = $('meta[name="csrf-token"]').attr('content');
        let newStatus = $(this).val();
        let selectElement = $(this); 

        console.log(newStatus);
        
        $.ajax({
            url: "/dashboard/update-status",
            method: "POST",
            data: {
                _token: csrfToken,
                order_id: orderId,
                status: newStatus
            },
            success: function (response) {
                if (response.success) {
                    alertToastr(response.message, 'success');

                    if (newStatus === 'completed' || newStatus === 'canceled') {
                        selectElement.prop('disabled', true); 
                    }

                    updateStatusBadge(orderId, newStatus);
                } else {
                    alertToastr(response.message, 'danger');
                }
            },
            error: function (xhr) {
                let errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Unknown error';
                alertToastr(errorMessage, 'error');
            }
        });
    });

    function updateStatusBadge(orderId, newStatus) {
        const statusClasses = {
            'pending': 'badge bg-warning text-dark',
            'confirmed': 'badge bg-primary',
            'completed': 'badge bg-success',
            'canceled': 'badge bg-danger'
        };

        let badge = $('.order-status-badge[data-order-id="' + orderId + '"]');

        if (badge.length) {

            badge.css({ 'opacity': 0, 'transition': 'none' });

            badge.removeClass().addClass(`order-status-badge ${statusClasses[newStatus] || 'badge bg-secondary'}`) ;

            badge.text(newStatus);

            badge.css('opacity', 0);
            setTimeout(() => {
                badge.css({
                    'transition': 'opacity 0.5s',
                    'opacity': 1
                });
            }, 100);

        }
    }
});
