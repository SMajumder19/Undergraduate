<?php
include '../Controller/crud_functions_orders.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the product id exists, for example update.php?id=1 will get the product with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the crud_create_price.php, but instead we update a record and not insert
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $fullname = isset($_POST['fullname']) ? $_POST['fullname'] : '';
        $address = isset($_POST['address']) ? $_POST['address'] : '';
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
        $card = isset($_POST['card']) ? $_POST['card'] : '';
        $price = isset($_POST['price']) ? $_POST['price'] : '';
        $books = isset($_POST['books']) ? $_POST['books'] : '';
        $takenby = isset($_POST['takenby']) ? $_POST['takenby'] : '';
        // Update the record
        $stmt = $pdo->prepare('UPDATE orders SET id = ?, fullname = ?, address = ?, phone = ?, card = ?, price = ?, books = ?, takenby = ? WHERE id = ?');
        $stmt->execute([$id, $fullname, $address, $phone, $card, $price, $books, $takenby, $_GET['id']]);
        $msg = 'Status Updated Successfully!';
    }
    // Get the products from the products table
    $stmt = $pdo->prepare('SELECT * FROM orders WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$order) {
        exit('Order doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Update Order Status')?>

<div class="content update">
    <h2>Order ID #<?=$order['id']?></h2>
    <form action="crud_update_order_status.php?id=<?=$order['id']?>" method="post">
        <input type="text" name="id" placeholder="1" value="<?=$order['id']?>" id="id" hidden>

        <input type="text" name="fullname" placeholder="Firstname Lastname" value="<?=$order['fullname']?>" id="fullname" hidden>

        <input type="text" name="address" placeholder="Address" value="<?=$order['address']?>" id="address" hidden>

        <input type="text" name="phone" placeholder="Phone Number" value="<?=$order['phone']?>" id="phone" hidden>

        <input type="text" name="card" placeholder="Card Number" value="<?=$order['card']?>" id="card" hidden>

        <input type="text" name="price" placeholder="Price" value="<?=$order['price']?>" id="price" hidden>

        <input type="text" name="books" placeholder="Books" value="<?=$order['books']?>" id="books" hidden>

        <label for="takenby">Delivery Status</label>
        <input type="text" name="takenby" placeholder="Status" value="<?=$order['takenby']?>" id="takenby">

        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>