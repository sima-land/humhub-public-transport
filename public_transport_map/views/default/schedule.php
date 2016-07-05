<?php



    for ($i=0;$i<count($schedule);$i++) {
        if ($schedule[$i]->comment != "")
        {
            echo "<option>".$schedule[$i]->route->title." (".$schedule[$i]->comment.")</option>";
        }
        else
        {
            echo "<option>".$schedule[$i]->route->title."</option>";
        }
    }