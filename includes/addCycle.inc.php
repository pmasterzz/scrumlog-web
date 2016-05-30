<?php
/**
 * Created by PhpStorm.
 * User: pepijn
 * Date: 29-5-2016
 * Time: 15:13
 */

$tomorrow = new DateTime('tomorrow');
?>

<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="doorzichtig">
                    <h1>Cyclus toevoegen</h1>
                    <a href="#menu-toggle" class="btn btn-default" id="menu-toggle"><i
                            class="glyphicon glyphicon-arrow-left"></i></a>
                    <div class="row cylcus">
                        <?php
                        if (isset($_GET['msg']))
                            echo '<div class="alert alert-danger">' . $_GET["msg"] . '</div>';
                        ?>
                        <form method="POST" action="php/cycle.php" class="col-lg-3 invullen">
                            <input type="hidden" name="id" value="<?php if (isset($_GET['id'])) echo $_GET['id']; ?>">
                            Start Datum:<br>
                            <input type="date" name="start_date" class="form-control"
                                   value="<?php if (!isset($_GET['start'])) echo date("Y-m-d"); else echo $_GET['start']; ?>"
                                   required><br>
                            Eind Datum:<br>
                            <input type="date" name="end_date" class="form-control"
                                   value="<?php if (!isset($_GET['end'])) echo date("Y-m-d"); else echo $_GET['end']; ?>"
                                   required><br>
                            Cyclus nummer:<br>
                            <input type="number" name="number" class="form-control"
                                   value="<?php if (isset($_GET['num'])) echo $_GET['num']; ?>" required><br>
                            <div class="row">
                                <button class="col-lg-6 cyclusButton"
                                        name="<?php if (isset($_GET['id'])) echo 'wijzigen'; else echo 'toevoegen'; ?>"
                                        data-toggle="tooltip" title="Toevoegen">
                                    <?php if (!isset($_GET['id']))
                                        echo 'Toevoegen';
                                    else
                                        echo 'Opslaan'; ?>
                                </button>
                                <input name="annuleren" type="submit" class="col-lg-6 cyclusButton"
                                       data-toggle="tooltip"
                                       value="Annuleren" formnovalidate/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>