<?php
include '../Controller/crud_functions_orders.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 5;

$stmt = $pdo->prepare('SELECT * FROM orders ORDER BY id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of orders, this is so we can determine whether there should be a next and previous button
$num_orders = $pdo->query('SELECT COUNT(*) FROM orders')->fetchColumn();
?>

<?=template_header('Order List')?>

<div class="content read">
	<h2>List of Orders</h2>
	<table>
        <thead>
            <tr>
                <td>Fullname</td>
                <td>Address</td>
                <td>Phone</td>
                <td>Card</td>
                <td>Amount</td>
                <td>Book IDs</td>
                <td>Delivery Status</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
            <tr>
                <td><?=$order['fullname']?></td>
                <td><?=$order['address']?></td>
                <td><?=$order['phone']?></td>
                <td><?=$order['card']?></td>
                <td><?=$order['price']?></td>
                <td><?=$order['books']?></td>
                <td><?=$order['takenby']?></td>
                <td class="actions">
                    <a href="crud_update_order_status.php?id=<?=$order['id']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="crud_read_orders.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_orders): ?>
		<a href="crud_read_orders.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>