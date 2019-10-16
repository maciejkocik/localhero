<?php


class User extends DBConnect
{
    //lists

    //variables result
    public $resultRegistrationCheck = false;
    public $resultRegistration = false;
    public $resultGetLastUser = false;
    
    //variables data
    public $loginCheck = true;
    public $emailCheck = true;
    public $lastUser = false;

    public function registrationCheck($login, $email)
    {
        try
        {
            $stmt = $this -> connection -> prepare('SELECT login, email FROM user WHERE login = :login AND e_mail = :e_mail');
            $stmt -> bindParam(':login',$login,PDO::PARAM_STR);
            $stmt -> bindParam(':e_mail',$email,PDO::PARAM_STR);

            $stmt ->execute();

            while($row = $stmt -> fetch())
			{
                if($row['e_mail'] == $email)
                {
                    $this -> emailCheck = false;
                }
                if($row['login'] == $login)
                {
                    $this -> loginCheck = false;
                }
            }

            $stmt -> closeCursor();
            unset($stmt);
        }
        catch(PDOException $e)
		{
			$this -> resultRegistrationCheck = false;
		}
    }

    public function registration($login, $email, $password)
    {
        try
        {
            $stmt = $this -> connection -> prepare('INSERT INTO
            user (login, password, e_mail, date, moderator, status)
            VALUES(:login, '.$password.', :e_mail,'.date('Y-m-d').',0,1)');
            $stmt -> bindParam(':login',$login,PDO::PARAM_STR);
            $stmt -> bindParam(':e_mail',$email,PDO::PARAM_STR);

            $stmt ->execute();

            $stmt -> closeCursor();
            unset($stmt);

            $this -> resultRegistration = true;
        }
        catch(PDOException $e)
		{
			$this -> resultRegistration = false;
		}
    }

    public function getlastId()
    {
        try
        {
        $stmt = $this -> connection -> query('SELECT * FROM user ORDER BY id DESC LIMIT 0,1');

        $lastUser = $stmt -> fetch();

        $stmt ->execute();

        $stmt -> closeCursor();
        unset($stmt);

        $this -> resultGetLastUser = true;
        }
        catch(PDOException $e)
        {
            $this -> resultGetLastUser = false;
        }
    }
}

?>