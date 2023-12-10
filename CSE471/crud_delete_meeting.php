<?php
include '../Controller/crud_functions_meeting.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check that the employee ID exists
if (isset($_GET['id'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM meeting WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $meet = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$meet) {
        exit('Meeting doesn\'t exist with that ID!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM meeting WHERE id = ?');
            $stmt->execute([$_GET['id']]);
            $msg = 'Meeting has been deleted!';
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: crud_read_meeting.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Delete Employee')?>

<div class="content delete">
    <h2>Meeting ID #<?=$meet['id']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
    <p>Are you sure you want to delete employee #<?=$meet['id']?>?</p>
    <div class="yesno">
        <a href="crud_delete_meeting.php?id=<?=$meet['id']?>&confirm=yes">Yes</a>
        <a href="crud_delete_meeting.php?id=<?=$meet['id']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>