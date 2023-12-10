<?php
include '../Controller/crud_functions_meeting.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 5;

$stmt = $pdo->prepare('SELECT * FROM meeting ORDER BY id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$meeting = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of employees, this is so we can determine whether there should be a next and previous button
$num_meeting = $pdo->query('SELECT COUNT(*) FROM meeting')->fetchColumn();
?>

<?=template_header('Meeting List')?>

<div class="content read">
	<h2>List of Meetings</h2>
	<a href="crud_create_meeting.php" class="create-employee">Add a Meeting</a>
	<table>
        <thead>
            <tr>
                <td>Meeting Topic</td>
                <td>Meeting Team</td>
                <td>Meeting Link</td>
                <td>Date</td>
                <td>Time</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($meeting as $meet): ?>
            <tr>
                <td><?=$meet['topic']?></td>
                <td><?=$meet['team']?></td>
                <td><?=$meet['link']?></td>
                <td><?=$meet['date']?></td>
                <td><?=$meet['time']?></td>
                <td class="actions">
                    <a href="crud_update_meeting.php?id=<?=$meet['id']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="crud_delete_meeting.php?id=<?=$meet['id']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="crud_read_meeting.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_meeting): ?>
		<a href="crud_read_meeting.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>