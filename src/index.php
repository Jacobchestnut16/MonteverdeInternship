<?php

if (isset($_GET['navWindow'])) {
    $navWindow = $_GET['navWindow'];
}

?>
<table>
    <tr>
        <td>
            <a href="/?navWindow=addWorker.html">Add Worker</a>
            <a href="/?navWindow=prereq/register.html">Sign up</a>
            <a href="/?navWindow=login.html">Login</a>
        </td>
    </tr>
</table>

<iframe src="<?= $navWindow ?>" frameborder="1" width="100%" height="90%"></iframe>