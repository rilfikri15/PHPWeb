<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

if (isset($_POST['nim'])) {
    // Retrieve data from POST
    $nim = isset($_POST['nim']) ? $_POST['nim'] : '';
    $nama = isset($_POST['NAMA']) ? $_POST['NAMA'] : '';
    $alamat = isset($_POST['ALAMAT']) ? $_POST['ALAMAT'] : '';
    $kota = isset($_POST['KOTA']) ? $_POST['KOTA'] : '';
    $gender = isset($_POST['GENDER']) ? $_POST['GENDER'] : '';

    // Update the record
    $stmt = $pdo->prepare('UPDATE mahasiswa SET nim = ?, nama = ?, alamat = ?, kota = ?, gender = ? WHERE nim = ?');
    $stmt->execute([$nim, $nama, $alamat, $kota, $gender, $_GET['NIM']]);
    $msg = 'Updated Successfully!';

    // Redirect user after update
    header('Location: index.php');
    exit;
} else {
    // Check if NIM is provided in the URL
    if (!isset($_GET['NIM'])) {
        exit('NIM tidak ditemukan!');
    }

    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM mahasiswa WHERE nim = ?');
    $stmt->execute([$_GET['NIM']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$contact) {
        exit('Data tidak ditemukan dengan NIM tersebut!');
    }
}
?>




<?=template_header('Read')?>

<div class="content update">
	<h2>Update Data #<?=$contact['nim']?></h2>
    <form action="update.php?id=<?=$contact['nim']?>" method="post">
        <label for="nim">NIM</label>
        <input type="text" name="nim" value="<?=$contact['nim']?>" id="nim">
        <label for="nama">Nama</label>
        <input type="text" name="nama" value="<?=$contact['nama']?>" id="nama">
        <label for="alamat">Alamat</label>
        <input type="text" name="alamat" value="<?=$contact['alamat']?>" id="alamat">
        <label for="kota">Kota</label>
        <input type="text" name="kota" value="<?=$contact['kota']?>" id="kota">
        <label for="gender">Gender</label>
        <input type="text" name="gender" value="<?=$contact['gender']?>" id="gender">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
