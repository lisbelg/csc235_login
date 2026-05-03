<?php
define('ROOT_PATH', dirname(__DIR__));
require_once(ROOT_PATH . "/php/config.php");

$first_name = "";
$last_name = "";
$email = "";
$phone = "";
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);

    if (!empty($first_name) && !empty($last_name) && !empty($email)) {
        $insert_customer = $db_connection->prepare(
            "INSERT INTO Customers (first_name, last_name, email, phone)
             VALUES (?, ?, ?, ?)"
        );

        $insert_customer->bind_param("ssss", $first_name, $last_name, $email, $phone);

        if ($insert_customer->execute()) {
            $message = "Customer added successfully.";
        } else {
            $message = "Error adding customer. Email may already exist.";
        }

        $insert_customer->close();
    } else {
        $message = "First name, last name, and email are required.";
    }
}

$customers = $db_connection->query("SELECT * FROM Customers ORDER BY customer_id ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customers</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<h1>Customers</h1>

<?php if (!empty($message)) { ?>
    <p><?php echo $message; ?></p>
<?php } ?>

<h2>Add New Customer</h2>

<form method="POST" action="customers.php">
    <label>First Name:</label><br>
    <input type="text" name="first_name" required><br><br>

    <label>Last Name:</label><br>
    <input type="text" name="last_name" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Phone:</label><br>
    <input type="text" name="phone"><br><br>

    <button type="submit">Add Customer</button>
</form>

<h2>Customer List</h2>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>Customer ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone</th>
        </tr>
    </thead>

    <tbody>
        <?php while ($row = $customers->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row["customer_id"]; ?></td>
                <td><?php echo htmlspecialchars($row["first_name"]); ?></td>
                <td><?php echo htmlspecialchars($row["last_name"]); ?></td>
                <td><?php echo htmlspecialchars($row["email"]); ?></td>
                <td><?php echo htmlspecialchars($row["phone"]); ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

</body>
</html>

<?php
$db_connection->close();
?>