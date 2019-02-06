<?php


class Database
{
    private $db_handler;
    private $table_name = "users";

    public function connect()
    {
        $this->db_handler = new mysqli(__HOST__, __USER__, __PASS__, __DB__);
    }

    public function singup($user_name,$password,$confirm_password,$fname,$image,$cv,$job)
    {
        $error_array = [];
        $image_size = $image['size'];
        $image_temp = $image['tmp_name'];

        $cv_size = $cv['size'];
        $cv_temp = $cv['tmp_name'];

        $sign_name = true;


        if($password != $confirm_password)
        {
            array_push($error_array,"Password & Confirm Password Doesn't Match");
            $sign_name = false;
        }


        if(!empty($user_name))
        {

            $result = $this->db_handler->query("SELECT * FROM $this->table_name WHERE user_name = '$user_name'");
            //$result = $this->db_handler->query("SELECT * FROM ".$this->table_name);

            if (mysqli_num_rows($result) >0) {
                array_push($error_array, "User Name Already Taken");
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
                $Image_directory = "Uploads/Images/";
                $Image_target_file = $Image_directory.$user_name.'.jpg';

                $cv_directory = "Uploads/CVs/";
                $cv_target_file = $cv_directory.$user_name.'.pdf';

                move_uploaded_file($image_temp,$Image_target_file);
                move_uploaded_file($cv_temp,$cv_target_file);

                $sql = "INSERT INTO $this->table_name  VALUES (NULL, '$user_name' , '$password' , '$fname','$job','$user_name.jpg' , '$user_name.pdf', TRUE , FALSE )";
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

        $sql = "SELECT * FROM $this->table_name WHERE user_name = '$user_name' AND password = '$password'";
        $result = $this->db_handler->query($sql);

        if (mysqli_num_rows($result) >0)
        {
            $data = mysqli_fetch_array($result);

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


}