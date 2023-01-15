<?php
include 'config.php';
date_default_timezone_set('Europe/Moscow');

$id = $_GET['open'];
$date = date("Y-m-d G:i:s", time() + 0);
$q = $pdo->prepare("SELECT * FROM `$id`");
$q->execute();
$result1 = $q->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title id="id"><?=$id?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css">
    <?php
    function  createConfirmationmbox($prompt_msg){
        echo ("<script type='text/javascript'> var answer = prompt('".$prompt_msg."'); </script>");;
        $answer = "<script type='text/javascript'> document.write(answer); </script>";
        return($answer);
    }
    $prompt_msg = "Please type your name.";
    $name = createConfirmationmbox($prompt_msg);
    $_POST['name'] = $name;
    ?>
</head>
<body style="background: #8b5858">
<div class="container">
    <div class="row">
    <div class="col mt-1">
        <div class="card border-0" style="background: #8b5858">
            <?php foreach ($result1 as $value) { ?>
                <div class="card-body" style="background: bisque; border-radius: 10px; margin-bottom: 10px">
                    <div class="row" style="background: burlywood; border-radius: 10px; font-size: large">
                        <div class="col-sm-2"><ins><?=$value['name']?></ins></div>
                        <div class="col-sm-4"><?=$value['date']?></div>
                        <div class="col-sm-6"></div>
                    </div>
                    <div><?=$value['msg'] ?></div>

                </div> <?php } ?>
        </div>
        <form action="" method="post">
            <input class="form-control" name="msg" type="text" id="msg" />
            <input class="form-control" type="button" id="submitbtn" value="send"/>
        </form>
        <script>
            let sendbtn = document.getElementById('submitbtn');
            sendbtn.addEventListener('click', () => {
                sendbtn.disabled = true;
                let message = document.getElementById('msg').value;
                let create_data = new FormData();
                create_data.append('msg', message);

                let chat_id = document.getElementById('id').value;
                create_data.append('id', chat_id);

                fetch('http://lab3/func.php', {method: 'POST', body: create_data})
                    .then(resp => resp.text())
                    .then(chat_id => {
                        alert('Сообщение отправлено');

                        let row1 = document.createElement('div');
                        row1.className = "row mt-2";
                        insert.appendChild(row1);

                        let col1 = document.createElement('div');
                        col1.className = "col-10";
                        col1.innerHTML = message;
                        row1.appendChild(col1);
                    })
                    .catch(err => {console.log(err)});

            })
        </script>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script>
</body>
</html>