<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check that the contact ID exists
if (isset($_GET['NIM'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM mahasiswa WHERE nim = ?');
    $stmt->execute([$_GET['NIM']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Data tidak ada dengan NIM tersebut!!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM mahasiswa WHERE NIM = ?');
            $stmt->execute([$_GET['NIM']]);
            $msg = 'Anda telah menghapus data!';
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: read.php');
            exit;
        }
    }
} else {
    exit('NIM tidak ditemukan');
}
?>


<?=template_header('Delete')?>

<div class="content delete">
    <h2>Delete Data #<?=$contact['NIM']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
    <p>Apakah anda yakin ingin menghapus data #<?=$contact['NIM']?>?</p>
    <div class="yesno">
        <a href="delete.php?NIM=<?=$contact['NIM']?>&confirm=yes">Yes</a>
        <a href="delete.php?NIM=<?=$contact['NIM']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>
