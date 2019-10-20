<?php


class User extends DBConnect
{
    //lists

    //variables result
    public $resultRegistrationCheck = false;
    public $resultRegistration = false;
    public $resultSignIn = false;
    
    //data
    public $loginCheck = true;
    public $emailCheck = true;
    public $signInList;

    public function registrationCheck($login, $email)
    {
        try
        {
            $stmt = $this -> connection -> prepare('SELECT login, e_mail FROM user WHERE login=:login OR e_mail=:e_mail');
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
            $this -> resultRegistrationCheck = true;
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
            VALUES(:login,"'.$password.'",:e_mail,"'.date('Y-m-d').'",0,1)');
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


    public function signIn($login, $password)
    {
        try
        {
            $stmt = $this -> connection -> prepare('SELECT id, login, moderator, status FROM user WHERE login=:login AND password="'.$password.'"');
            $stmt -> bindParam(':login',$login,PDO::PARAM_STR);

            $stmt ->execute();

            $this -> signInList = $stmt -> fetch();

            $stmt -> closeCursor();
            unset($stmt);

            $this -> resultSignIn = true;
        }
        catch(PDOException $e)
		{
			$this -> resultSignIn = false;
		}
    }
}

?>