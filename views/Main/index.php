
<?php if (isset($messages['message'])): ?>
    <div style="color:green">
        <?php foreach ($messages['message'] as $message): ?>
            <?php echo $message; ?><br>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php if (isset($messages['error'])): ?>
    <div style="color:red">
        <?php foreach ($messages['error'] as $error): ?>
            <?php echo $error; ?><br>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
