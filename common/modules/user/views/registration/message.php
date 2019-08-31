<?php if (!empty($title)): ?>
    <div class="alert alert-info alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <i class="fa fa-check-circle" aria-hidden="true"></i> <?= $title ?>
        <div>$email</div>
    </div>
<?php endif; ?>