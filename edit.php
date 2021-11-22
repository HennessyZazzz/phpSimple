
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Змінити новину</title>
</head>
<?php
    $id = $_GET["id"];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $name = $_POST['name'];
        $description = $_POST['description'];

        $conn = new PDO("mysql:host=localhost;dbname=test-shop.com", "root", "");
        $select = "SELECT * FROM news WHERE id = ${$id}";
        $link = mysqli_connect("localhost", "root", "", "test-shop.com");

        if($result = mysqli_query($link, $select)){
            while($row = mysqli_fetch_array($result)){
                if (unlink($_SERVER['DOCUMENT_ROOT'] . "/images/" . $row['image']))
                {
                    $filename = uniqid().'.jpg';
                    $filepath =$_SERVER['DOCUMENT_ROOT'].'/images/'.$filename;
                    move_uploaded_file($_FILES['image']['tmp_name'], $filepath);

                    $sql = "UPDATE news SET name= ?, image= ?, description= ?  WHERE `news`.`Id` = ?";
                    $conn->prepare($sql)->execute([$id, $name, $filename, $description]);
                }

            }
        }

        header("Location: /index.php");
        exit();
    }
?>
<body>


<div class="container">
    <h1>Змінити новину</h1>
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