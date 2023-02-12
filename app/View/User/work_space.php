<!--Input Todolist-->
<div class="container vh-100 p-3">
    <div class="row mb-2" style="height: 5%;">
        <div class="col text-end">
            <a href="/users/logout" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </div>
    <?php if (isset($model["error"])):?>
        <div class="order-1 alert alert-danger" role="alert">
            <?=$model["error"]??"";?>
        </div>
    <?php endif; ?>
    <div class="row" style="height: 95%;">
        <div class="col-md-4 mb-3 col-sm-12">
            <div class="card" style="width: 100%;">
                <div class="card-body">
                    <form method="post" autocomplete="off">
                        <div class="mb-3">
                            <label for="titleTodo">Title</label>
                            <input type="text" class="form-control" name="titleTodo" id="titleTodo">
                        </div>
                        <div class="mb-3">
                            <label for="contentTodo">Content</label>
                            <textarea class="form-control" name="contentTodo" id="contentTodo"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>
                        <button type="reset" class="btn btn-link">Reset</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8 rows-col-sm-12 h-100 overflow-y-auto">
            <?php
            $i = 1;
            if (isset($model["allTodoList"])):
                if ($model["allTodoList"] == null){
                    echo "<div class='card p-5 text-center'><p class='card-text fs-2'>Your todolist will appear here,<br>Let's create!</p></div>";
                }
                foreach ($model["allTodoList"] as $row):
                    ?>
                    <div class="card mb-2" style="width: 99%;">
                        <div class="card-body">
                            <h5 class="card-title"><?=$row['title']??''?></h5>
                            <p class="card-text"><?=$row['content']??'';?></p>
                            <a href="#" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalUpdate<?=$row['id']??'';?>">Edit</a>
                            <a href="#" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalDelete<?=$row['id']??'';?>">Delete</a><br>
                            <small class="card-subtitle mb-2 text-muted">Last updated: <?=$row['updated_at']??'';?></small>

                            <!--Start Modal Update -->
                            <div class="modal fade" id="modalUpdate<?=$row['id']??'';?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">New message</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" autocomplete="off">
                                                <input type="hidden" value="<?=$row['id']??'';?>" name="idTodo">
                                                <div class="mb-3">
                                                    <label for="recipient-name" class="col-form-label">Title:</label>
                                                    <input type="text" class="form-control" id="message-text" name="updateTitle" value="<?=$row["title"]??"";?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="message-text" class="col-form-label">Message:</label>
                                                    <textarea class="form-control" id="message-text" name="updateContent"><?=$row["content"]??"";?></textarea>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary" name="editTodoButton">Edit</button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--End Modal Update-->

                            <!--Start Modal Delete -->
                            <div class="modal fade" id="modalDelete<?=$row['id']??'';?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Deleting Confirmation</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" autocomplete="off">
                                                <input type="hidden" value="<?=$row['id']??'';?>" name="idTodo">
                                                <h5 class="text-center">Are you sure want to delete this todolist?<br>
                                                    <span class="text-danger">Title: <?=$row['title']??'';?></span>
                                                </h5>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary" name="deleteTodoButton">Yes</button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--End Modal Delete-->
                        </div>
                    </div>
                <?php
                endforeach;
                endif;
                ?>
        </div>
    </div>
</div>
<!--<section class="h-100 p-5" style="background-color: #eee;">-->
<!--    -->
<!--</section>-->
<!--End Input-->