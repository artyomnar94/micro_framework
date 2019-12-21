<?php 
    /**
     * @var models/Task $task
     */

     use core\views\View;
     use core\views\Field;
?>
<h3>Fill the Form</h3>
<?php 
    //View::renderForm($task, 'index', 'POST', ['userName', 'email', 'text', 'status']) 
    $form = new \core\views\Form($task, 'index', 'post', ['id' => 'MyForm']);
        echo "<div>";
            $form->field('userName')->textInput(['id' => 'UsN', 'style' => 'color:red;']);
        echo "</div>";
        echo "<div>";
            $form->field('email')->radioList(['my@vd.ry' => 'Home', 'job@ds.dd' => 'Job']);
        echo "</div>";
        echo "<div>";
            $form->field('text')->password();
        echo "</div>";
        echo "<div>";
            $form->field('statusa')->number();
        echo "</div>";

        Field::submit();
        Field::reset();
    
    $form->end();
?>
<p>Is Valid: <?=$isValid?></p>
<?php if (!$isValid) : ?>
    <pre>
        <?php print_r($task->errorMessages); ?>
    </pre>
<?php else: ?>
    <pre>
        <?php var_dump($task); ?>
    </pre>
<?php endif; ?>

