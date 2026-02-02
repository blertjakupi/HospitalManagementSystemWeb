<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '/Classes/Database.php';
include_once __DIR__ . '/Classes/User.php';
include_once __DIR__ . '/Classes/Terminet.php';
include_once __DIR__ . '/Classes/Abonimet.php';
include_once __DIR__ . '/Classes/Doktoret.php';
include_once __DIR__ . '/Classes/Medikamentet.php';



if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$database = new Database();
$db = $database->getConnection();
$user = new User($db);
$terminet = new Terminet($db);
$abonimet = new Abonimet($db);
$doktoret = new Doktoret($db);
$medikamentet = new Medikamentet($db);



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

if (isset($_GET['delete_doktor'])) {
    $doktoret->id = $_GET['delete_doktor'];
    $doktoret->delete();
    header("Location: dashboard.php?tab=doktoret");
    exit;
}

$edit_doktor = null;
if (isset($_GET['edit_doktor'])) {
    $doktoret->id = $_GET['edit_doktor'];
    $doktoret->readOne();
    $edit_doktor = $doktoret;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_doktor'])) {
    $doktoret->id = $_POST['doktor_id'];
    $doktoret->emri = $_POST['emri'];
    $doktoret->mbiemri = $_POST['mbiemri'];
    $doktoret->specializimi = $_POST['specializimi'];
    $doktoret->email = $_POST['email'];
    $doktoret->telefoni = $_POST['telefoni'];

    if ($doktoret->update()) {
        $msg = "Doctor updated successfully!";
    }
}
$add_doktor = isset($_GET['add_doktor']) ? true : false;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_doktor'])) {
    $doktoret->emri = $_POST['emri'];
    $doktoret->mbiemri = $_POST['mbiemri'];
    $doktoret->specializimi = $_POST['specializimi'];
    $doktoret->email = $_POST['email'];
    $doktoret->telefoni = $_POST['telefoni'];

    if ($doktoret->createFromDashboard()) {
        $msg = "Doctor added successfully!";
        header("Location: dashboard.php?tab=doktoret");
        exit;
    } else {
        $msg = "Error adding doctor.";
    }
}

$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'users';


if (isset($_GET['delete_medikament'])) {
    $medikamentet->id = $_GET['delete_medikament'];
    $medikamentet->delete();
    header("Location: dashboard.php?tab=medikamentet");
    exit;
}

$edit_medikament = null;
if (isset($_GET['edit_medikament'])) {
    $medikamentet->id = $_GET['edit_medikament'];
    $medikamentet->readOne();
    $edit_medikament = $medikamentet;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_medikament'])) {
    $medikamentet->id = $_POST['medikament_id'];
    $medikamentet->emri = $_POST['emri'];
    $medikamentet->doza = $_POST['doza'];
    $medikamentet->cmimi = $_POST['cmimi'];
    $medikamentet->pershkrimi = $_POST['pershkrimi'];
    
    if ($medikamentet->update()) {
        $msg = "Medikamenti u përditësua!";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_medikament'])) {
    $medikamentet->emri = $_POST['emri'];
    $medikamentet->doza = $_POST['doza'];
    $medikamentet->cmimi = $_POST['cmimi'];
    $medikamentet->pershkrimi = $_POST['pershkrimi'];
    
    if ($medikamentet->create()) {
        $msg = "Medikamenti u shtua!";
        header("Location: dashboard.php?tab=medikamentet");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>



<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.querySelector('.dashboard-toggle');
        const sidebar = document.querySelector('.sidebar');
        const overlay = document.querySelector('.dashboard-overlay');

        if (toggleBtn) {
            // Open/Close menu
            toggleBtn.addEventListener('click', function () {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
            });

            // Close when clicking overlay
            overlay.addEventListener('click', function () {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            });

            // Close menu when clicking a link
            sidebar.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', function () {
                    if (window.innerWidth <= 768) {
                        sidebar.classList.remove('active');
                        overlay.classList.remove('active');
                    }
                });
            });
        }
    });
</script>



