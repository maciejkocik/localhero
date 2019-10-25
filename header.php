<?php
include_once('head.php');  


$active = array("","","");

if(isset($_GET['page'])){
    switch($_GET['page']) {
        case "sign_in":
            $active[1] = "active";
            break;
        case "registration":
            $active[2] = "active";
            break;
        default:
            $active[0] = "active";
            break;
    }
} else $active[0] = "active";
?>

        <nav class="navbar navbar-expand-md navbar-dark bg-dark box-shadow">
            <div class="container"><a class="navbar-brand" href="index.php"><i id="navbar-logo" class="material-icons mr-2">public</i><strong>LocalHero</strong></a><button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navcol-1">
                    <?php if(!$signed_in): ?>
                        <ul class="nav navbar-nav">
                            <li class="nav-item"><a class="nav-link" href="index.php?page=ranking"><i class="material-icons">poll</i> Ranking</a></li>
                            <li class="nav-item"><a class="nav-link" href="index.php?page=map"><i class="material-icons">map</i> Mapa</a></li>

                        </ul>
                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item" role="presentation"><a class="nav-link <?php echo $active[0];?>" href="index.php">Strona główna</a></li>
                            <li class="nav-item" role="presentation"><a class="nav-link <?php echo $active[1];?>" href="index.php?page=sign_in">Zaloguj się</a></li>
                            <li class="nav-item" role="presentation"><a class="nav-link <?php echo $active[2];?>" href="index.php?page=registration">Rejestracja</a></li>
                        </ul>  
                    <?php else: ?>
                        <ul class="nav navbar-nav">
                            <li class="nav-item"><a class="nav-link" data-toggle="modal" data-target="#addPost" style="cursor:pointer;"><i class="material-icons">post_add</i> Dodaj problem</a></li>                        
                            <li class="nav-item"><a class="nav-link" href="index.php?page=ranking"><i class="material-icons">poll</i> Ranking</a></li>
                            <li class="nav-item"><a class="nav-link" href="index.php?page=map"><i class="material-icons">map</i> Mapa</a></li>
                        </ul>
                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item dropdown">
                                <a class="dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Witaj, <strong><?php echo $user_login; ?></strong><?php if($user_mod){ echo ' ~ moderator'; }?></a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="index.php?page=view_user">Panel użytkownika</a>
                            <a class="dropdown-item" href="action.php?file=log_out">Wyloguj się</a>
                            <?php
                            
                            if($user_mod)
                            {                            
                                echo '<a class="dropdown-item" href="index.php?page=mod_waiting_posts">Oczekujące wpisy ~ mod.</a>
                                <a class="dropdown-item" href="index.php?page=mod_Removed_posts">Usunięte i prywatne wpisy ~ mod.</a>
                                <a class="dropdown-item" href="index.php?page=mod_waiting_cleaned_up">Oczekujące posprzątania ~ mod.</a>
                                <a class="dropdown-item" href="index.php?page=mod_blocked_users">Zablokowani użytkownicy ~ mod.</a>';
                            }
                            
                            ?>
                            </div>
                            </li>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </nav>