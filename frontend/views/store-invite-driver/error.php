<div><?php echo "success"; ?><div class="success_message">
    <?php
    foreach($errors as $sub_error){
        foreach($sub_error as $error){
        echo $error;
        echo "<br/>";
        }
    }; ?>
</div>
</div>
