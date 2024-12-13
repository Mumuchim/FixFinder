<?php 
session_start();

if (isset($_POST['email']) && isset($_POST['pass'])) {

    include "../db_conn.php";

    $email = $_POST['email'];
    $pass = $_POST['pass'];

    $data = "email=" . $email;

    if (empty($email)) {
        $em = "Email is required";
        header("Location: ../login.php?error=$em&$data");
        exit;
    } else if (empty($pass)) {
        $em = "Password is required";
        header("Location: ../login.php?error=$em&$data");
        exit;
    } else {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email]);

        if ($stmt->rowCount() == 1) {
            $user = $stmt->fetch();

            $db_email = $user['email'];
            $password = $user['password'];
            $fname = $user['fname'];
            $lname = $user['lname'];
            $id = $user['id'];
            $pp = $user['pp'];
            $role = $user['role']; // Retrieve role from the database
            $uid = $user['uid'];   // Retrieve UID from the database

            if ($db_email === $email) {
                if (password_verify($pass, $password)) {
                    // Store user data in session
                    $_SESSION['id'] = $id;
                    $_SESSION['fname'] = $fname;
                    $_SESSION['lname'] = $lname;
                    $_SESSION['pp'] = $pp;
                    $_SESSION['role'] = $role; // Save role in session
                    $_SESSION['uid'] = $uid;   // Save UID in session

                    // Redirect based on the user's role
                    if ($role === 'admin') {
                        header("Location: ../admin_dashboard.php");
                    } else {
                        header("Location: ../map.php");
                    }
                    exit;
                } else {
                    $em = "Incorrect email or password";
                    header("Location: ../login.php?error=$em&$data");
                    exit;
                }
            } else {
                $em = "Incorrect email or password";
                header("Location: ../login.php?error=$em&$data");
                exit;
            }
        } else {
            $em = "Incorrect email or password";
            header("Location: ../login.php?error=$em&$data");
            exit;
        }
    }
} else {
    header("Location: ../login.php?error=error");
    exit;
}
