<?php 

include 'db_conn.php';

if (isset($_POST['add_parking'])) {

    $name = $_POST['name'];
    $description = $_POST['description'];
    $barangay = $_POST['barangay'];
    $city = $_POST['city'];

    if ($name == "" || empty($name)) {
        header('Location: admin.php?message=you need to fill up!');
    } else {

      if (isset($_FILES['image']['name']) AND !empty($_FILES['image']['name'])) {
         
         
         $img_name = $_FILES['image']['name'];
         $tmp_name = $_FILES['image']['tmp_name'];
         $error = $_FILES['image']['error'];
         
         if($error === 0){
            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_to_lc = strtolower($img_ex);

            $allowed_exs = array('jpg', 'jpeg', 'png');
            if(in_array($img_ex_to_lc, $allowed_exs)){
               $new_img_name = uniqid($uname, true).'.'.$img_ex_to_lc;
               $img_upload_path = './image/'.$new_img_name;
               move_uploaded_file($tmp_name, $img_upload_path);

               // Insert into Database
               $sql = "INSERT INTO parking_area(name, description, barangay, city, image) 
                 VALUES(?,?,?,?,?)";
               $stmt = $conn->prepare($sql);
               $stmt->execute([$name, $description, $barangay, $city, $new_img_name]);

               header('location:admin.php?insert_msg=Data inserted Succesfully');
                exit;
            }else {
               $em = "You can't upload files of this type";
               header("Location: admin.php?error=$em&$data");
               exit;
            }
         }else {
            $em = "unknown error occurred!";
            header("Location: admin.php?error=$em&$data");
            exit;
         }

        
      }else {
       	$sql = "INSERT INTO parking_area(name, description, barangay, city) 
       	        VALUES(?,?,?,?)";
       	$stmt = $conn->prepare($sql);
       	$stmt->execute([$name, $description, $barangay, $city]);

       	header('location:admin.php?insert_msg=Data inserted Succesfully');
   	    exit;
      }
    }


}else {
	header("Location: admin.php?error=error");
	exit;
}