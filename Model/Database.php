<?php


class Database
{
    private $db_handler;
    private $table_name = "users";

    public function connect()
    {
        $this->db_handler = new mysqli(__HOST__, __USER__, __PASS__, __DB__);
    }

    public function close_connect()
    {
        if($this->db_handler)
        {
            mysqli_close($this->db_handler);
        }

    }


    public function user_name_exist($user_name,$id = NULL)
    {
        if($id != NULL)
        {
            $result = $this->db_handler->query("SELECT * FROM $this->table_name WHERE user_name = '$user_name' AND id <> '$id'");

        }
        else
            {
                $result = $this->db_handler->query("SELECT * FROM $this->table_name WHERE user_name = '$user_name'");
            }
        //$result = $this->db_handler->query("SELECT * FROM ".$this->table_name);

        if (mysqli_num_rows($result) >0) {
            array_push($error_array, "User Name Already Taken");
            //$sign_name = false;
            return true;
        }
        else
            {
                return false;
            }
    }


    public function singup($user_name,$password,$confirm_password,$fname,$image,$cv,$job)
    {
        $error_array = [];
        $image_size = $image['size'];
        $image_temp = $image['tmp_name'];

        $cv_size = $cv['size'];
        $cv_temp = $cv['tmp_name'];

        $sign_name = true;
        $user_name = trim($user_name);
        $fname = trim($fname);


        if($password != $confirm_password)
        {
            array_push($error_array,"Password & Confirm Password Doesn't Match");
            $sign_name = false;
        }

        if($password == $confirm_password && !empty($password) && !empty($confirm_password))
        {
            if(strlen($password) < 8 || strlen($password) > 16)
            {
                array_push($error_array,"Password must be between  8 & 16 characters ! ");
                $sign_name = false;
            }
        }

        if(!empty($user_name))
        {

            $result = $this->db_handler->query("SELECT * FROM $this->table_name WHERE user_name = '$user_name'");
            if($this->user_name_exist($user_name))
            {
                array_push($error_array, "User Name Already Taken");
                $sign_name = false;
            }

        }

        if(empty($job))
        {
            array_push($error_array,"Enter Your Job ! ");
            $sign_name = false;
        }

        if(empty($image['name']))
        {
            array_push($error_array,"Choose Your Image ! ");
            $sign_name = false;
        }
        else
            {

                $allowed =  array('png' ,'jpg');
                $ext = pathinfo($image['name'], PATHINFO_EXTENSION);

                if( !in_array($ext,$allowed))
                {
                    array_push($error_array,"enter .png or .jpg Image ");
                    $sign_name = false;
                }
            }

        if(empty($cv['name']))
        {
            array_push($error_array,"Choose Your CV ! ");
            $sign_name = false;
        }
        else
            {
                $ext = pathinfo($cv['name'], PATHINFO_EXTENSION);
                if( $ext !== 'pdf')
                {
                    array_push($error_array,"enter .pdf file ");
                    $sign_name = false;
                }

            }



        if(empty($user_name))
        {
            array_push($error_array,"enter user name");
            $sign_name = false;
        }

        if(empty($password) || empty($confirm_password))
        {
            array_push($error_array,"enter password");
            $sign_name = false;
        }

        if ($image_size > 1000000)
        {
            array_push($error_array,"Image Size must be less than 1MB");
            $sign_name = false;
        }

        if($sign_name)
            {
                //$Image_directory = "Uploads/Images/";
                $Image_directory = __Images__Folder__;
                $Image_target_file = $Image_directory.$user_name.'.jpg';

                //$cv_directory = "Uploads/CVs/";
                $cv_directory = __CVs__Folder__;
                $cv_target_file = $cv_directory.$user_name.'.pdf';

                $hashed_password = password_hash($password, PASSWORD_DEFAULT);


                move_uploaded_file($image_temp,$Image_target_file);
                move_uploaded_file($cv_temp,$cv_target_file);

                $sql = "INSERT INTO $this->table_name  VALUES (NULL, '$user_name' , '$hashed_password' , '$fname','$job','$user_name.jpg' , '$user_name.pdf', TRUE , FALSE )";
                $result = $this->db_handler->query($sql);

                if($result)
                {
                    $_SESSION["user_id"] = $user_name;
                    $_SESSION["is_admin"] = false;
                    $_SESSION["fname"] = $fname;
                    $_SESSION["job"] = $job;


                    $dir = $_SERVER['PHP_SELF'];
                    header("$dir");

                }



        }
     return $error_array;
    }

