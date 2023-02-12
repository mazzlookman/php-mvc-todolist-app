<section class="vh-100" style="background-color: #eee;">
    <div class="container vh-100">
        <div class="row vh-100 d-flex justify-content-center align-items-center">
            <div class="col-md-8 col-sm-10">
                <div class="card text-black p-1">
                    <div class="card-body">
                        <div class="text-center fs-4 mb-2">Register Here</div>
                        <?php if (isset($model["error"])):?>
                            <div class="alert alert-danger" role="alert">
                                <?=$model["error"]??"";?>
                            </div>
                        <?php endif; ?>
                        <form action="" method="post" autocomplete="off">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" id="name" value=<?=$_POST["name"]??"";?>>
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" id="username" value=<?=$_POST["username"]??"";?>>
                            </div>
                            <div class="mb-2">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" id="myPassword">
                            </div>
                            <div class="mb-3">
                                <input type="checkbox" onclick="myFunction()"> Show Password
                            </div>
                            <button type="submit" class="btn btn-primary">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    function myFunction(){
        var x = document.getElementById("myPassword");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>