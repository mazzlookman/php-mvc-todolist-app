 <section id="loginPage"">
        <div class="container position-absolute top-50 start-50 translate-middle">
            <div class="row justify-content-center">
                <div class=" col-sm-12 col-md-6">
                    <div class="card text-bg-light p-2">
                            <div class="card-body">
                                <div class="text-center fs-4 mb-2">Login Here</div>
                                <?php if (isset($model["error"])):?>
                                    <div class="alert alert-danger" role="alert">
                                        <?=$model["error"]??"";?>
                                    </div>
                                <?php endif; ?>
                                <form action="" method="post" autocomplete="off">
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" name="username" id="username" value=<?=$_POST["username"]??"";?>>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password" id="password">
                                    </div>
                                    <button type="submit" class="btn btn-primary me-2">Come in</button>
                                    <a href="/users/register">I'm don't have an account</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
