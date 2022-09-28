<?php
require "_core.php";

if (isset($_POST["check"], $_POST["order"]) && is_array($_POST["order"])) {
    $orders = $_POST["order"];
    $status = true;
    foreach($orders as $word_id => $order) {
        $real_order = getRealOrderOfWord ($word_id);
        if ($real_order === null) {
            $status = false;
            break;
        }

        $order = (int) $order;
        if ($order !== $real_order) {
            $status = false;
            break; 
        }
    }

    if ($status === true) {
        echo "correct";
    }else {
        echo "wrong";
    }
    echo '<a href="">Try another question</a>';
    exit();
} 
$question_id = getRandomQuestion();
if ($question_id === null) {
    echo "noquestionfound";
    exit();
}

$words = getWordOfQuestion($question_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="" method="POST">
    <?php foreach($words as $word_item) { ?>    
        <lable><?= $word_item["text"] ?></lable>
        <input type="number" name="order[<?= $word_item["id"] ?>]" min="1">
    <?php } ?>
    
    <button name="check">submit</button>
</form>    
</body>
</html>