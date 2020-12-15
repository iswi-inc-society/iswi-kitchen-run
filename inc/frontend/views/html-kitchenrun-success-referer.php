<?php
/**
 * View to refer back to the success page after a successful login.
 *
 * @since   1.0.0
 *
 * @author  Niklas Loos <niklas.loos@live.com>
 */
?>

<script type="text/javascript">
    if (window.location.search === "") {
        document.location.href= window.location.href + "?success=1";
    } else {
        document.location.href= window.location.href + "&success=1";
    }

</script>