<?php
include '../Controller/crud_functions_request.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $bookname = isset($_POST['bookname']) ? $_POST['bookname'] : '';

    // Insert new record into the products table
    $stmt = $pdo->prepare('INSERT INTO requests VALUES (?, ?)');
    $stmt->execute([$id, $bookname]);
    // Output message
    $msg = 'Book Request Added Successfully!';
}
?>

<?=template_header('Add Book Request')?>

<div class="content update">
    <h2>Add a Book Request</h2>
    <form action="crud_create_request.php" method="post">

        <input type="text" name="id" placeholder="26" value="auto" id="id" hidden>
        
        <label for="bookname">Requested Book Name</label>
        <input type="text" name="bookname" placeholder="Book Name" id="bookname" required>
        
        <input type="submit" value="Add">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>