<?php


class Post extends DBConnect
{
    //lists

    //variables result
    public $resultAddPost = false;
    public $resultGetLastPost = false;
    public $resultGetPost = false;
    public $resultGetComments = false;
    public $resultGetReactionInfo = false;
    public $resultGetOnlyPost = false;
    public $resultChangePostStatus = false;



    
    //data
    public $lastPost = true;
    public $getPost;
    public $comments;
    public $reactionInfo;
    public $onlyPost;


    public function addPost($user_id, $title, $description, $lat, $lng, $status)
    {
        try
        {
            $stmt = $this -> connection -> prepare('INSERT INTO
            post (id_user, title, description, date, lat, lng, status)
            VALUES(:user_id,:title,:description,"'.date('Y-m-d').'",:lat,:lng, :status)');
            $stmt -> bindParam(':user_id',$user_id,PDO::PARAM_STR);
            $stmt -> bindParam(':title',$title,PDO::PARAM_STR);
            $stmt -> bindParam(':description',$description,PDO::PARAM_STR);
            $stmt -> bindParam(':lat',$lat,PDO::PARAM_STR);
            $stmt -> bindParam(':lng',$lng,PDO::PARAM_STR);
            $stmt -> bindParam(':status',$status,PDO::PARAM_STR);

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

    public function getPost($post_id)
    {
        try
        {
            $stmt = $this -> connection -> prepare('SELECT IF(user.id = post.id_user, user.login,NULL) AS p_login, IF(user.id = cleaned_up.id_user, user.id,NULL) AS cu_login,
            post.id AS p_id, post.id_user AS p_id_user, post.title AS p_title, post.description AS p_description, post.date AS p_date, post.lat AS p_lat, post.lng AS p_lng, post.status AS p_status,
            COUNT(IF(post_reaction.reaction = 1, 1, NULL)) AS likes,
            COUNT(IF(post_reaction.reaction = 0, 1, NULL)) AS dislikes,
            cleaned_up.id AS cu_id, cleaned_up.id_user AS cu_id_user, cleaned_up.description AS cu_description, cleaned_up.date AS cu_date, cleaned_up.status AS cu_status
            FROM ((post LEFT JOIN cleaned_up ON post.id = cleaned_up.id_post) LEFT JOIN post_reaction ON post.id = post_reaction.id_post), user 
            WHERE post.id = :post_id');
            
            $stmt -> bindParam(':post_id',$post_id,PDO::PARAM_INT);
            $stmt ->execute();

            $this -> getPost = $stmt -> fetch();

            $stmt -> closeCursor();
            unset($stmt);

            $this -> resultGetPost = true;
        }
        catch(PDOException $e)
		{
			$this -> resultGetPost = false;
		}
    }

    public function getComments($post_id)
    {
        try
        {
            $stmt = $this -> connection -> prepare('SELECT comment.id_user, user.login, comment.text, comment.date
            FROM comment LEFT JOIN user ON comment.id_user = user.id WHERE comment.id_post = :id_post AND comment.status = 1 ORDER BY comment.id DESC LIMIT 0,100');
            $stmt -> bindParam(':id_post',$post_id,PDO::PARAM_INT);

            $stmt ->execute();

            $i = 0;
			while($row = $stmt -> fetch())
			{
				$this->comments[$i] = $row;
				$i++;
			}

            $stmt -> closeCursor();
            unset($stmt);

            $this -> resultGetComments = true;
        }
        catch(PDOException $e)
		{
			$this -> resultGetComments = false;
		}
    }

    public function getReactionInfo($post_id, $user_id)
    {
        try
        {
            $stmt = $this -> connection -> prepare('SELECT * FROM post_reaction WHERE id_post = :id_post AND id_user = :id_user');
            $stmt -> bindParam(':id_post',$post_id,PDO::PARAM_INT);
            $stmt -> bindParam(':id_user',$user_id,PDO::PARAM_INT);

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

    public function getOnlyPost($post_id)
    {
        try
        {
            $stmt = $this -> connection -> prepare('SELECT * FROM post WHERE id = :id_post');
            $stmt -> bindParam(':id_post',$post_id,PDO::PARAM_INT);

            $stmt ->execute();

			$this -> onlyPost = $stmt -> fetch();

            $stmt -> closeCursor();
            unset($stmt);

            $this -> resultGetOnlyPost = true;
        }
        catch(PDOException $e)
		{
			$this -> resultGetOnlyPost = false;
		}
    }

    public function changePostStatus($post_id,$status)
    {
        try
        {
            $stmt = $this -> connection -> prepare('UPDATE post SET status = :status WHERE id = :id_post');
            $stmt -> bindParam(':status',$status,PDO::PARAM_STR);
            $stmt -> bindParam(':id_post',$post_id,PDO::PARAM_INT);

            $stmt ->execute();

            $stmt -> closeCursor();
            unset($stmt);

            $this -> resultChangePostStatus = true;
        }
        catch(PDOException $e)
		{
			$this -> resultChangePostStatus = false;
		}
    }


}