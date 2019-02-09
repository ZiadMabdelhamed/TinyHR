<?php


class User
{
    private $db ;

    public function Start_db()
    {
        $this->db = new Database();
    }

    public function get_user_data($user_name)
    {

        $this->db ->connect();

        $user = $this->db->get_user($user_name);

        $this->db ->close_connect();
        return $user;
    }


    public function sign_up()
    {
        $fname = $_POST["fname"];
        $user_name = $_POST["user_name"];
        $password = $_POST["password"];
        $confirm_password = $_POST["confirm_password"];
        $job = $_POST["job"];
        $image_file = $_FILES["image_file"];
        $cv_file = $_FILES["cv_file"];

        $this->db->connect();
        $signup_status = $this->db->singup($user_name,$password,$confirm_password,$fname,$image_file,$cv_file,$job);
        $this->db->close_connect();


        return $signup_status;
    }

    public function login($captcha)
    {
        $user_name = $_POST["user_name"];
        $password = $_POST["password"];


        $this->db->connect();
        $login_status = $this->db->login($user_name,$password,$captcha);
        $this->db->close_connect();

        return $login_status;
    }


    public function signout()
    {
        $this->db->connect();
        $this->db->signout();
        $this->db->close_connect();
    }


    public function change_password()
    {
        $old_password = $_POST["old_password"];
        $new_password = $_POST["new_password"];
        $confirm_password = $_POST["confirm_password"];


        $this->db->connect();
        $change_password_status = $this->db->change_password($old_password,$new_password,$confirm_password);
        $this->db->close_connect();

        return $change_password_status;
    }


    public function update_user_data()
    {
        $user_name = $_POST["user_name"];
        $fname = $_POST["fname"];
        $job = $_POST["job"];


        $image_file = $_FILES["image_file"];
        $cv_file = $_FILES["cv_file"];

        $this->db->connect();
        $update_data_status = $this->db->update_data($user_name,$fname,$job,$image_file,$cv_file);
        $this->db->close_connect();

        return $update_data_status;
    }

}