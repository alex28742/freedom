<h2>Авторизация</h2>

<div class="row">
    <div class="col-md-4">
        <? if(isset($_SESSION['success'])):?>
            <div class="alert alert-success">
                <?=$_SESSION['success']; unset($_SESSION['success']); ?>

            </div>
        <? endif; ?>
        <? if(isset($_SESSION['errors'])):?>
            <div class="alert alert-warning">
                <?=$_SESSION['errors']; unset($_SESSION['errors']); ?>
            </div>
        <? endif; ?>
        <form method="post" action="/user/login">
            <div class="mb-3">
                <label for="login" class="form-label">Login</label>
                <input type="text" name="login" class="form-control" id="login" value="<?=$login;?>">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password">
            </div>
            <button type="submit" class="btn btn-primary">Вход</button>
        </form>
    </div>
</div>
