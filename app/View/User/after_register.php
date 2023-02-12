<section class="vh-100" style="background-color: #eee;">
    <div class="container vh-100">
        <div class="row vh-100 d-flex justify-content-center align-items-center">
            <div class="col-sm-10 col-md-6">
                <div class="card text-black p-5">
                    <div class="card-body">
                        <h4 class="card-text">Hi, <?=$_GET["n"]??"";?></h4>
                        <p class="card-text"><?=$model["message"]??"";?></p>
                        <button type="button" class="btn btn-outline-primary"
                        onclick="window.location.href='/users/login'">Let's login</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
