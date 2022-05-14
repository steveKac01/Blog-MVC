 <div class="p-3 border border-1 rounded mb-3">

     <?php if (isset($comments) && !empty($comments)) : ?>

         <?php foreach ($comments as $comment) : ?>
             <div class="p-3 border border-1 rounded mb-3" id="comment<?= $comment->getIdComment(); ?>">         
             <h5>Posted by <?= filter_var($comment->getUser()?->getPseudo() ?? 'Anonymous', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?></h5>
             <h6><?= filter_var($comment->getCreatedAt(), FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?></h6>
                 <p> <?= filter_var($comment->getContent(), FILTER_SANITIZE_SPECIAL_CHARS); ?> </p>
                 <?php
                    if (isset($_SESSION['user'])) :
                    ?>
                     <ul class="nav">
                         <?php
                            if (isset($_SESSION['user'])) :
                            ?>
                             <li class="nav-item me-2">
                                 <a class="nav-link btn btn-primary text-light" href="<?= sprintf("/comment/edit/%d/%d", $comment->getIdComment(), $id) ?>">Edit</a>
                             </li>
                             <li class="nav-item me-2">
                                 <a class="nav-link btn btn-danger text-light" href="<?= sprintf("/comment/delete/%d/%d", $comment->getIdComment(), $id) ?>">Delete</a>
                             </li>
                         <?php
                            endif;
                            ?>
                     </ul> <?php endif ?>
             </div>

         <?php endforeach ?>

     <?php else : ?>
         <p>Il n'y a pas encore de commentaires pour cet article.</p>
     <?php endif ?>

 </div>