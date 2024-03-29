<?php
function error($page, $alert_type, $id, $error_type = "") {
    echo ' <div class="alert alert-'.$alert_type.' alert-dismissible fade show" role="alert">';
    switch($page){
        case 'sign_in':
            switch($id){
                default:
                    echo 'Wystąpił błąd, spróbuj ponownie.';
                    break;
                case 2:
                    echo 'Nieprawidłowy login lub hasło.';
                    break;
                case 3:
                    echo 'Podane konto ma zablokowaną możliwość logowania.';
                    break;    
                case 4: 
                    echo 'Aby kontynuować, musisz się zalogować lub zarejestrować.';
                    break;
            }
            break;
            
        case 'registration':
            if(isset($error_type)){
                switch($error_type){
                    default:
                        echo 'Wystąpił błąd, spróbuj ponownie.';
                        break;
                    case "login_error":
                        switch($id){
                            case 1:
                                echo "Podano błędny login.";
                                break;
                            case 2:
                                echo "Podany login jest zajęty.";
                                break;
                        }
                        break;
                        
                    case "email_error":
                        switch($id){
                            case 1:
                                echo "Podano błędny adres e-mail.";
                                break;
                            case 2:
                                echo "Podany adres e-mail jest już w użyciu.";
                                break;   
                        }
                        break;
                        
                    case "password_error":
                            echo "Podano nieprawidłowe hasło.";
                            break;
                        
                    case "password_error2": 
                            echo "Powtórzone hasło różni się od pierwotnego.";
                            break;

                }
            } else echo 'Wystąpił błąd, spróbuj ponownie.';
            break;
        case 'view_post':
            switch($alert_type) 
            {
                case 'success':
                    switch($id)
                    {
                        case 1:
                        {
                            echo "Wpis dodany pomyślnie.";
                            break;
                        }
                        case 2:
                        {
                            echo "Zmieniono status.";
                            break;
                        }
                        case 3:
                        {
                            echo "Dodano komentarz.";
                            break;
                        }
                        case 4:
                        {
                            echo "Usunięto komentarz.";
                            break;
                        }
                        case 5:
                        {
                            echo "Zmieniono status posprzątania.";
                            break;
                        }
                        case 6:
                        {
                            echo "Usunięto posprzątanie.";
                            break;
                        }
                    }
                    break;
                case 'danger':
                    echo 'Wystąpił błąd.';
            }   
            
            break;

        case 'view_user':
            switch($alert_type){
                case 'success':
                    switch($id)
                    {
                        case 1:
                            echo "Zmieniono status użytkownika.";
                            break;
                    }
                    break;
                    
                case 'danger':
                    echo 'Wystąpił błąd.';
                    break;
            }   
            break;


    }  
    echo '      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
    ';
}

?>