<?php  
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['fname'])) {

    if (isset($_POST['fname']) && 
        isset($_POST['username']) && 
        isset($_POST['email']) && 
        isset($_POST['phone'])) {

        include "../db_conn.php";

        $fname = $_POST['fname'];
        $uname = $_POST['username'];
        $email = $_POST['email'];  // Fix: Correct variable assignment
        $phone = $_POST['phone'];  // Fix: Correct variable assignment
        $old_pp = $_POST['old_pp'];
        $id = $_SESSION['id'];

        if (empty($fname)) {
            $em = "Full name is required";
            header("Location: ../edit.php?error=$em");
            exit;
        } else if (empty($uname)) {
            $em = "Username is required";
            header("Location: ../edit.php?error=$em");
            exit;
        } else if (empty($email)) {
            $em = "Email is required";
            header("Location: ../edit.php?error=$em");
            exit;
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {  // Email validation
            $em = "Invalid email format";
            header("Location: ../edit.php?error=$em");
            exit;
        } else if (empty($phone)) {
            $em = "Phone Number is required";
            header("Location: ../edit.php?error=$em");
            exit;
        } else {

            if (isset($_FILES['pp']['name']) && !empty($_FILES['pp']['name'])) {

                $img_name = $_FILES['pp']['name'];
                $tmp_name = $_FILES['pp']['tmp_name'];
                $error = $_FILES['pp']['error'];

                if ($error === 0) {
                    $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                    $img_ex_to_lc = strtolower($img_ex);

                    $allowed_exs = array('jpg', 'jpeg', 'png');
                    if (in_array($img_ex_to_lc, $allowed_exs)) {
                        $new_img_name = uniqid($uname, true) . '.' . $img_ex_to_lc;
                        $img_upload_path = '../upload/' . $new_img_name;
                        // Delete old profile pic
                        $old_pp_des = "../upload/$old_pp";
                        if (file_exists($old_pp_des)) {  // Check if old profile exists before unlinking
                            unlink($old_pp_des);
                        }
                        move_uploaded_file($tmp_name, $img_upload_path);

                        // Update the Database
                        $sql = "UPDATE users 
                                SET fname=?, username=?, email=?, phone=?, pp=?
                                WHERE id=?";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute([$fname, $uname, $email, $phone, $new_img_name, $id]);
                        $_SESSION['fname'] = $fname;
                        header("Location: ../edit.php?success=Your account has been updated successfully");
                        exit;
                    } else {
                        $em = "You can't upload files of this type";
                        header("Location: ../edit.php?error=$em");
                        exit;
                    }
                } else {
                    $em = "Unknown error occurred!";
                    header("Location: ../edit.php?error=$em");
                    exit;
                }
            } else {
                // No new profile picture, just update the text fields
                $sql = "UPDATE users 
                        SET fname=?, username=?, email=?, phone=?
                        WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$fname, $uname, $email, $phone, $id]);

                header("Location: ../edit.php?success=Your account has been updated successfully");
                exit;
            }
        }
    } else {
        header("Location: ../edit.php?error=error");
        exit;
    }
} else {
    header("Location: login.php");
    exit;
}
