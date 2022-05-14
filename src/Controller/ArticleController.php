<?php

namespace App\Controller;

use PDOException;
use App\Model\Article;
use App\Dao\ArticleDao;
use App\Dao\CommentDao;

class ArticleController
{
    /**
     * Action d'afficher tous les articles en utilisant une pagination
     */
    public function index($page=0)
    {
        $showPagination=false;
        $showNextLink=false;
        try {       
            $articleDao = new ArticleDao();
            $countArticle = $articleDao->countRow();
            if($countArticle>MAX_ARTICLE_DISPLAYED){
                $showPagination=true;
            }
            if($countArticle>($page+1)*MAX_ARTICLE_DISPLAYED-1){
                $showNextLink=true;
            }

            $articles = $articleDao->getAll($page);
            require_once implode(DIRECTORY_SEPARATOR, [VIEW, 'article', 'index.html.php']);
        } catch (PDOException $e) {
            echo $e->getMessage();
            die;
        }
    }



 
    /**
     * Action de créer un nouvel article
     */
    public function new()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /');
            die;
        }

        $args = [
            "title" => [],
            'content' => []
        ];
        $article_post = filter_input_array(INPUT_POST, $args);

        if (isset($article_post['title']) && isset($article_post['content'])) {
            if (empty(trim($article_post['title']))) {
                $error_messages['danger'][] = "Titre inexistant";
            }
            if (empty(trim($article_post['content']))) {
                $error_messages['danger'][] = "Contenu inexistant";
            }

            if (!isset($error_messages)) {
                $article = new Article();
                $article->setTitle($article_post['title'])
                    ->setContent($article_post['content']);

                try {
                    $articleDao = new ArticleDao();
                    $articleDao->new($article);
                } catch (PDOException $e) {
                    echo $e->getMessage();
                    die;
                }

                header(sprintf('Location: /article/show/%d', $article->getIdArticle()));
                die;
            }
        }

        require_once implode(DIRECTORY_SEPARATOR, [VIEW, 'article', 'new.html.php']);
    }

    /**
     * Action d'afficher un article en fonction de son identifiant
     *
     * @param int $id Identifiant de l'article à afficher
     */
    public function show(int $id)
    {
        try {
            $articleDao = new ArticleDao();
            $article = $articleDao->getById($id);
            $commentDao = new CommentDao();
            $comments = $commentDao->getCommentsByArticle($id);

        } catch (PDOException $e) {
            echo $e->getMessage();
            die;
        }

        if (is_null($article)) {
            header('Location: /');
            die;
        }

        require_once implode(DIRECTORY_SEPARATOR, [VIEW, 'article', 'show.html.php']);
    }

    /**
     * Action d'éditer un article en fonction de son identifiant
     *
     * @param int $id Identifiant de l'article à éditer
     */
    public function edit(int $id)
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /');
            die;
        }

        try {
            $articleDao = new ArticleDao();
            $article = $articleDao->getById($id);
        } catch (PDOException $e) {
            echo $e->getMessage();
            die;
        }

        if (is_null($article)) {
            header('Location: /');
            die;
        }

        $args = [
            "title" => [],
            'content' => []
        ];
        $article_post = filter_input_array(INPUT_POST, $args);

        if (isset($article_post['title']) && isset($article_post['content'])) {
            if (empty(trim($article_post['title']))) {
                $error_messages['danger'][] = "Titre inexistant";
            }
            if (empty(trim($article_post['content']))) {
                $error_messages['danger'][] = "Contenu inexistant";
            }

            if (!isset($error_messages)) {
                $article->setTitle($article_post['title'])
                    ->setContent($article_post['content']);

                try {
                    $articleDao->edit($article);
                } catch (PDOException $e) {
                    echo $e->getMessage();
                    die;
                }

                header(sprintf('Location: /article/show/%d', $article->getIdArticle()));
                die;
            }
        }

        require_once implode(DIRECTORY_SEPARATOR, [VIEW, 'article', 'edit.html.php']);
    }

    /**
     * Action de supprimer un article en fonction de son identifiant
     *
     * @param int $id Identifiant de l'article à supprimer
     */
    public function delete(int $id)
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /');
            die;
        }

        try {
            $articleDao = new ArticleDao();
            $articleDao->delete($id);
        } catch (PDOException $e) {
            echo $e->getMessage();
            die;
        }

        header('Location: /');
        die;
    }
}
