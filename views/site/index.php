<?php 
    /**
     * @var models/Task $task
     */

     use core\views\View;
?>
<h3>Fill the Form</h3>
<?php View::renderForm($task, 'index', 'POST', ['userName', 'email', 'text']) ?>
<p>Is Valid: <?=$isValid?></p>
<?php if (!$isValid) : ?>
    <pre>
        <?php print_r($task->errorMessages); ?>
    </pre>
<?php endif; ?>
