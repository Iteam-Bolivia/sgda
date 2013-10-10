<?php

class token Extends db {
    /*     * * Declare instance ** */

    private static $instance = NULL;
    public $token = NULL;

    /**
     *
     * the constructor is set to private so
     * so nobody can create a new instance using new
     *
     */
    public function __construct() {
        /*         * * maybe set the db name here later ** */
    }

    public function _clear($user_uid) {
        /*         * * create the database registry object ** */
        $registry->db = db::getInstance();
        $sth = $registry->db->prepare("update sys_users_verify set
										usv_status = 0,
										usv_token = ''
										where usv_usr_uid= ? ");
        $sth->execute(array($user_uid));
        //$user = $sth->fetchAll();
        $user = $sth->rowCount();
    }

    public function _create($user_uid) {
        try {
            /*             * * create the database registry object ** */
            $token = sha1(PREFIX . uniqid(rand(), TRUE));
            $registry->db = db::getInstance();
            $sth = $registry->db->prepare("insert into sys_users_verify	(
										usv_usr_uid,
										usv_token,
										usv_ip,
										usv_status,
										usv_date
										)
										value
										( ?,?,?,?,now() )");
            $sth->execute(array($user_uid, $token, $_SERVER['REMOTE_ADDR'], 1));
            //$user = $sth->fetchAll();
            $user = $sth->rowCount();
            if ($user) {
                $this->token = $token;
            }
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function _find($user_uid, $to) {

        /*         * * create the database registry object ** */
        $registry->db = db::getInstance();
        $sth = $registry->db->prepare("select usv_token from sys_users_verify where
										usv_usr_uid = ? and
										usv_token = ? and
										usv_status = 1 ");
        $sth->execute(array($user_uid, $to));
        $row = $sth->fetchAll();
        $user = $sth->rowCount();
        //echo($user_uid.",".$to);
        //echo("<br>".$user."<br>");
        //echo($row[0]['usv_token']);
        //die;

        if ($user) {
            $this->token = $row[0]['usv_token'];
            //echo($this->token);
            return(1);
        } else {
            $this->token = 0;
            return(0);
        }
    }

    /**
     *
     * Like the constructor, we make __clone private
     * so nobody can clone the instance
     *
     */
    private function __clone() {

    }

}

/* * * end of class ** */
?>