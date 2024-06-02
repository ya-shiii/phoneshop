<?php
// Start the session
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session
session_destroy();

?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        title: "Access Granted",
        text: "In",
        icon: "error"
    }).then(function() {
        window.location = "Login.php";
    });
</script>
<?php

header("Location: Login.php");
exit();
?>
