<?php
include '../Controller/crud_functions_meeting.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the employee id exists, for example update.php?id=1 will get the employee with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the crud_create_employee.php, but instead we update a record and not insert
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $topic = isset($_POST['topic']) ? $_POST['topic'] : '';
        $team = isset($_POST['team']) ? $_POST['team'] : '';
        $link = isset($_POST['link']) ? $_POST['link'] : '';
        $date = isset($_POST['date']) ? $_POST['date'] : '';
        $time = isset($_POST['time']) ? $_POST['time'] : '';
        // Update the record
        $stmt = $pdo->prepare('UPDATE meeting SET id = ?, topic = ?, team = ?, link = ?, date = ?, time = ? WHERE id = ?');
        $stmt->execute([$id, $topic, $team, $link, $date, $time, $_GET['id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the employee from the employee_signed table
    $stmt = $pdo->prepare('SELECT * FROM meeting WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $meeting = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$meeting) {
        exit('Meeting doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Update Meeting')?>

<div class="content update">
    <h2>Meeting ID #<?=$meeting['id']?></h2>
    <form action="crud_update_meeting.php?id=<?=$meeting['id']?>" method="post">

        <input type="text" name="id" placeholder="1" value="<?=$meeting['id']?>" id="id" readonly>
        
        <label for="topic">Meeting Topic</label>
        <input type="text" name="topic" placeholder="Meeting Topic" value="<?=$meeting['topic']?>" id="topic">

        <label for="team">Meeting Team</label>
        <input type="text" name="team" placeholder="Meeting Team" value="<?=$meeting['team']?>" id="team">
        
        <label for="link">Meeting Link</label>
        <input type="text" name="link" placeholder="Meeting Link" value="<?=$meeting['link']?>" id="link">
        
        <label for="date">Date</label>
        <input type="text" name="date" placeholder="Date" value="<?=$meeting['date']?>" id="date">
        
        <label for="time">Time</label>
        <input type="text" name="time" placeholder="Time" value="<?=$meeting['time']?>" id="time">
        
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>