<?php

namespace App\Controller;

use App\Dao\UserDao;
use App\Model\User;

class SignupController
{
    /**
     * Action d'enregistrer un nouvel utilisateur (alias inscription)
     */
    public function index()
    {
        if (isset($_SESSION['user'])) {
            header('Location: /');
            die;
        }

        $args = [
            'pseudo' => [],
            'email' => [
                'filter' => FILTER_VALIDATE_EMAIL
            ],
            'pwd' => [],
            'conf_pwd' => []
        ];
        $user_post = filter_input_array(INPUT_POST, $args);

        if (isset($user_post['pseudo']) && isset($user_post['email']) && isset($user_post['pwd']) && isset($user_post['conf_pwd'])) {
            if (empty(trim($user_post['pseudo']))) {
                $error_messages['danger'][] = 'Pseudonym inexistant';
            }
            if (empty($user_post['email'])) {
                $error_messages['danger'][] = 'Email inexistant';
            }
            if (empty(trim($user_post['pwd']))) {
                $error_messages['danger'][] = 'Mot de passe inexistant';
            }
            if (empty(trim($user_post['conf_pwd']))) {
                $error_messages['danger'][] = 'Confirmation mot de passe inexistant';
            }
            if ($user_post['pwd'] !== $user_post['conf_pwd']) {
                $error_messages['danger'][] = 'Les mots de passe ne sont pas identiques';
            }

            if (!isset($error_messages)) {
                try {
                    $userDao = new UserDao();
                    $result = $userDao->getByEmail($user_post['email']);
                } catch (PDOException $e) {
                    echo $e->getMessage();
                    die;
                }

                if (empty($result)) {
                    $user = new User();
                    $user->setPseudo($user_post['pseudo'])
                        ->setEmail($user_post['email'])
                        ->setHashPwd($user_post['pwd']);

                    try {
                        $userDao->new($user);
                    } catch (PDOException $e) {
                        echo $e->getMessage();
                        die;
                    }

                    header('Location: /');
                    die;
                } else {
                    $error_messages['danger'][] = 'Email déjà utilisé';
                }
            }
        }

        require_once implode(DIRECTORY_SEPARATOR, [VIEW, 'sign', 'signup.html.php']);
    }
}
