<br>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="form-wrapper">
                <form method="POST" action="/user/signup">
                    <? if(isset($_SESSION['errors'])): ?>
                    <div class="alert alert-danger">
                        <? echo $_SESSION['errors'];  unset($_SESSION['errors']); ?>
                    </div>
                    <? endif; ?>
                    <? if(isset($_SESSION['success'])): ?>
                        <div class="alert alert-success">
                            <? echo $_SESSION['success'];  unset($_SESSION['success']); ?>
                        </div>
                    <? endif; ?>
                    <div class="errors"></div>
                    <input class="form-control" type="text" name="login" placeholder="login" value="<? if(isset($data['login'])):?><?=$data['login'];?><?endif;?>">
                    <br>

                    <input class="form-control" type="text" name="name" placeholder="name" value="<? if(isset($data['name'])):?><?=$data['name'];?><?endif;?>">
                    <br>

                    <input class="form-control" type="text" name="email" placeholder="e-mail" value="<? if(isset($data['email'])):?><?=$data['email'];?><?endif;?>">
                    <br>

                    <input class="form-control" type="password" name="password" placeholder="password">
                    <br>
                    <input class="btn btn-primary" type="submit" value="send">
                </form>
            </div>
        </div>

    </div>
</div>

