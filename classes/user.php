<?php


class User extends DBConnect
{
    //lists

    //variables result
    public $resultRegistrationCheck = false;
    public $resultRegistration = false;
    public $resultSignIn = false;
    public $resultGetUser = false;
    public $resultChangeUserStatus = false;
    public $resultGetReactionInfo = false;
    public $resultEditReaction = false;
    public $resultDeleteReaction = false;
    public $resultAddReaction = false;
    
    //data
    public $loginCheck = true;
    public $emailCheck = true;
    public $signInList;
    public $getUser;
    public $reactionInfo;

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

    public function getUser($user_id)
    {
        try
        {
            $stmt = $this -> connection -> prepare('SELECT user.*, COUNT(IF(user_reaction.reaction = 1, 1, NULL)) AS likes, COUNT(IF(user_reaction.reaction = 0, 1, NULL)) AS dislikes
            FROM user, user_reaction WHERE user.id = :id_user ');
            $stmt -> bindParam(':id_user',$user_id,PDO::PARAM_INT);

            $stmt ->execute();

            $this -> getUser = $stmt -> fetch();

            $stmt -> closeCursor();
            unset($stmt);

            $this -> resultGetUser = true;
        }
        catch(PDOException $e)
		{
			$this -> resultGetUser = false;
		}
    }

    public function changeUserStatus($user_id,$status)
    {
        try
        {
            $stmt = $this -> connection -> prepare('UPDATE user SET status = :status WHERE id = :user_id');
            $stmt -> bindParam(':status',$status,PDO::PARAM_STR);
            $stmt -> bindParam(':user_id',$user_id,PDO::PARAM_INT);

            $stmt ->execute();

            $stmt -> closeCursor();
            unset($stmt);

            $this -> resultChangeUserStatus = true;
        }
        catch(PDOException $e)
		{
			$this -> resultChangeUserStatus = false;
		}
    }

    public function getReactionInfo($user_id_from, $user_id_to)
    {
        try
        {
            $stmt = $this -> connection -> prepare('SELECT * FROM user_reaction WHERE id_user_from = :id_from AND id_user_to = :id_to');
            $stmt -> bindParam(':id_from',$user_id_from,PDO::PARAM_INT);
            $stmt -> bindParam(':id_to',$user_id_to,PDO::PARAM_INT);

            $stmt ->execute();

			$this -> reactionInfo = $stmt -> fetch();

            $stmt -> closeCursor();
            unset($stmt);

            $this -> resultGetReactionInfo = true;
        }
        catch(PDOException $e)
		{
			$this -> resultGetReactionInfo = false;
		}
    }

    public function editReaction($user_id_from, $user_id_to, $reaction)
    {
        try
        {
            $stmt = $this -> connection -> prepare('UPDATE user_reaction SET reaction = :reaction WHERE id_user_from = :id_from AND id_user_to=:id_to');
            $stmt -> bindParam(':reaction',$reaction,PDO::PARAM_STR);
            $stmt -> bindParam(':id_from',$user_id_from,PDO::PARAM_INT);
            $stmt -> bindParam(':id_to',$user_id_to,PDO::PARAM_INT);

            $stmt ->execute();

            $stmt -> closeCursor();
            unset($stmt);

            $this -> resultEditReaction = true;
        }
        catch(PDOException $e)
		{
			$this -> resultEditReaction = false;
		}
    }

    public function addReaction($user_id_from, $user_id_to, $reaction)
    {
        try
        {
            $stmt = $this -> connection -> prepare('INSERT INTO user_reaction (id_user_from, id_user_to, reaction)
            VALUES (:id_from, :id_to, :reaction)');
            $stmt -> bindParam(':reaction',$reaction,PDO::PARAM_STR);
            $stmt -> bindParam(':id_from',$user_id_from,PDO::PARAM_INT);
            $stmt -> bindParam(':id_to',$user_id_to,PDO::PARAM_INT);

            $stmt ->execute();

            $stmt -> closeCursor();
            unset($stmt);

            $this -> resultAddReaction = true;
        }
        catch(PDOException $e)
		{
			$this -> resultAddReaction = false;
		}
    }

    public function deleteReaction($user_id_from, $user_id_to)
    {
        try
        {
            $stmt = $this -> connection -> prepare('DELETE FROM user_reaction
            WHERE id_user_from = :id_from AND id_user_to = :id_to');
            $stmt -> bindParam(':id_from',$user_id_from,PDO::PARAM_INT);
            $stmt -> bindParam(':id_to',$user_id_to,PDO::PARAM_INT);

            $stmt ->execute();

            $stmt -> closeCursor();
            unset($stmt);

            $this -> resultDeleteReaction = true;
        }
        catch(PDOException $e)
		{
			$this -> resultDeleteReaction = false;
		}
    }
}

?>