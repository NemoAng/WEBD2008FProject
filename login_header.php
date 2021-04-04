<?php if ($user_logined) : ?>
    <h3 id="welcome">Welcome <span><?= $_SESSION['username'] ?></span> !</h3>
    <form action="#" method="post">
        <div class="adm">
            <input type="submit" name="logoff" value="Log Off" />
        </div>
    </form>
<?php else : ?>
    <div class="adm"><button onclick="location.href='./user_login.php';">User Login</button></div>
    <div class="adm"><button onclick="location.href='./user_register.php';">User Register</button></div>
<?php endif ?>