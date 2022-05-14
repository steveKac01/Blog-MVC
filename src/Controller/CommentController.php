<?php

namespace App\Controller;

use PDOException;
use App\Dao\CommentDao;
use App\Model\Comment;

class CommentController
{
    /**
     * Action de créer un nouveau commentaire
     */
    public function new($idArticle)
    {
        //Si l'utilisateur n'est pas connecté on le redirige sur la page d'accueil.
        if (!isset($_SESSION['user'])) {
            header('Location: /');
            die;
        }

        //Récupération des informations de l'utilisateur connecté dans l'objet user.
        $user = $_SESSION['user'];

        //Récupération des données de l'utilisateur envoyé en méthode "POST" en utilisant un filtre.
        $args = [
            'content' => []
        ];

        $userComment = filter_input_array(INPUT_POST, $args);

        //Vérification des données :
        if (isset($userComment["content"])) {
            if (empty($userComment["content"])) {
                $error_messages['danger'][] = "Commentaire requis.";
            }

            if (empty($error_messages)) {
                $comment = new Comment();
                $comment->setContent($userComment["content"])
                    ->setUserId($user->getIdUser())
                    ->setArticleId($idArticle);
                try {
                    $commentDao = new CommentDao();
                    $commentDao->new($comment);
                    //Si une exception PDO est levée on retourne un message d'erreur.
                } catch (PDOException $e) {
                    echo $e->getMessage();
                    die;
                }
                header("Location: /article/show/" . $idArticle . "#comment" . $comment->getIdComment());
            }
        }
        //On affiche le formulaire
        $btnName = "Add";
        require_once implode(DIRECTORY_SEPARATOR, [VIEW, 'comment', 'new.html.php']);
    }


    /**
     * Action de supprimer un commentaire en fonction de son identifiant
     *
     * @param int $id Identifiant du commentaire à supprimer
     */
    public function delete($idComment, $idArticle)
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /');
            die;
        }

        try {
            $commentDao = new CommentDao();
            $commentDao->delete($idComment);
            //Si une exception PDO est levée on retourne un message d'erreur.
        } catch (PDOException $e) {
            echo $e->getMessage();
            die;
        }

        header(sprintf('Location: /article/show/%d', $idArticle));
        die;
    }

    /**
     * Action d'éditer un commentaire en fonction de son identifiant
     *
     * @param [type] $idComment Identifiant du commentaire à éditer
     * @param [type] $idArticle Identifiant de l'article
     * @return void
     */
    public function edit($idComment, $idArticle)
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /');
            die;
        }

        $requestMethod = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

        if ('POST' === $requestMethod) {
            $args = [
                'content' => []
            ];
            $comment_post = filter_input_array(INPUT_POST, $args);

            if (isset($comment_post['content'])) {

                if (empty(trim($comment_post['content']))) {
                    $error_messages['danger'][] = "Commentaire requis.";
                }

                if (!isset($error_messages)) {
                    $comment = new Comment();
                    $comment->setContent($comment_post['content'])
                        ->setIdComment($idComment);
                    try {
                        $commentDao = new CommentDao();
                        $commentDao->edit($comment);
                    } catch (PDOException $e) {
                        echo $e->getMessage();
                        die;
                    }
                    header("Location: /article/show/" . $idArticle . "#comment" . $comment->getIdComment());
                    die;
                }
            }
        }
        if ('GET' === $requestMethod) {
            try {
                $commentDao = new CommentDao();
                $comment = $commentDao->getCommentById($idComment);
            } catch (PDOException $e) {
                echo $e->getMessage();
                die;
            }
        }
        //On affiche le formulaire
        $btnName = "Edit";
        require_once implode(DIRECTORY_SEPARATOR, [VIEW, 'comment', 'new.html.php']);
    }
}
