<?php
/**
 * Created by PhpStorm.
 * User: alireza
 * Date: 11/09/15
 * Time: 1:37 PM
 */

/**
 * @var bool $notToday
 */
?>
<div class="center">
    <img src="/img/Shifts.png"><br><br>
    <h2 style="font-weight: bold;">Sorry.</h2>
    <h2>There are no assigned shifts <br>scheduled for <?= $notToday ? "this day" : "today"?>.</h2>
</div>