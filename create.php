<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $nim = isset($_POST['nim']) && !empty($_POST['nim']) && $_POST['nim'] != 'auto' ? $_POST['nim'] : '';
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $nama = isset($_POST['nama']) ? $_POST['nama'] : '';
    $alamat = isset($_POST['alamat']) ? $_POST['alamat'] : '';
    $kota = isset($_POST['kota']) ? $_POST['kota'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';

    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO mahasiswa VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$nim, $nama, $alamat, $kota, $gender]);
    // Output message
    $msg = 'Created Successfully!';
}
?>


<?=template_header('Create')?>

<div class="content update">
	<h2>Create Data</h2>
    <form action="create.php" method="post">
        <label for="nim">NIM</label>
        <input type="text" name="nim" id="nim">
        <label for="nama">Nama</label>
        <input type="text" name="nama" id="nama">
        <label for="alamat">Alamat</label>
        <input type="text" name="alamat" id="alamat">
        <label for="kota">Kota</label>
        <input type="text" name="kota" id="kota">
        <label for="gender">Gender</label>
        <input type="text" name="gender" id="gender">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
