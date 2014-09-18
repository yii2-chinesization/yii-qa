<div class="container mt20">
    <div class="well">
        <p class="text-center"><?= (is_array($message) ? '<pre>' . print_r($message) . '</pre>' : $message) ?></p>
    </div>
</div>