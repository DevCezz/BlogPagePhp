<?php
    session_start();
    require('inc/header.inc.php');
    require('inc/menu.inc.php');
?>

<div class="container">
    <div class="container" style="margin-top:40px">
        <div class="row">
            <div class="col-sm-6 col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>Załóż konto:</strong>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="processCreateUser.php" onsubmit="return validateRegisterForm(this)" method="post" >
                            <fieldset>
                                <div class="row">
                                    <div class="col-sm-12 col-md-10  col-md-offset-1 ">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="glyphicon glyphicon-user"></i>
                                                </span>
                                                <input class="form-control" placeholder="Nazwa użytkownika" name="userName" id="polelogin" type="text" autofocus>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="glyphicon glyphicon-lock"></i>
                                                </span>
                                                <input class="form-control" placeholder="Hasło" name="password" type="password" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="glyphicon glyphicon-lock"></i>
                                                </span>
                                                <input class="form-control" placeholder="Powtórz hasło"  type="password" name="passwordRepeat" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="glyphicon glyphicon-envelope"></i>
                                                </span>
                                                <input class="form-control" placeholder="Email" type="text" name="email" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                                <span class="text-danger" id="errorMessage"></span>
                                        </div>
                                        <input type="submit" class="btn btn-primary btn-block" value="Utwórz konto">
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
        require('inc/sign.inc.php');
    ?>
</div>

<?php
    require('inc/footer.inc.php');
?>