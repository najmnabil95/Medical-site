document.addEventListener('DOMContentLoaded', function () {
    // Set animation delays for department cards
    document.querySelectorAll('.department-card').forEach(function (card) {
        var delay = card.getAttribute('data-delay');
        if (delay) {
            card.style.animationDelay = delay + 'ms';
        }
    });

    // Set animation delays for doctor cards
    document.querySelectorAll('.doctor-card').forEach(function (card) {
        var delay = card.getAttribute('data-delay');
        if (delay) {
            card.style.animationDelay = delay + 'ms';
        }
    });

    function openDeptModal(id) {
        var modal = document.getElementById('dept-modal-' + id);
        if (modal) {
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        }
    }

    function closeDeptModal(id) {
        var modal = document.getElementById('dept-modal-' + id);
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }
    }

    // Expose functions globally for inline onclick handlers in blade
    window.openDeptModal = openDeptModal;
    window.closeDeptModal = closeDeptModal;

    // Event delegation: click on department card opens modal
    document.addEventListener('click', function (e) {
        var card = e.target.closest('.department-card');
        if (card) {
            var id = card.getAttribute('data-dept-id');
            if (id) {
                openDeptModal(id);
                return;
            }
        }

        // Click on close button or overlay closes modal
        var closeBtn = e.target.closest('[data-close-modal]');
        if (closeBtn) {
            var id = closeBtn.getAttribute('data-close-modal');
            if (id) {
                closeDeptModal(id);
                return;
            }
        }

        // Click on doctor card navigates to /doctors
        var docCard = e.target.closest('.doctor-card');
        if (docCard) {
            var href = docCard.getAttribute('data-href');
            if (href) {
                window.location.href = href;
                return;
            }
        }

        // Click on book appointment button
        var bookBtn = e.target.closest('.book-appointment-btn');
        if (bookBtn) {
            var deptName = bookBtn.getAttribute('data-book-dept');
            var docName = bookBtn.getAttribute('data-book-doc') || '';
            if (typeof window.prefillAppointment === 'function') {
                window.prefillAppointment(deptName, docName);
            }
            return;
        }
    });

    // Close modal on Escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('[id^="dept-modal-"]').forEach(function (modal) {
                if (!modal.classList.contains('hidden')) {
                    modal.classList.add('hidden');
                    document.body.style.overflow = '';
                }
            });
        }
    });
});
