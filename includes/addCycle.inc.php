<?php
/**
 * Created by PhpStorm.
 * User: pepijn
 * Date: 29-5-2016
 * Time: 15:13
 */

$tomorrow = new DateTime('tomorrow');
?>


<div class="doorzichtig">
    <h1>Cyclus toevoegen</h1>
    <a href="#menu-toggle" class="btn btn-default" id="menu-toggle"><i class="glyphicon glyphicon-arrow-left"></i></a>


    <div class="row cylcus">
        <?php
        if (isset($_GET['msg']))
            echo '<div class="alert alert-danger">' . $_GET["msg"] . '</div>';
        ?>
        <form method="POST" action="php/cycle.php" class="col-lg-3 invullen">
            Start Datum:<br>
            <input type="date" name="start_date" class="form-control" value="<?php echo date("Y-m-d") ?>" required><br>
            Eind Datum:<br>
            <input type="date" name="end_date" class="form-control"
                   value="<?php echo $tomorrow->format('Y-m-d') ?>" required><br>
            Cyclus nummer:<br>
            <input type="number" name="number" class="form-control" value="" required><br>
            <div class="row">
                <button class="col-lg-6 cyclusButton" name="toevoegen" data-toggle="tooltip" title="Toevoegen">
                    Toevoegen
                </button>
                <input name="annuleren" type="submit" class="col-lg-6 cyclusButton" data-toggle="tooltip"
                       value="Annuleren" formnovalidate/>
            </div>
        </form>
    </div>
</div>