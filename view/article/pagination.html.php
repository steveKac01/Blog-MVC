 <nav aria-label="Page navigation example">
     <ul class="pagination justify-content-center">
         <?php if ($page == 0) : ?>
             <li class="page-item disabled">
                 <a class="page-link" href="#" tabindex="-1" aria-disabled="false">Previous</a>
             </li>
         <?php endif; ?>
         <?php if ($page > 0) : ?>
             <li class="page-item">
                 <a class="page-link" href='<?= "/page/" . ($page - 1); ?>'>Previous</a>
             </li>
         <?php endif; ?>
         <?php if ($showNextLink) : ?>
             <li class="page-item">
                 <a class="page-link" href='<?= "/page/" . ($page + 1); ?>'>Next</a>
             </li>
         <?php endif; ?>
         <?php if (!$showNextLink) : ?>
             <li class="page-item disabled">
                 <a class="page-link" href="#" tabindex="-1" aria-disabled="false">Next</a>
             </li>
         <?php endif; ?>
     </ul>
 </nav>