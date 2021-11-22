<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
//    echo "<h2>name = ".$_POST['name']."</h2>";

    $filename = uniqid().'.jpg';
    $filesavepath=$_SERVER['DOCUMENT_ROOT'].'/images/'.$filename;
    move_uploaded_file($_FILES['image']['tmp_name'],$filesavepath);

    $name = $_POST['name'];
    $description = $_POST['description'];

    $conn = new PDO("mysql:host=localhost;dbname=test-shop.com", "root", "");
    $sql = "INSERT INTO `news` (`name`, `description`,`image`) VALUES (?, ?, ?);";
    $conn->prepare($sql)->execute([$name, $description, $filename]);
    header("Location: /");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Додати новину</title>
</head>
<?php

?>
<body>

<?php include "navbar.php"; ?>

<div class="container">
    <h1>Додати новину</h1>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">Назва</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
        </div>
        <div class="mb-3" class="form-label">
            <label for="description">Опис</label>
            <textarea class="form-control" rows="10" cols="35" id="description" name="description"
                      placeholder="Enter email"></textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">
                <img src="https://www.pngall.com/wp-content/uploads/2/Upload-Transparent.png"
                     width="150"
                     id="img_preview"
                     style="cursor: pointer"
                />
            </label>
            <input type="file" name="image" id="image" class="form-control d-none"/>
        </div>
        <button type="submit" class="btn btn-primary">Зберегти</button>
    </form>

</div>


<script src="js/bootstrap.bundle.min.js"></script>

<script>
    window.addEventListener('load',function() {
        const file = document.getElementById('image');
        file.addEventListener("change", function(e) {
            const uploadFile = e.currentTarget.files[0];
            document.getElementById("img_preview").src=URL.createObjectURL(uploadFile);
        });
    });
</script>
</body>
</html>