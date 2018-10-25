<?php

/*=====
    function: create_login: void -> void
    purpose: expects nothing, returns nothing, and has the side-effect
        of outputting to the resulting document an Oracle log-on form
        with method="post" and action equal to the calling PHP document

    requires: name-pwd-fieldset.html, 328footer.html
=====*/

function create_login()
{
    // create the desired Oracle log-in form
    ?>
        <form method="post"
              action="<?= htmlentities($_SERVER['PHP_SELF'], 
                                       ENT_QUOTES) ?>">      
        <?php
        require_once("name-pwd-fieldset.html");
        ?>
		<br />
            <input type="submit" value="login" />
        </form>
        <?php
}

?>

   

