<form class="border border-1 rounded p-3" method="post">
    <div class="mb-3">
        <label class="form-label" for="content">Content : </label>
        <textarea class="form-control" name="content" id="content" cols="30" rows="10" placeholder="Write Your comment here."><?= isset($comment) ? $comment->getContent() : ""; ?></textarea>
    </div>
    <button class="btn btn-primary" type="submit"><?= isset($buttonLabel) ? $buttonLabel : "Default"; ?></button>
</form>