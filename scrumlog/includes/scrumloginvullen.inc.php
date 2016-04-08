<?php
    include 'php/getAllTeachers.php';
?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="doorzichtig">
                    <h1>Scrumlog</h1>
                    <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Show menu bitch</a>
                    <p>
                    <form method="POST" action="php/submitScrumlog.php" class="invullen">
                        Wat heb je gister gedaan knuppel:<br>
                        <input type="text" name="Input_Yesterday" class="invullen" required autofocus><br>
                        wat zat je in de weg:<br>
                        <input type="text" name="Input_Problems" class="invullen" required><br>
                        wat denk je vandaag te bereiken:<br>
                        <input type="text" name="Input_Today" class="invullen" required><br>
                        hulp heb je zeker nodig:<br>
                        <input type="text"  name="Input_Help" class="invullen" required><br>
                        welk van deze slachtoffers moet jouw helpen?<br>
                        <select name="Input_Teacher">
                            <option value="nvt">geen</option>
                            <?php                            
                                foreach($teachersArray as $teacher)
                                {
                                    echo '<option value=' . '"' 
                                            . $teacher['Teacher_ID'] . 
                                            '"' . "> " . $teacher['Firstname'] 
                                            . " " . $teacher['Lastname'] 
                                            . " </option>";
                                }
                            ?>
                        </select><br><br>

                        <button type="submit">Submit</button>
                    </form>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>