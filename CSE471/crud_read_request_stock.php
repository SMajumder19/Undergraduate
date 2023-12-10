<?php
include '../Controller/crud_functions_request_stock.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 5;

$stmt = $pdo->prepare('SELECT * FROM requests ORDER BY id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$request = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of products, this is so we can determine whether there should be a next and previous button
$num_request = $pdo->query('SELECT COUNT(*) FROM requests')->fetchColumn();
?>

<?=template_header('Requests List')?>

<div class="content read">
	<h2>List of Requests</h2>
	<table>
        <thead>
            <tr>
                <td>Requested Book Name</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($request as $requs): ?>
            <tr>
                <td><?=$requs['bookname']?></td>
                <td class="actions">
                    <a href="crud_delete_request_stock.php?id=<?=$requs['id']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="crud_read_request_stock.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_request): ?>
		<a href="crud_read_request_stock.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>