<?php 
    require "session.php";
    require "../koneksi.php";

    $id = $_GET['p'];

    $query = mysqli_query($con, "SELECT * FROM kategori WHERE id='$id'");
    $data = mysqli_fetch_array($query);
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kategori</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
</head>
<body>
    <?Php require "navbar.php";?>
    <div class="container mt-5">
    <h2>Detail Kategori</h2>

    <div class="col-12 col-md-6">
        <form action="" method="post">
            <div> 
            <label for="kategori">Kategori</label>
            <input type="text" name="kategori" id="kategori" class="form-control mt-2" value="<?php echo $data['nama'];?>" autocomplete="off" required>

            </div>

            <div class = "mt-5 d-flex justify-content-between">
                <button type="submit" class="btn btn-primary" name="editBtn">Edit</button>
                <button type="submit" class="btn btn-danger" name="deleteBtn">Delete</button>
            </div>
            
        </form>

        <?php
            if(isset($_POST['editBtn'])){
                $kategori = htmlspecialchars($_POST['kategori']);
            
                if($data['nama']==$kategori){
                    ?>
                        <meta http-equiv="refresh" content="0; url=kategori.php"/>
                    <?php
                }
                else{
                    $query = mysqli_query($con, "SELECT * FROM kategori WHERE nama='$kategori'");
                    $jumlahData = mysqli_num_rows($query);

                    if($jumlahData > 0){
                        ?>
                        <div class="alert alert-primary mt-3" role="alert">
                                Kategori Sudah Ada
                        </div>
                        <meta http-equiv="refresh" content="2; url=kategori.php"/>
                        <?php
                    }
                    else{
                        $querySimpan = mysqli_query($con, "UPDATE kategori SET nama='$kategori' WHERE id='$id'");
                        if($querySimpan){
                        ?>
                            <div class="alert alert-primary mt-3" role="alert">
                                Kategori Berhasil Diupdate
                            </div>

                            <meta http-equiv="refresh" content="2; url=kategori.php"/>
                        <?php 

                        }
                            else{
                            echo mysqli_error($con);
                        }
                    }
                }
            }

            if(isset($_POST['deleteBtn'])){
                $queryCheck = mysqli_query($con,"SELECT * FROM produk WHERE kategori_id='$id'" );
                $dataCount = mysqli_num_rows($queryCheck);
                
            if($dataCount>0){
                ?>
                <div class="alert alert-warning mt-3" role="alert">
                Kategori tidak bisa dihapus karena sudah digunakan diproduk
                </div>
                
                <?php
            }

                $queryDelete = mysqli_query($con, "DELETE FROM kategori WHERE id='$id'");
                
                if($queryDelete){
                    ?>
                    <div class="alert alert-primary mt-3" role="alert">
                    Kategori Berhasil Dihapus
                    </div>

                            <meta http-equiv="refresh" content="2; url=kategori.php"/>
                    <?php
                }
                else{
                    echo mysqli_error($con);
                }
            }
        ?>
    </div>
    </div>
    <script src = "../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>