<body>

    <div class="dashboard-overlay"></div>
    <div class="dashboard-container">
        <div class="sidebar">
            <h2>Admin Panel</h2>
            <a href="?tab=users" class="<?php echo $active_tab == 'users' ? 'active' : ''; ?>">Users</a>
            <a href="?tab=appointments"
                class="<?php echo $active_tab == 'appointments' ? 'active' : ''; ?>">Appointments</a>
            <a href="?tab=abonimet" class="<?php echo $active_tab == 'abonimet' ? 'active' : ''; ?>">Subscriptions</a>
            <a href="?tab=doktoret" class="<?php echo $active_tab == 'doktoret' ? 'active' : ''; ?>">Doctors</a>
            <a href="?tab=medikamentet"
                class="<?php echo $active_tab == 'medikamentet' ? 'active' : ''; ?>">Medikamentet</a>
            <a href="index.php">Back to Home</a>
            <a href="logout.php" style="color: #dc3545; margin-top: 40px;">Logout</a>
        </div>

        <div class="main-content">
            <button class="dashboard-toggle">☰</button>
            <?php if (isset($msg))
                echo "<div style='background: #d4edda; color: #155724; padding: 10px; margin-bottom: 20px; border-radius: 4px;'>$msg</div>"; ?>

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
                                <option value="admin" <?php echo $edit_user->role == 'admin' ? 'selected' : ''; ?>>Admin
                                </option>
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
                                <option value="Dr. Ali" <?php echo $edit_termin->doctor == 'Dr. Ali' ? 'selected' : ''; ?>>Dr.
                                    Ali</option>
                                <option value="Dr. Ayse" <?php echo $edit_termin->doctor == 'Dr. Ayse' ? 'selected' : ''; ?>>
                                    Dr. Ayse</option>
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
                            <input type="number" step="0.01" name="cmimi" value="<?php echo $edit_abonim->cmimi; ?>"
                                required>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status">
                                <option value="aktiv" <?php echo $edit_abonim->status == 'aktiv' ? 'selected' : ''; ?>>Active
                                </option>
                                <option value="skaduar" <?php echo $edit_abonim->status == 'skaduar' ? 'selected' : ''; ?>>
                                    Expired</option>
                                <option value="anuluar" <?php echo $edit_abonim->status == 'anuluar' ? 'selected' : ''; ?>>
                                    Canceled</option>
                            </select>
                        </div>
                        <button type="submit" name="update_abonim" class="btn-save">Save Changes</button>
                        <a href="dashboard.php?tab=abonimet" class="btn-cancel">Cancel</a>
                    </form>
                </div>
            <?php endif; ?>

            <?php if ($edit_doktor): ?>
                <div class="edit-form-container">
                    <h3>Edit Doctor</h3>
                    <form method="POST" action="dashboard.php?tab=doktoret">
                        <input type="hidden" name="doktor_id" value="<?php echo $edit_doktor->id; ?>">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="emri" value="<?php echo $edit_doktor->emri; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="mbiemri" value="<?php echo $edit_doktor->mbiemri; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Specialization</label>
                            <input type="text" name="specializimi" value="<?php echo $edit_doktor->specializimi; ?>"
                                required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" value="<?php echo $edit_doktor->email; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" name="telefoni" value="<?php echo $edit_doktor->telefoni; ?>">
                        </div>
                        <button type="submit" name="update_doktor" class="btn-save">Save Changes</button>
                        <a href="dashboard.php?tab=doktoret" class="btn-cancel">Cancel</a>
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

                <div style="margin-bottom: 20px; padding: 15px; background: #f8f9fa; border-radius: 8px;">
                    <a href="?tab=appointments" class="btn-save" style="padding: 10px 20px; margin-right: 10px;"> All</a>
                    <a href="?tab=appointments&filter=<?= date('Y-m-d') ?>" class="btn-save"
                        style="padding: 10px 20px; margin-right: 10px; background: #28a745;"> Today
                        (<?= date('d/m/Y') ?>)</a>
                    <?php if (isset($_GET['filter'])): ?>
                        <span style="background: #e9ecef; padding: 8px 12px; border-radius: 20px; font-size: 14px;">
                            Showing: <?= date('d/m/Y', strtotime($_GET['filter'])) ?>
                            <a href="?tab=appointments" style="margin-left: 10px; color: #dc3545;">✕ Clear</a>
                        </span>
                    <?php endif; ?>
                </div>

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
                            if (isset($_GET['filter']) && !empty($_GET['filter'])) {
                                $stmt = $terminet->readFilteredByDate($_GET['filter']);
                            } else {
                                $stmt = $terminet->readAll();
                            }
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

            <?php if ($active_tab == 'doktoret' && !$edit_doktor): ?>
                <h1>Manage Doctors</h1>
                <a href="?tab=add_doktor" class="btn-save" style="margin-bottom: 20px; display: inline-block;">Add New
                    Doctor</a>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Specialization</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $doktoret->read();
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td>{$row['id']}</td>";
                                echo "<td>{$row['emri']}</td>";
                                echo "<td>{$row['mbiemri']}</td>";
                                echo "<td>{$row['specializimi']}</td>";
                                echo "<td>{$row['email']}</td>";
                                echo "<td>{$row['telefoni']}</td>";
                                echo "<td>";
                                echo "<a href='?tab=doktoret&edit_doktor={$row['id']}' class='btn-edit'>Edit</a>";
                                echo "<a href='?delete_doktor={$row['id']}' class='btn-delete' onclick='return confirm(\"Are you sure?\")'>Delete</a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <?php if ($active_tab == 'add_doktor'): ?>
                <h1>Add New Doctor</h1>
                <div class="edit-form-container" style="max-width: 600px; margin: auto;">
                    <form method="POST" action="dashboard.php?tab=add_doktor">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="emri" required>
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="mbiemri" required>
                        </div>
                        <div class="form-group">
                            <label>Specialization</label>
                            <input type="text" name="specializimi" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" name="telefoni">
                        </div>
                        <button type="submit" name="create_doktor" class="btn-save">Add Doctor</button>
                        <a href="dashboard.php?tab=doktoret" class="btn-cancel">Cancel</a>
                    </form>
                </div>

            <?php endif; ?>

            <?php if ($active_tab == 'medikamentet'): ?>
                <?php if (!$edit_medikament && !isset($_GET['add_medikament'])): ?>
                    <h1>Manage Medikamentet</h1>
                    <a href="?tab=medikamentet&add_medikament=1" class="btn-save"
                        style="margin-bottom: 20px; display: inline-block;">Shto Medikament të Ri</a>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Emri</th>
                                    <th>Doza</th>
                                    <th>Çmimi</th>
                                    <th>Përshkrimi</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stmt = $medikamentet->read();
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<tr>";
                                    echo "<td>{$row['id']}</td>";
                                    echo "<td>{$row['emri']}</td>";
                                    echo "<td>{$row['doza']}</td>";
                                    echo "<td>€{$row['cmimi']}</td>";
                                    echo "<td>{$row['pershkrimi']}</td>";
                                    echo "<td>";
                                    echo "<a href='?tab=medikamentet&edit_medikament={$row['id']}' class='btn-edit'>Edit</a>";
                                    echo "<a href='?delete_medikament={$row['id']}' class='btn-delete' onclick='return confirm(\"Jeni të sigurt?\")'>Delete</a>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

                <?php if ($edit_medikament): ?>
                    <div class="edit-form-container">
                        <h3>Edit Medikament: <?= $edit_medikament->emri ?></h3>
                        <form method="POST" action="dashboard.php?tab=medikamentet">
                            <input type="hidden" name="medikament_id" value="<?= $edit_medikament->id ?>">
                            <div class="form-group">
                                <label>Emri</label>
                                <input type="text" name="emri" value="<?= $edit_medikament->emri ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Doza</label>
                                <input type="text" name="doza" value="<?= $edit_medikament->doza ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Çmimi (€)</label>
                                <input type="number" step="0.01" name="cmimi" value="<?= $edit_medikament->cmimi ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Përshkrimi</label>
                                <textarea name="pershkrimi" rows="3"><?= $edit_medikament->pershkrimi ?></textarea>
                            </div>
                            <button type="submit" name="update_medikament" class="btn-save">Save Changes</button>
                            <a href="dashboard.php?tab=medikamentet" class="btn-cancel">Cancel</a>
                        </form>
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['add_medikament'])): ?>
                    <h1>Shto Medikament të Ri</h1>
                    <div class="edit-form-container" style="max-width: 600px; margin: auto;">
                        <form method="POST" action="dashboard.php?tab=medikamentet">
                            <div class="form-group">
                                <label>Emri</label>
                                <input type="text" name="emri" required>
                            </div>
                            <div class="form-group">
                                <label>Doza</label>
                                <input type="text" name="doza" required>
                            </div>
                            <div class="form-group">
                                <label>Çmimi (€)</label>
                                <input type="number" step="0.01" name="cmimi" required>
                            </div>
                            <div class="form-group">
                                <label>Përshkrimi</label>
                                <textarea name="pershkrimi" rows="3"></textarea>
                            </div>
                            <button type="submit" name="create_medikament" class="btn-save">Shto Medikament</button>
                            <a href="dashboard.php?tab=medikamentet" class="btn-cancel">Cancel</a>
                        </form>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

        </div>
    </div>

</body>

</html>