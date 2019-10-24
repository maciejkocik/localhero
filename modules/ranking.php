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
        echo '<h1>Ranking lokalnych bohaterów</h2>
        
        <table>
            <tr>
                <th>Miejsce</th>
                <th>Login</th>
                <th>Punkty</th>
                <th>Data dołączenia</th>
                <th>Posty</th>
                <th>Posprzątania</th>
                <th>Komentarze</th>
            </tr>';

            $i = 1;
            foreach($user -> ranking as $row)
            {
                echo '
                <tr>
                    <td>'.$i.'</td>
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
            

        echo '</table>';
    }
}
?>