    public function login($user_name,$password)
    {
        $login_error_array = [];

//        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "SELECT * FROM $this->table_name WHERE user_name = '$user_name'";
        $result = $this->db_handler->query($sql);

        if (mysqli_num_rows($result) >0)
        {
            $data = mysqli_fetch_array($result);

            $hashed_password = $data['password'];


            if(password_verify($password, $hashed_password))
            {

//                $data = mysqli_fetch_array($result);

                $_SESSION["id"] = $data['id'];
                $_SESSION["user_id"] = $data['user_name'];

                $_SESSION["is_admin"] = ($data['isadmin'] == 1 ? true : false);

                $_SESSION["fname"] = $data['Fname'];
                $_SESSION["job"] = $data['job'];

//            var_dump($data['user_name']);
//            die();

                $this->set_online($data['user_name']);
                $dir = $_SERVER['PHP_SELF'];
                header("$dir");
            }
            else
                {
                    array_push($login_error_array,"User Name Or password is Wrong !");
                }



        }
        else
            {
                array_push($login_error_array,"User Name Or password is Wrong !");
            }

       return $login_error_array;


    }


    public function signout()
    {
            if(isset($_SESSION["user_id"]))
            {
                $user = $_SESSION["user_id"];
                $this->set_offline($user);
            }

            session_destroy();

            $dir = $_SERVER['PHP_SELF'];
            header("Refresh:0; url=$dir");



    }


    public function set_online($user_name)
    {
        if(isset($user_name))
        {
            $sql = "UPDATE $this->table_name SET isactive = 1 WHERE user_name = '$user_name'";
            $result = $this->db_handler->query($sql);
        }
    }


    public function set_offline($user_name)
    {
        if(isset($user_name))
        {
            $sql = "UPDATE $this->table_name SET isactive = 0 WHERE user_name = '$user_name'";
            $result = $this->db_handler->query($sql);
        }

    }


    public function change_password($old_password,$new_password,$confirm_password)
    {
        $password_error_array = [];
        $change_pass = true;

        if(isset($_SESSION["user_id"]))
        {
            $user = $_SESSION["user_id"];
            $sql = "SELECT * FROM $this->table_name WHERE user_name = '$user'";
            $result = $this->db_handler->query($sql);

            if (mysqli_num_rows($result) >0)
            {
                $data = mysqli_fetch_array($result);

                $saved_password = $data['password'];


                if(!password_verify($old_password, $saved_password))
                {

                    array_push($password_error_array,"Your Old Password Doesn't Match !");
                    $change_pass = false;
                }

                if($new_password != $confirm_password)
                {
                    array_push($password_error_array,"Your Password & Confirm Doesn't Match !");
                    $change_pass = false;
                }

                if(empty($new_password) || empty($confirm_password) || empty($old_password))
                {
                    array_push($password_error_array,"Enter All Fields !");
                    $change_pass = false;
                }

                if($change_pass)
                    {
                        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);


                        $sql = "UPDATE $this->table_name SET password = '$hashed_password' WHERE user_name = '$user'";
                        $result = $this->db_handler->query($sql);

                        if($result)
                        {
                            $this->signout();
                        }

                    }

            }
            else
            {
                array_push($password_error_array,"Some Thing Went Wrong Try again !");
            }

        }


        return $password_error_array;


    }


    public function get_user($user_name)
    {
        $sql = "SELECT * FROM $this->table_name WHERE user_name = '$user_name'";
        $result = $this->db_handler->query($sql);

        if(!empty($result) && $result)
        {
            return $result;
        }

    }


    public function update_data($user_name,$fname,$job,$image_file,$cv_file)
    {
        $update = true;
        $error_array = [];

        if(isset($_SESSION["id"]))
        {
            if($this->user_name_exist($user_name,$_SESSION["id"]))
            {
                array_push($error_array, "User Name Already Taken !");
                $update = false;
            }
        }


        if(empty($user_name))
        {
            array_push($error_array, "Enter User Name !");
            $update = false;
        }

        if(empty($fname))
        {
            array_push($error_array, "Enter Valide  Full Name !");
            $update = false;
        }

        if(empty($job))
        {
            array_push($error_array, "Enter Job !");
            $update = false;
        }



        if($update)
            {
                if(!empty($image_file['name']))
                {
                    $image_temp = $image_file['tmp_name'];

                    $Image_directory = __Images__Folder__;
                    $Image_target_file = $Image_directory.$user_name.'.jpg';
                    move_uploaded_file($image_temp,$Image_target_file);


                }
                if(!empty($cv_file['name']))
                {
                    $cv_temp = $cv_file['tmp_name'];

                    $cv_directory = __CVs__Folder__;
                    $cv_target_file = $cv_directory.$user_name.'.pdf';
                    move_uploaded_file($cv_temp,$cv_target_file);
                }

                $old_user_name =  $_SESSION["user_id"];

                $sql = "UPDATE $this->table_name SET user_name = '$user_name' , Fname = '$fname' ,job = '$job' WHERE user_name = '$old_user_name'";
                $result = $this->db_handler->query($sql);

                if($result)
                {
                    $_SESSION["user_id"] = $user_name;
                    $_SESSION["is_admin"] = false;
                    $_SESSION["fname"] = $fname;
                    $_SESSION["job"] = $job;


                    $dir = __Home_Page__;
                    header("Location:".__Home_Page__);

//                    header("$dir");

                }

            }

        return $error_array;

    }



}