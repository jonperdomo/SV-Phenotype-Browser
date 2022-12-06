<?php // Converts summary table .csv to HTML table for webpage php
            echo "<html><body><table>\n\n";
            $file_open = fopen("summary_table.csv", "r");
            while (($line = fgetcsv($file_open)) !== false){
                echo "<tr>";
                foreach ($line as $cell) {
                    echo "<td>" . htmlspecialchars($cell) . "</td>";
                }
                echo "</tr>\n";
                }
            fclose($file_open);
            echo "\n</table></body></html>";
        ?> 
