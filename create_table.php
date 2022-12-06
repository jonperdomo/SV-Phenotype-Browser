<?php // Pull csv file that contains the phenotype varients into webpage and displays the contents to the file
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