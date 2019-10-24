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
    public $resultGetBlockedUsersMod = false;
    public $resultGetRanking = false;
    
    //data
    public $loginCheck = true;
    public $emailCheck = true;
    public $signInList;
    public $getUser;
    public $reactionInfo;
    public $blockedUsersMod;
    public $ranking;

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
            /*
            SELECT user.*, COUNT(IF(user_reaction.reaction = 1, 1, NULL)) AS likes, COUNT(IF(user_reaction.reaction = 0, 1, NULL)) AS dislikes,
            COUNT(IF(post.id = NULL, NULL, 1)) AS n_post, COUNT(IF(cleaned_up.id = NULL, NULL, 1)) AS n_cleaned_up, COUNT(IF(comment.id = NULL, NULL, 1)) AS n_comment
            FROM user, user_reaction, post, cleaned_up, comment WHERE user.id = 3 AND user_reaction.id_user_to = 3
            AND post.id_user = 3 AND cleaned_up.id_user = 3 AND comment.id_user = 3
            AND post.status = "approved" AND cleaned_up.status = "approved" AND comment.status = "approved"
            */


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

    public function getReactionInfo($user_id_to)
    {
        try
        {
            $stmt = $this -> connection -> prepare('SELECT user.id,
            (SELECT COUNT(post.id_user) FROM post WHERE post.id_user = user.id AND post.status="approved") AS posts,
            (SELECT COUNT(cleaned_up.id_user) FROM cleaned_up WHERE cleaned_up.id_user = user.id AND cleaned_up.status="approved") AS cleaned_up,
            (SELECT COUNT(comment.id_user) FROM comment WHERE comment.id_user = user.id AND comment.status=1) AS comments,
            SUM((SELECT COUNT(post.id_user) FROM post WHERE post.id_user = user.id AND post.status="approved") * 10
            + (SELECT COUNT(cleaned_up.id_user) FROM cleaned_up WHERE cleaned_up.id_user = user.id AND cleaned_up.status="approved") * 10
            + (SELECT COUNT(comment.id_user) FROM comment WHERE comment.id_user = user.id AND comment.status=1)*2
            + (SELECT COUNT(IF(post_reaction.reaction = 1, 1, NULL)) FROM post_reaction, post WHERE post.id_user = user.id AND post.id = post_reaction.id_post AND post.status="approved")
            - (SELECT COUNT(IF(post_reaction.reaction = 0, 1, NULL)) FROM post_reaction, post WHERE post.id_user = user.id AND post.id = post_reaction.id_post AND post.status="approved")
            )
            AS points
            FROM user WHERE user.id = :id_to');
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

    

    public function getBlockedUsersMod()
    {
        try
        {
            $stmt = $this -> connection -> query('SELECT * FROM user WHERE status = 0 ORDER BY id DESC LIMIT 0,100');

            $i = 0;
			while($row = $stmt -> fetch())
			{
				$this -> blockedUsersMod[$i] = $row;
                $i++;
			}
            $stmt -> closeCursor();
            unset($stmt);
            $this -> resultGetBlockedUsersMod = true;
        }
        catch(PDOException $e)
		{
			$this -> resultGetBlockedUsersMod = false;
		}
    }


    public function getRanking()
    {
        try
        {
            $stmt = $this -> connection -> query('SELECT user.id, user.login, user.date, 
            (SELECT COUNT(post.id_user) FROM post WHERE post.id_user = user.id AND post.status="approved") AS posts,
            (SELECT COUNT(cleaned_up.id_user) FROM cleaned_up WHERE cleaned_up.id_user = user.id AND cleaned_up.status="approved") AS cleaned_up,
            (SELECT COUNT(comment.id_user) FROM comment WHERE comment.id_user = user.id AND comment.status=1) AS comments,
            SUM((SELECT COUNT(post.id_user) FROM post WHERE post.id_user = user.id AND post.status="approved") * 10
            + (SELECT COUNT(cleaned_up.id_user) FROM cleaned_up WHERE cleaned_up.id_user = user.id AND cleaned_up.status="approved") * 10
            + (SELECT COUNT(comment.id_user) FROM comment WHERE comment.id_user = user.id AND comment.status=1)*2
            + (SELECT COUNT(IF(post_reaction.reaction = 1, 1, NULL)) FROM post_reaction, post WHERE post.id_user = user.id AND post.id = post_reaction.id_post AND post.status="approved")
            - (SELECT COUNT(IF(post_reaction.reaction = 0, 1, NULL)) FROM post_reaction, post WHERE post.id_user = user.id AND post.id = post_reaction.id_post AND post.status="approved")
            )
            AS points
            FROM user WHERE user.status=1 ORDER BY points DESC LIMIT 0,100');

            $i = 0;
			while($row = $stmt -> fetch())
			{
				$this -> ranking[$i] = $row;
                $i++;
			}
            $stmt -> closeCursor();
            unset($stmt);
            $this -> resultGetRanking = true;
        }
        catch(PDOException $e)
		{
			$this -> resultGetRanking = false;
		}
    }
}

?>