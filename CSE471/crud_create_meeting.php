<?php
include '../Controller/crud_functions_meeting.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $topic = isset($_POST['topic']) ? $_POST['topic'] : '';
    $team = isset($_POST['team']) ? $_POST['team'] : '';
    $link = isset($_POST['link']) ? $_POST['link'] : '';
    $date = isset($_POST['date']) ? $_POST['date'] : '';
    $time = isset($_POST['time']) ? $_POST['time'] : '';
    // Insert new record into the employee_signed table
    $stmt = $pdo->prepare('INSERT INTO meeting VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$id, $topic, $team, $link, $date, $time]);
    // Output message
    $msg = 'Added Successfully!';
}
?>

<?=template_header('Add Meeting')?>

<div class="content update">
    <h2>Add a Meeting</h2>
    <form action="crud_create_meeting.php" method="post">

        <input type="text" name="id" placeholder="26" value="auto" id="id" hidden>
        
        <label for="topic">Meeting Topic</label>
        <input type="text" name="topic" placeholder="Meeting Topic" id="topic" required>

        <label for="team">Meeting Team</label>
        <input type="text" name="team" placeholder="Meeting Team" id="team" required>
        
        <label for="link">Meeting Link</label>
        <input type="text" name="link" placeholder="Meeting Link" id="link" required>
        
        <label for="date">Date</label>
        <input type="text" name="date" placeholder="Date" id="date" required>
        
        <label for="time">Time</label>
        <input type="text" name="time" placeholder="Time" id="time" required>
        
        <input type="submit" value="Add">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>