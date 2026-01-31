<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '/Classes/Database.php';
include_once __DIR__ . '/Classes/User.php';
include_once __DIR__ . '/Classes/Terminet.php';
include_once __DIR__ . '/Classes/Abonimet.php';


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$database = new Database();
$db = $database->getConnection();
$user = new User($db);
$terminet = new Terminet($db);
$abonimet = new Abonimet($db);



if (isset($_GET['delete_user'])) {
    $user->delete($_GET['delete_user']);
    header("Location: dashboard.php?tab=users");
    exit;
}
if (isset($_GET['delete_termin'])) {
    $terminet->delete($_GET['delete_termin']);
    header("Location: dashboard.php?tab=appointments");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_user'])) {
    $user->id = $_POST['user_id'];
    $user->perdoruesi = $_POST['username'];
    $user->email = $_POST['email'];
    $user->role = $_POST['role'];
    
    if($user->update()) {
        $msg = "User updated successfully!";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_termin'])) {
    $terminet->id = $_POST['termin_id'];
    $terminet->fullname = $_POST['fullname'];
    $terminet->email = $_POST['email'];
    $terminet->phone = $_POST['phone'];
    $terminet->doctor = $_POST['doctor'];
    $terminet->appointment_date = $_POST['date'];
    $terminet->appointment_time = $_POST['time'];
    
    if($terminet->update()) {
        $msg = "Appointment updated successfully!";
    }
}

$edit_user = null;
if (isset($_GET['edit_user'])) {
    $user->id = $_GET['edit_user'];
    $user->readOne();
    $edit_user = $user;
}

$edit_termin = null;
if (isset($_GET['edit_termin'])) {
    $terminet->id = $_GET['edit_termin'];
    $terminet->readOne();
    $edit_termin = $terminet;
}

if (isset($_GET['delete_abonim'])) {
    $abonimet->id = $_GET['delete_abonim'];
    $abonimet->delete($_GET['delete_abonim']);
    header("Location: dashboard.php?tab=abonimet");
    exit;
}

$edit_abonim = null;
if (isset($_GET['edit_abonim'])) {
    $abonimet->id = $_GET['edit_abonim'];
    $abonimet->readOne();
    $edit_abonim = $abonimet;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_abonim'])) {
    $abonimet->id = $_POST['abonim_id'];
    $abonimet->pako = $_POST['pako'];
    $abonimet->cmimi = $_POST['cmimi'];
    $abonimet->status = $_POST['status'];

    if ($abonimet->update()) {
        $msg = "Subscription updated successfully!";
    }
}

$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'users';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .btn-edit { background: #ffc107; color: #000; padding: 6px 12px; text-decoration: none; border-radius: 4px; font-size: 14px; margin-right: 5px; }
        .btn-edit:hover { background: #e0a800; }
        
        .edit-form-container { background: #fff; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-left: 5px solid var(--primary); }
        .edit-form-container h3 { margin-top: 0; color: var(--primary); }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input, .form-group select { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        .btn-save { background: var(--primary); color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; }
        .btn-cancel { background: #6c757d; color: white; text-decoration: none; padding: 10px 20px; border-radius: 4px; margin-left: 10px; }
        
        .dashboard-container { display: flex; min-height: 100vh; }
        .sidebar { width: 250px; background: var(--dark); color: white; padding: 20px; flex-shrink: 0;}
        .sidebar a { display: block; color: #ccc; padding: 12px; text-decoration: none; margin-bottom: 10px; }
        .sidebar a.active, .sidebar a:hover { background: rgba(255,255,255,0.1); color: white; }
        .main-content { flex-grow: 1; padding: 40px; background: #f4f6f9; }
        .table-container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #eee; }
        .btn-delete { background: #dc3545; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px; font-size: 14px; }
        .badge { padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: bold; }
        .badge-admin { background: #d4edda; color: #155724; }
        .badge-user { background: #e2e3e5; color: #383d41; }
    </style>
</head>
<body>

<div class="dashboard-container">
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="?tab=users" class="<?php echo $active_tab == 'users' ? 'active' : ''; ?>">Users</a>
        <a href="?tab=appointments" class="<?php echo $active_tab == 'appointments' ? 'active' : ''; ?>">Appointments</a>
        <a href="?tab=abonimet" class="<?php echo $active_tab == 'abonimet' ? 'active' : ''; ?>">Subscriptions</a>
        <a href="index.php">Back to Home</a>
        <a href="logout.php" style="color: #dc3545; margin-top: 40px;">Logout</a>
    </div>

    <div class="main-content">
        <?php if(isset($msg)) echo "<div style='background: #d4edda; color: #155724; padding: 10px; margin-bottom: 20px; border-radius: 4px;'>$msg</div>"; ?>

        <?php if ($edit_user): ?>
        <div class="edit-form-container">
            <h3>Edit User: <?php echo $edit_user->perdoruesi; ?></h3>
            <form method="POST" action="dashboard.php?tab=users">
                <input type="hidden" name="user_id" value="<?php echo $edit_user->id; ?>">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" value="<?php echo $edit_user->perdoruesi; ?>" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="<?php echo $edit_user->email; ?>" required>
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select name="role">
                        <option value="user" <?php echo $edit_user->role == 'user' ? 'selected' : ''; ?>>User</option>
                        <option value="admin" <?php echo $edit_user->role == 'admin' ? 'selected' : ''; ?>>Admin</option>
                    </select>
                </div>
                <button type="submit" name="update_user" class="btn-save">Save Changes</button>
                <a href="dashboard.php?tab=users" class="btn-cancel">Cancel</a>
            </form>
        </div>
        <?php endif; ?>

        <?php if ($edit_termin): ?>
        <div class="edit-form-container">
            <h3>Edit Appointment</h3>
            <form method="POST" action="dashboard.php?tab=appointments">
                <input type="hidden" name="termin_id" value="<?php echo $edit_termin->id; ?>">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="fullname" value="<?php echo $edit_termin->fullname; ?>" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="<?php echo $edit_termin->email; ?>" required>
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" value="<?php echo $edit_termin->phone; ?>">
                </div>
                <div class="form-group">
                    <label>Doctor</label>
                    <select name="doctor">
                        <option value="Dr. Ali" <?php echo $edit_termin->doctor == 'Dr. Ali' ? 'selected' : ''; ?>>Dr. Ali</option>
                        <option value="Dr. Ayse" <?php echo $edit_termin->doctor == 'Dr. Ayse' ? 'selected' : ''; ?>>Dr. Ayse</option>
                        <option value="Dr. Fatbardh" <?php echo $edit_termin->doctor == 'Dr. Fatbardh' ? 'selected' : ''; ?>>Dr. Fatbardh</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Date</label>
                    <input type="date" name="date" value="<?php echo $edit_termin->appointment_date; ?>" required>
                </div>
                <div class="form-group">
                    <label>Time</label>
                    <input type="time" name="time" value="<?php echo $edit_termin->appointment_time; ?>" required>
                </div>
                <button type="submit" name="update_termin" class="btn-save">Save Changes</button>
                <a href="dashboard.php?tab=appointments" class="btn-cancel">Cancel</a>
            </form>
        </div>
        <?php endif; ?>
        <?php if ($edit_abonim): ?>
        <div class="edit-form-container">
            <h3>Edit Subscription</h3>
            <form method="POST" action="dashboard.php?tab=abonimet">
                <input type="hidden" name="abonim_id" value="<?php echo $edit_abonim->id; ?>">
                <div class="form-group">
                    <label>Package</label>
                    <input type="text" name="pako" value="<?php echo $edit_abonim->pako; ?>" required>
                </div>
                <div class="form-group">
                    <label>Price</label>
                    <input type="number" step="0.01" name="cmimi" value="<?php echo $edit_abonim->cmimi; ?>" required>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status">
                        <option value="aktiv" <?php echo $edit_abonim->status == 'aktiv' ? 'selected' : ''; ?>>Active</option>
                        <option value="skaduar" <?php echo $edit_abonim->status == 'skaduar' ? 'selected' : ''; ?>>Expired</option>
                        <option value="anuluar" <?php echo $edit_abonim->status == 'anuluar' ? 'selected' : ''; ?>>Canceled</option>
                    </select>
                </div>
                <button type="submit" name="update_abonim" class="btn-save">Save Changes</button>
                <a href="dashboard.php?tab=abonimet" class="btn-cancel">Cancel</a>
            </form>
        </div>
        <?php endif; ?>



        <?php if ($active_tab == 'users' && !$edit_user): ?>
            <h1>Manage Users</h1>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $user->readAll();
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>{$row['id']}</td>";
                            echo "<td>{$row['perdoruesi']}</td>";
                            echo "<td>{$row['email']}</td>";
                            $roleClass = $row['role'] == 'admin' ? 'badge-admin' : 'badge-user';
                            echo "<td><span class='badge {$roleClass}'>{$row['role']}</span></td>";
                            echo "<td>";
                            echo "<a href='?tab=users&edit_user={$row['id']}' class='btn-edit'>Edit</a>";
                            if ($row['role'] != 'admin') {
                                echo "<a href='?delete_user={$row['id']}' class='btn-delete' onclick='return confirm(\"Are you sure?\")'>Delete</a>";
                            }
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        <?php elseif ($active_tab == 'appointments' && !$edit_termin): ?>
            <h1>Manage Appointments</h1>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Phone</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $terminet->readAll();
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>{$row['id']}</td>";
                            echo "<td>{$row['fullname']}</td>";
                            echo "<td>{$row['doctor']}</td>";
                            echo "<td>{$row['appointment_date']}</td>";
                            echo "<td>{$row['appointment_time']}</td>";
                            echo "<td>{$row['phone']}</td>";
                            echo "<td>";
                            echo "<a href='?tab=appointments&edit_termin={$row['id']}' class='btn-edit'>Edit</a>";
                            echo "<a href='?delete_termin={$row['id']}' class='btn-delete' onclick='return confirm(\"Cancel this appointment?\")'>Delete</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
        <?php if ($active_tab == 'abonimet' && !$edit_abonim): ?>
            <h1>Manage Subscriptions</h1>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User ID</th>
                            <th>Package</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $abonimet->readAll();
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>{$row['id']}</td>";
                            echo "<td>{$row['user_id']}</td>";
                            echo "<td>{$row['pako']}</td>";
                            echo "<td>{$row['cmimi']}</td>";
                            echo "<td>{$row['status']}</td>";
                            echo "<td>";
                            echo "<a href='?tab=abonimet&edit_abonim={$row['id']}' class='btn-edit'>Edit</a>";
                            echo "<a href='?delete_abonim={$row['id']}' class='btn-delete' onclick='return confirm(\"Are you sure?\")'>Delete</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>


    </div>
</div>

</body>
</html>
