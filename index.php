<?php
include 'func.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Чаты</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css">
</head>
<body style="background: #8b5858">
	<div class="container">
		<div class="row">
			<div class="col mt-1">
				<button class="btn btn-success mb-1" data-toggle="modal" data-target="#Modal"><i class="fa fa-plus"></i></button>
            </div>
        </div>
        <div class="card border-0" style="background: #8b5858">
                <?php foreach ($result as $value) { ?>
                <div class="card-body" style="background: bisque; border-radius: 10px; margin-bottom: 10px">
                    <div class="row" style="background: burlywood; border-radius: 10px; font-size: x-large">
<!--                                //ссылку нужно на main и передавать GET запросом id чата-->
<!--                                //открытый чат в строке адреса должен выглядеть как ".../lab3/main?open=(1/2/3...)"-->
                        <div class="col-sm-6"><a href="main.php?open=<?=$value['title'] ?> " class="link-primary" target="_blank"><?=$value['title']?></a></div>
                        <?php require 'modal.php'; ?>
                    </div>
                </div>
                <?php } ?>
        </div>
    </div>
	<!-- Modal -->
	<div class="modal fade" tabindex="-1" role="dialog" id="Modal">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content shadow" style="background: bisque">
	      <div class="modal-header">
	        <h5 class="modal-title">Создать чат</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
	      </div>
	      <div class="modal-body">
	        <form action="" method="post">
	        	<div class="form-group">
	        		<input type="text" class="form-control" name="title" value="" placeholder="Название чата">
	        	</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
	        <button type="submit" name="submitNewChat" class="btn btn-primary">Добавить</button>
	      </div>
	  		</form>
	    </div>
	  </div>
	</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script>
</body>
</html>