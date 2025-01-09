<?php
session_start();
require_once '../conn.php';
$class = "signup";

?>
<?php
$cur_page = 'signup';
include 'includes/inc-header.php';
include 'includes/inc-nav.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $loc = $_POST['loc'];

    if (!isset($name, $email, $password, $phone, $address, $loc)) {
?>
<script>
alert("Ensure you fill the form properly.");
</script>
<?php
    } else {
        // Hash the password
        $password = md5($password);

        // Insert the new user into the database
        $stmt = $conn->prepare("INSERT INTO passenger (name, email, password, phone, address, loc, status) VALUES (?, ?, ?, ?, ?, ?, 1)");
        $stmt->bind_param("ssssss", $name, $email, $password, $phone, $address, $loc);

        if ($stmt->execute()) {
?>
<script>
alert("Signup successful! Please sign in.");
window.location = "signin.php";
</script>
<?php
        } else {
            // Debugging information
            $error = $stmt->error;
?>
<script>
alert("Signup failed. Please try again. Error: <?php echo $error; ?>");
</script>
<?php
        }
    }
}
?>
<div class="signup-page">
    <div class="form">
        <h2>Student Panel</h2>
        <br>
        <form class="login-form" method="post" role="form" id="signup-form" autocomplete="off">
            <!-- json response will be here -->
            <div id="errorDiv"></div>
            <!-- json response will be here -->

            <div class="col-md-12">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" required name="name">
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="text" required name="email">
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" required name="password" id="password">
                    <span class="help-block" id="error"></span>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label>Phone</label>
                   <input required type="tel" class="form-control" name="phone" placeholder="Enter your contact number"
required value="63" type="tel" pattern="\639\d{9}"
oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 12); if (!this.value.startsWith('63')) this.value = '63' + this.value.slice(2);">
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label>Address</label>
                    <input type="text" required name="address">
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label>Location</label>
                    <input type="text" required name="loc">
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <button type="submit" id="btn-signup">
                        SIGN UP
                    </button>
                </div>
            </div>
            <p class="message">
                <a href="signin.php">Already registered? Sign In</a><br>
            </p>
        </form>
    </div>
</div>
<script src="assets/js/jquery-1.12.4-jquery.min.js"></script>
<script src="assets/js/sweetalert2.js"></script>
</body>

</html>