<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Новини</title>
</head>
<?php
$conn = new PDO("mysql:host=localhost;dbname=test-shop.com", "root", "");
$reader = $conn->query("SELECT * FROM news");

?>
<body>

<?php include "navbar.php"; ?>
<div class="container">
    <h1>Головна сторінка</h1>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Description</th>
            <th scope="col">Image</th>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($reader as $row) {
            echo "
        <tr>
            <td>{$row['id']}</td>
            <td>{$row['name']}</td>
            <td>{$row['description']}</td>
            <td>
                <img src='/images/{$row['image']}' alt='Bear' width='100'/>
                
            </td>
            
            <td>
                <a href='/edit.php?id={$row['id']}' class='btn btn-danger'>Edit</a>
            </td>
            
            <td>
                <a href='#' class='btn btn-danger btnDelete' data-id='{$row['id']}' data-filepath='{$row['image']}' >Delete</a>
            </td>
        </tr>
        ";
        }
        ?>
        </tbody>
    </table>
</div>


<?php include "modal_delete.php"; ?>

<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/axios.min.js"></script>
<script>
    const myModal = new bootstrap.Modal(document.getElementById("myModal"), {});
    window.addEventListener("load",function() {
        const list=document.querySelectorAll(".btnDelete");
        let editlist=document.querySelectorAll(".btnEdit");
        let filepath = '';
        let id=0;
        for (let i=0; i<list.length; i++)
        {
            list[i].addEventListener("click", function(e) {
                e.preventDefault();
                filepath = e.currentTarget.dataset.filepath;
                const id2 = e.currentTarget.dataset.id;
                id = id2;
                myModal.show();
            });
        }
        document.querySelector("#btnDeleteNews").addEventListener("click", function() {
            const formData = new FormData();
            formData.append("id", id);
            formData.append("filepath", filepath);
            axios.post("delete.php", formData)
                .then(resp => {
                    location.reload();
                });
        });

        for (let i = 0; i<editlist.length; ++i) {
            editlist[i].addEventListener("click", function (e) {
                e.preventDefault();
                const id = e.currentTarget.dataset.id;
                const form = new FormData();
                form.append("id", id);
                axios.get("edit.php", form)
                    .then(resp => {
                        location.reload();
                    });
            })
        }
    });
</script>
</body>
</html>