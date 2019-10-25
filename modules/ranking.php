<?php

$user = new User();

if($user -> resultConnection)
{
    $user -> getRanking();

    if($user -> resultGetRanking)
    {
        $error = -1;
    }
}



switch($error)
{
    case 1:
    {
        echo '<p>Wystąpił błąd.</p>';
        break;
    }
    case -1:
    {
        echo '
        <div class="container">
          <div class="row">
        
        
        <h2 class="text-center display-4" style="margin-top:25px; margin-bottom:30px">Ranking lokalnych bohaterów</h2>

        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Login</th>
                <th scope="col">Punkty</th>
                <th scope="col">Data dołączenia</th>
                <th scope="col">Posty</th>
                <th scope="col">Posprzątania</th>
                <th scope="col">Komentarze</th>
            </tr>
            </thead>
            
            <tbody>';

            $i = 1;
            foreach($user -> ranking as $row)
            {
                echo '
                <tr>
                    <th scope="row">'.$i.'</th>
                    <td>
                        <a href="index.php?page=view_user&user_id='.$row['id'].'">'.$row['login'].'</a>
                    </td>
                    <td>'.$row['points'].'</td>
                    <td>'.$row['date'].'</td>
                    <td>'.$row['posts'].'</td>
                    <td>'.$row['cleaned_up'].'</td>
                    <td>'.$row['comments'].'</td>
                </tr>';

                $i++;
            }
            

        echo '
        </tbody>
        </table>
        
        
        </div>
        </div>';
    }
}
?>