<?php


class Post extends DBConnect
{
    //lists

    //variables result
    public $resultAddPost = false;
    public $resultGetLastPost = false;
    
    //data
    public $lastPost = true;


    public function addPost($user_id, $title, $description, $lat,$lng)
    {
        try
        {
            $stmt = $this -> connection -> prepare('INSERT INTO
            post (id_user, title, description, date, lat, lng, status)
            VALUES(:user_id,:title,:description,"'.date('Y-m-d').'",:lat,:lng,"waiting")');
            $stmt -> bindParam(':user_id',$user_id,PDO::PARAM_STR);
            $stmt -> bindParam(':title',$title,PDO::PARAM_STR);
            $stmt -> bindParam(':description',$description,PDO::PARAM_STR);
            $stmt -> bindParam(':lat',$lat,PDO::PARAM_STR);
            $stmt -> bindParam(':lng',$lng,PDO::PARAM_STR);

            $stmt ->execute();

            $stmt -> closeCursor();
            unset($stmt);

            $this -> resultAddPost = true;
        }
        catch(PDOException $e)
		{
			$this -> resultAddPost = false;
		}
    }
    public function getLastPost()
    {
        try
        {
            $stmt = $this -> connection -> query('SELECT * FROM post ORDER BY id DESC LIMIT 0,1');
            
            $this -> lastPost = $stmt -> fetch();

            $stmt -> closeCursor();
            unset($stmt);

            $this -> resultGetLastPost = true;
        }
        catch(PDOException $e)
		{
			$this -> resultGetLastPost = false;
		}
    }


}