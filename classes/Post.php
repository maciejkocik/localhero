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
    public $resultGetApprovedPosts = false;
    public $resultEditReaction = false;
    public $resultDeleteReaction = false;
    public $resultAddReaction = false;
    public $resultGetPostReactions = false;
    public $resultAddComment = false;
    public $resultGetOnlyComment = false;
    public $resultChangeCommentStatus = false;
    public $resultAddCleanedUp = false;
    public $resultGetLastCleanedUp = false;
    public $resultOnlyCleanedUpByPost = false;
    public $resultOnlyCleanedUp = false;
    public $resultChangeCleanedUpStatus = false;
    public $resultDeleteCleanedUp = false;
    public $resultGetUserPost = false;
    public $resultGetUserCleanedUp = false;
    public $resultGetPostsMod = false;
    public $resultGetCleanedUpMod = false;
    public $resultGetNewPosts = false;
    public $resultGetPopularPosts = false;


    //data
    public $lastPost = true;
    public $getPost;
    public $comments;
    public $reactionInfo;
    public $onlyPost;
    public $approvedPosts;
    public $postReactions;
    public $only_Comment;
    public $onlyCleanedUpByPost;
    public $lastCleanedUp;
    public $onlyCleanedUp;
    public $postsMod;
    public $cleanedUpMod;
    public $newPosts;
    public $popularPosts;


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
            $stmt = $this -> connection -> prepare('SELECT (SELECT user.login FROM user WHERE user.id = post.id_user) AS p_login, (SELECT user.login FROM user WHERE user.id = cleaned_up.id_user) AS cu_login,
            post.id AS p_id, post.id_user AS p_id_user, post.title AS p_title, post.description AS p_description, post.date AS p_date, post.lat AS p_lat, post.lng AS p_lng, post.status AS p_status,
            cleaned_up.id AS cu_id, cleaned_up.id_user AS cu_id_user, cleaned_up.description AS cu_description, cleaned_up.date AS cu_date, cleaned_up.status AS cu_status
            FROM (post LEFT JOIN cleaned_up ON post.id = cleaned_up.id_post), user 
            WHERE post.id = :post_id GROUP BY post.id');
            
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
    public function getPostReactions($post_id)
    {
        try
        {
            $stmt = $this -> connection -> prepare('SELECT COUNT(IF(reaction = 1, 1, NULL)) AS likes, COUNT(IF(reaction = 0, 1, NULL)) AS dislikes FROM post_reaction WHERE id_post = :post_id');
            
            $stmt -> bindParam(':post_id',$post_id,PDO::PARAM_INT);
            $stmt ->execute();

            $this -> postReactions = $stmt -> fetch();

            $stmt -> closeCursor();
            unset($stmt);

            $this -> resultGetPostReactions = true;
        }
        catch(PDOException $e)
		{
			$this -> resultGetPostReactions = false;
		}
    }

    public function getComments($post_id)
    {
        try
        {
            $stmt = $this -> connection -> prepare('SELECT comment.id, comment.id_user, user.login, comment.text, comment.date
            FROM comment LEFT JOIN user ON comment.id_user = user.id WHERE comment.id_post = :id_post AND comment.status = 1 ORDER BY comment.id DESC LIMIT 0,100');
            $stmt -> bindParam(':id_post',$post_id,PDO::PARAM_INT);

            $stmt ->execute();

            $i = 0;
			while($row = $stmt -> fetch())
			{
				$this -> comments[$i] = $row;
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

    public function getOnlyCleanedUpByPost($post_id)
    {
        try
        {
            $stmt = $this -> connection -> prepare('SELECT * FROM cleaned_up WHERE id_post = :id_post');
            $stmt -> bindParam(':id_post',$post_id,PDO::PARAM_INT);

            $stmt ->execute();

			$this -> onlyCleanedUpByPost = $stmt -> fetch();

            $stmt -> closeCursor();
            unset($stmt);

            $this -> resultOnlyCleanedUpByPost = true;
        }
        catch(PDOException $e)
		{
			$this -> resultOnlyCleanedUpByPost = false;
		}
    }
    public function getOnlyCleanedUp($cleaned_up_id)
    {
        try
        {
            $stmt = $this -> connection -> prepare('SELECT * FROM cleaned_up WHERE id = :cleaned_up_id');
            $stmt -> bindParam(':cleaned_up_id',$cleaned_up_id,PDO::PARAM_INT);

            $stmt ->execute();

			$this -> onlyCleanedUp = $stmt -> fetch();

            $stmt -> closeCursor();
            unset($stmt);

            $this -> resultOnlyCleanedUp = true;
        }
        catch(PDOException $e)
		{
			$this -> resultOnlyCleanedUp = false;
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

    public function getApprovedPostsForMap()
    {
        try
        {
            $stmt = $this -> connection -> query('SELECT post.id, post.id_user, post.title, post.date, post.lat, post.lng, post.status,
            IF(CHAR_LENGTH(post.description) > 103, CONCAT(SUBSTR(post.description, 1, 100),"..."), post.description) AS description
             FROM post WHERE status = "approved"');
            
            $i = 0;
			while($row = $stmt -> fetch())
			{
				$this -> approvedPosts[$i] = $row;
				$i++;
			}

            $stmt -> closeCursor();
            unset($stmt);

            $this -> resultGetApprovedPosts = true;
        }
        catch(PDOException $e)
		{
			$this -> resultGetApprovedPosts = false;
		}
    }

    public function editReaction($post_id,$user_id,$reaction)
    {
        try
        {
            $stmt = $this -> connection -> prepare('UPDATE post_reaction SET reaction = :reaction WHERE id_post = :id_post AND id_user=:id_user');
            $stmt -> bindParam(':reaction',$reaction,PDO::PARAM_STR);
            $stmt -> bindParam(':id_post',$post_id,PDO::PARAM_INT);
            $stmt -> bindParam(':id_user',$user_id,PDO::PARAM_INT);

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

    public function addReaction($post_id,$user_id,$reaction)
    {
        try
        {
            $stmt = $this -> connection -> prepare('INSERT INTO post_reaction (id_post, id_user, reaction)
            VALUES (:id_post, :id_user, :reaction)');
            $stmt -> bindParam(':reaction',$reaction,PDO::PARAM_STR);
            $stmt -> bindParam(':id_post',$post_id,PDO::PARAM_INT);
            $stmt -> bindParam(':id_user',$user_id,PDO::PARAM_INT);

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

    public function deleteReaction($post_id,$user_id)
    {
        try
        {
            $stmt = $this -> connection -> prepare('DELETE FROM post_reaction
            WHERE id_post = :id_post AND id_user = :id_user');
            $stmt -> bindParam(':id_post',$post_id,PDO::PARAM_INT);
            $stmt -> bindParam(':id_user',$user_id,PDO::PARAM_INT);

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

    public function addComment($post_id, $user_id,$text)
    {
        try
        {
            $stmt = $this -> connection -> prepare('INSERT INTO comment (id_post, id_user, text, date, status)
            VALUES (:id_post, :id_user, :text,"'.date('Y-m-d').'",1)');
            $stmt -> bindParam(':text',$text,PDO::PARAM_STR);
            $stmt -> bindParam(':id_post',$post_id,PDO::PARAM_INT);
            $stmt -> bindParam(':id_user',$user_id,PDO::PARAM_INT);

            $stmt ->execute();

            $stmt -> closeCursor();
            unset($stmt);

            $this -> resultAddComment = true;
        }
        catch(PDOException $e)
		{
			$this -> resultAddComment = false;
		}
    }
    
    public function getOnlyComment($comment_id)
    {
        try
        {
            $stmt = $this -> connection -> prepare('SELECT * FROM comment WHERE id = :id_comment');
            $stmt -> bindParam(':id_comment',$comment_id,PDO::PARAM_INT);

            $stmt ->execute();

			$this -> onlyComment = $stmt -> fetch();

            $stmt -> closeCursor();
            unset($stmt);

            $this -> resultGetOnlyComment = true;
        }
        catch(PDOException $e)
		{
			$this -> resultGetOnlyComment = false;
		}
    }

    public function changeCommentStatus($comment_id,$status)
    {
        try
        {
            $stmt = $this -> connection -> prepare('UPDATE comment SET status = :status WHERE id = :id');
            $stmt -> bindParam(':id',$comment_id,PDO::PARAM_INT);
            $stmt -> bindParam(':status',$status,PDO::PARAM_INT);

            $stmt ->execute();

            $stmt -> closeCursor();
            unset($stmt);

            $this -> resultChangeCommentStatus = true;
        }
        catch(PDOException $e)
		{
			$this -> resultChangeCommentStatus = false;
		}
    }

    public function addCleanedUp($post_id,$user_id, $description, $status)
    {
        try
        {
            $stmt = $this -> connection -> prepare('INSERT INTO
            cleaned_up (id_post, id_user, description, date, status)
            VALUES(:id_post,:user_id,:description,"'.date('Y-m-d').'",:status)');
            $stmt -> bindParam(':id_post',$post_id,PDO::PARAM_INT);
            $stmt -> bindParam(':user_id',$user_id,PDO::PARAM_INT);
            $stmt -> bindParam(':description',$description,PDO::PARAM_STR);
            $stmt -> bindParam(':status',$status,PDO::PARAM_STR);

            $stmt ->execute();

            $stmt -> closeCursor();
            unset($stmt);

            $this -> resultAddCleanedUp = true;
        }
        catch(PDOException $e)
		{
			$this -> resultAddCleanedUp = false;
		}
    }

    public function getLastCleanedUp()
    {
        try
        {
            $stmt = $this -> connection -> query('SELECT * FROM cleaned_up ORDER BY id DESC LIMIT 0,1');
            
            $this -> lastCleanedUp = $stmt -> fetch();

            $stmt -> closeCursor();
            unset($stmt);

            $this -> resultGetLastCleanedUp = true;
        }
        catch(PDOException $e)
		{
			$this -> resultGetLastCleanedUp = false;
		}
    }


    public function changeCleanedUpStatus($cleaned_up_id, $status)
    {
        try
        {
            $stmt = $this -> connection -> prepare('UPDATE cleaned_up SET status = :status WHERE id = :id');
            $stmt -> bindParam(':status',$status,PDO::PARAM_STR);
            $stmt -> bindParam(':id',$cleaned_up_id,PDO::PARAM_INT);

            $stmt ->execute();

            $stmt -> closeCursor();
            unset($stmt);

            $this -> resultChangeCleanedUpStatus = true;
        }
        catch(PDOException $e)
		{
			$this -> resultChangeCleanedUpStatus = false;
		}
    }

    public function deleteCleanedUp($cleaned_up_id)
    {
        try
        {
            $stmt = $this -> connection -> prepare('DELETE FROM cleaned_up WHERE id = :cleaned_up_id');
            $stmt -> bindParam(':cleaned_up_id',$cleaned_up_id,PDO::PARAM_INT);

            $stmt ->execute();

            $stmt -> closeCursor();
            unset($stmt);

            $this -> resultDeleteCleanedUp = true;
        }
        catch(PDOException $e)
		{
			$this -> resultDeleteCleanedUp = false;
		}
    }

    public function getUserPosts($user_id, &$start_id, &$table)
    {
        try
        {
            $stmt = $this -> connection -> prepare('SELECT post.id, post.id_user, post.title, post.date, post.lat, post.lng, post.status,
            IF(CHAR_LENGTH(post.description) > 103, CONCAT(SUBSTR(post.description, 1, 100),"..."), post.description) AS description
            FROM post WHERE id_user = :id_user ORDER BY id DESC LIMIT 0,20');
            
            $stmt -> bindParam(':id_user',$user_id,PDO::PARAM_INT);
            $stmt ->execute();


			while($row = $stmt -> fetch())
			{
				$table[$start_id] = $row;
                $start_id++;
			}
            $stmt -> closeCursor();
            unset($stmt);
            $this -> resultGetUserPost = true;
        }
        catch(PDOException $e)
		{
			$this -> resultGetUserPost = false;
		}
    }

    public function getUserCleanedUp($user_id, &$start_id, &$table)
    {
        try
        {
            $stmt = $this -> connection -> prepare('SELECT id, id_user, date, status, id_post
            IF(CHAR_LENGTH(description) > 103, CONCAT(SUBSTR(description, 1, 100),"..."), post.description) AS description
            FROM cleaned_up WHERE id_user = :id_user ORDER BY id DESC LIMIT 0,20');
            
            $stmt -> bindParam(':id_user',$user_id,PDO::PARAM_INT);
            $stmt ->execute();


           
			while($row = $stmt -> fetch())
			{
				$table[$start_id] = $row;
				$start_id++;
			}

            $stmt -> closeCursor();
            unset($stmt);

            $this -> resultGetUserCleanedUp = true;
        }
        catch(PDOException $e)
		{
			$this -> resultGetUserCleanedUp = false;
		}
    }

    public function getPostsMod($status)
    {
        try
        {
            $stmt = $this -> connection -> prepare('SELECT post.id, post.id_user, post.title, post.date, post.lat, post.lng, post.status,
            IF(CHAR_LENGTH(post.description) > 103, CONCAT(SUBSTR(post.description, 1, 100),"..."), post.description) AS description
             FROM post WHERE status = :status ORDER BY id ASC LIMIT 0,60');
            
            $stmt -> bindParam(':status',$status,PDO::PARAM_STR);
            $stmt ->execute();

            $i =0;
			while($row = $stmt -> fetch())
			{
				$this -> postsMod[$i] = $row;
                $i++;
			}
            $stmt -> closeCursor();
            unset($stmt);
            $this -> resultGetPostsMod = true;
        }
        catch(PDOException $e)
		{
			$this -> resultGetPostsMod = false;
		}
    }

    public function getCleanedUpMod($status)
    {
        try
        {
            $stmt = $this -> connection -> prepare('SELECT id, id_user, date, status, id_post
            IF(CHAR_LENGTH(description) > 103, CONCAT(SUBSTR(description, 1, 100),"..."), post.description) AS description
            FROM cleaned_up WHERE status = :status ORDER BY id ASC LIMIT 0,60');
            
            $stmt -> bindParam(':status',$status,PDO::PARAM_STR);
            $stmt ->execute();

            $i =0;
			while($row = $stmt -> fetch())
			{
				$this -> cleanedUpMod[$i] = $row;
                $i++;
			}
            $stmt -> closeCursor();
            unset($stmt);
            $this -> resultGetCleanedUpMod = true;
        }
        catch(PDOException $e)
		{
			$this -> resultGetCleanedUpMod = false;
		}
    }

    public function getNewPosts()
    {
        try
        {
            $stmt = $this -> connection -> query('SELECT post.id, post.id_user, post.title, post.date, post.lat, post.lng, post.status,
            IF(CHAR_LENGTH(post.description) > 103, CONCAT(SUBSTR(post.description, 1, 100),"..."), post.description) AS description,
            (SELECT COUNT(IF(post_reaction.reaction = 1, 1, NULL)) FROM post_reaction WHERE post.id = post_reaction.id_post) AS likes,
            (SELECT COUNT(IF(post_reaction.reaction = 0, 1, NULL)) FROM post_reaction WHERE post.id = post_reaction.id_post) AS dislikes
            FROM post WHERE post.status="approved" ORDER BY post.id DESC LIMIT 0,3');

            $i = 0;
			while($row = $stmt -> fetch())
			{
				$this -> newPosts[$i] = $row;
                $i++;
			}
            $stmt -> closeCursor();
            unset($stmt);
            $this -> resultGetNewPosts = true;
        }
        catch(PDOException $e)
		{
			$this -> resultGetNewPosts = false;
		}
    }

    public function getPopularPosts()
    {
        try
        {
            $stmt = $this -> connection -> query('SELECT post.id, post.id_user, post.title, post.date, post.lat, post.lng, post.status,
            IF(CHAR_LENGTH(post.description) > 103, CONCAT(SUBSTR(post.description, 1, 100),"..."), post.description) AS description,
            (SELECT COUNT(IF(post_reaction.reaction = 1, 1, NULL)) FROM post_reaction WHERE post.id = post_reaction.id_post) AS likes,
            (SELECT COUNT(IF(post_reaction.reaction = 0, 1, NULL)) FROM post_reaction WHERE post.id = post_reaction.id_post) AS dislikes
            FROM post WHERE post.status="approved" ORDER BY likes DESC LIMIT 0,3');

            $i = 0;
			while($row = $stmt -> fetch())
			{
				$this -> popularPosts[$i] = $row;
                $i++;
			}
            $stmt -> closeCursor();
            unset($stmt);
            $this -> resultGetPopularPosts = true;
        }
        catch(PDOException $e)
		{
			$this -> resultGetPopularPosts = false;
		}
    }

}