
<?php 
include_once('../assets/admin-dash-temp/admin-header.php');
?>
<?php 
include_once('../assets/admin-dash-temp/admin-sidebar.php');
?>



        <!-- Main Content -->
        <main>
            <h1>Analytics</h1>
            <!-- Analyses -->
            <div class="analyse">
                <div class="sales">
                    <div class="status">
                        <div class="info">
                            <h3>Total Sales</h3>
                            <h1>KES 65,024</h1>
                        </div>
                        <div class="progresss">
                            <svg>
                                <circle cx="38" cy="38" r="36"></circle>
                            </svg>
                            <div class="percentage">
                                <p>+81%</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="visits">
                    <div class="status">
                        <div class="info">
                            <h3>Site Visit</h3>
                            <h1>24,981</h1>
                        </div>
                        <div class="progresss">
                            <svg>
                                <circle cx="38" cy="38" r="36"></circle>
                            </svg>
                            <div class="percentage">
                                <p>-48%</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="searches">
                    <div class="status">
                        <div class="info">
                            <h3>Searches</h3>
                            <h1>14,147</h1>
                        </div>
                        <div class="progresss">
                            <svg>
                                <circle cx="38" cy="38" r="36"></circle>
                            </svg>
                            <div class="percentage">
                                <p>+21%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Analyses -->

            <!-- New Users Section -->
            <div class="new-users">
                <h2>New Users</h2>
                <div class="user-list">
                        <!-- Users will be dynamically added here -->
                        <?php
// ... Database connection code ...
//include('../assets/setup/db.php');

$sql = "SELECT * FROM user_info ORDER BY created_at DESC LIMIT 3";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    echo '<div class="user">';
    echo '<img src="../images/true_logo.png">';
    echo '<h2>' . $row['name'] . '</h2>';
    echo '<p>' . date('M d, Y', strtotime($row['created_at'])) . '</p>';
    echo '</div>';
}

// ... Close database connection ...
//mysqli_close($conn);
?>
                    <div class="user">
                        <img src="../images/plus.png">
                        <h2>More</h2>
                        <p>New User</p>
                    </div>
                </div>
            </div>
            <!-- End of New Users Section -->

            <!-- Recent Orders Table -->
            <div class="recent-orders">
                <h2>Recent Orders</h2>
                <table>
                    <thead>
                    <tr>
                            <th>Name</th>
                            <th>Phone Number</th>
                            <th>Status</th>
                            <th>View Details</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        // Establish database connection (you'll need to provide your database credentials here)
                       
                        // Execute SQL query to fetch 4 latest orders data
                        $sql = "SELECT * FROM orders ORDER BY order_time DESC LIMIT 4";

                        $result = mysqli_query($conn, $sql);
                       // Loop through fetched data and generate table rows
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        echo '<td>' . $row['name'] . '</td>';
                        echo '<td>' . $row['number'] . '</td>';
                        echo '<td>' . $row['method'] . '</td>';
                        echo '<td>' . $row['method'] . '</td>';
                        // ... Add more columns as needed
                        echo '</tr>';
                    }

                    // Close the database connection
                    mysqli_close($conn);
                    ?>
                    </tbody>
                </table>
                <a href="load_more.php">View More</a>
            </div>
            <!-- End of Recent Orders -->

        </main>
        <!-- End of Main Content -->

      <?php include_once('../assets/admin-dash-temp/admin-navbar.php');?>
            <div class="user-profile">
                <div class="logo">
                    <img src="../images/true_logo.png">
                    <h2>TrueStyle</h2>
                    <p>Fashion & Modelling Agency</p>
                </div>
            </div>

            <div class="reminders">
                <div class="header">
                    <h2>Reminders</h2>
                    <span class="material-icons-sharp">
                        notifications_none
                    </span>
                </div>

                <div class="notification">
                    <div class="icon">
                        <span class="material-icons-sharp">
                            volume_up
                        </span>
                    </div>
                    <div class="content">
                        <div class="info">
                            <h3>Clotheshop</h3>
                            <small class="text_muted">
                                08:00 AM - 12:00 PM
                            </small>
                        </div>
                        <span class="material-icons-sharp">
                            more_vert
                        </span>
                    </div>
                </div>

                <div class="notification deactive">
                    <div class="icon">
                        <span class="material-icons-sharp">
                            edit
                        </span>
                    </div>
                    <div class="content">
                        <div class="info">
                            <h3>Deliveries</h3>
                            <small class="text_muted">
                                08:00 AM - 12:00 PM
                            </small>
                        </div>
                        <span class="material-icons-sharp">
                            more_vert
                        </span>
                    </div>
                </div>

                <div class="notification add-reminder">
                    <div>
                        <span class="material-icons-sharp">
                            add
                        </span>
                        <h3>Add Reminder</h3>
                    </div>
                </div>

            </div>

        </div>


    </div>

    <?php 
include_once('../assets/admin-dash-temp/admin-footer.php');
?>

 