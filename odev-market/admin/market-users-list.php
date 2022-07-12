<?php
require_once('./header.php');
if (!isset($_SESSION['admin'])) {
    header('Location: ./login.php');
    exit;
}

    $query = $conn->prepare('SELECT * FROM market_users');
    $query->execute();
    $result = $query->fetchAll();
?>

    <div class="container mt-5">
        <div class="row">
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">City</th>
                    <th scope="col">District</th>
                    <th scope="col">Address</th>
                    <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($result as $key => $value) { ?>
                            <tr>
                                <td><?=++$key?></td>
                                <td><?=$value['name']?></td>
                                <td><?=$value['email']?></td>
                                <td><?=$value['city']?></td>
                                <td><?=$value['district']?></td>
                                <td><?=$value['address']?></td>
                                <td>
                                    <a class='btn btn-info' href="market-users-edit.php?id=<?=$value['id']?>">Edit</a>
                                    <a class='btn btn-danger' href="market-users-delete.php?id=<?=$value['id']?>">Delete</a> 
                                </td>
                            </tr>
                    <?php    
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

<?php
require_once('./footer.php');
?>