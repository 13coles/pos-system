<?php if (isset($_SESSION['success']) || isset($_SESSION['error']) || isset($_SESSION['info']) || isset($_SESSION['warning'])): ?>
    <div class="d-flex justify-content-center" style="position: fixed; top: 20px; right: 20px; z-index: 1050;">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show mr-2" role="alert" id="success-alert" style="width: auto;">
                <i class="fas fa-check-circle"></i> 
                <?php echo $_SESSION['success']; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show mr-2" role="alert" id="error-alert" style="width: auto;">
                <i class="fas fa-exclamation-triangle"></i> 
                <?php echo $_SESSION['error']; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['info'])): ?>
            <div class="alert alert-info alert-dismissible fade show mr-2" role="alert" id="info-alert" style="width: auto;">
                <i class="fas fa-info-circle"></i>
                <?php echo $_SESSION['info']; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php unset($_SESSION['info']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['warning'])): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert" id="warning-alert" style="width: auto;">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo $_SESSION['warning']; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php unset($_SESSION['warning']); ?>
        <?php endif; ?>
    </div>
<?php endif; ?>


<script>
    // Function to automatically close alerts after a specified duration
    function autoCloseAlert(alertId, duration) {
        setTimeout(function() {
            var alertElement = document.getElementById(alertId);
            if (alertElement) {
                alertElement.classList.remove('show');
                alertElement.classList.add('fade');
            }
        }, duration);
    }

    // Set the duration for alerts (in milliseconds)
    var duration = 3000; // 3 seconds

    // Automatically close the success alert if it exists
    if (document.getElementById('success-alert')) {
        autoCloseAlert('success-alert', duration);
    }

    // Automatically close the error alert if it exists
    if (document.getElementById('error-alert')) {
        autoCloseAlert('error-alert', duration);
    }

    // Automatically close the info alert if it exists
    if (document.getElementById('info-alert')) {
        autoCloseAlert('info-alert', duration);
    }

    // Automatically close the warning alert if it exists
    if (document.getElementById('warning-alert')) {
        autoCloseAlert('warning-alert', duration);
    }
</script>
