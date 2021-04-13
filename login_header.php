<?php if ($user_logined) : ?>
    <h3 id="welcome">Welcome <a href="./profile_edit.php" target="_blank"><span><?= $_SESSION['username'] ?></span> ! <span><img src="images-upload/<?= $_SESSION['username'] . '_profile.jpg' ?>" width="45px" height="45px" id="profile"></span></a></h3>
    <form action="#" method="post">
        <div class="adm">
            <input type="submit" name="logoff" value="Log Off" />
        </div>
    </form>
<?php else : ?>
    <div class="adm"><button onclick="location.href='./user_login.php';">User Login</button></div>
    <div class="adm"><button onclick="location.href='./user_register.php';">User Register</button></div>
<?php endif ?>