<html>
<head>
    <style>
        h1 {text-align: center;}
        h3 {text-align: center;}
        h4 {text-align: center;}
    </style>
</head>
    <h1>Exploration of Phenotype</h1>
    <h3>By: Monica Jesteen, Balsam Mohammad, and Jonathan Perdomo</h3>
    <h4>BMES 550-900</h4>
    <br><i>Instructions: Select a phenotype and a chromosome from the dropdown menus below.</i><br>
    <div></div>

    <body> 
        <?php // Query for unique chromosomes and unique phenotypes from sqlite database.
             // Array will be used to populate dropdown menus.
            $db = new SQLite3('sv_phenotypes.sqlite');

            $results_chromsome = $db->query('SELECT DISTINCT chrom FROM sv_phenotypes ORDER BY chrom');
            while ($row_chrom = $results_chromsome->fetchArray(SQLITE3_BOTH)) {
                $chrom_unique[] = $row_chrom[0];
            }
        ?>
        <?php
            $results_phenotype = $db->query('SELECT DISTINCT phenotype FROM sv_phenotypes ORDER BY phenotype');
            while ($row_pheno = $results_phenotype->fetchArray(SQLITE3_BOTH)) {
                $pheno_unique[] = $row_pheno[0];
            }
        ?>
    
        <form method= POST> 
                <label><br>Select a phenotype:<br></label> <?php // Create dropdown menu for phenotypes ?>
                <select name="phenotype">
                    <option selected="selected">Select...</option>
                    <?php 
                        foreach($pheno_unique as $item_phenotype){
                            echo "<option value='implode($item_phenotype)'>$item_phenotype</option>";
                        }
                    ?>
                </select>
                <br>
                <label><br>Select a chromosome:<br></label> <?php // Create dropdown menu for chromosomes ?>
                <select name="chromosome">
                    <option selected="selected">Select...</option>
                    <?php 
                        foreach($chrom_unique as $item_chromosome){
                            echo "<option value='implode($item_chromosome)'>$item_chromosome</option>";
                        }
                    ?>
                </select>
        <input type='submit' name='Sumbit' value='Submit'/>
        </form>

        <?php // Parses form selection to user input in the form of a string.
            $arg_pheno = explode(')',(explode('(',$_POST["phenotype"])[1]))[0]; echo "Selected phenotype: " .$arg_pheno. "<br>"; 
            $arg_chrom = explode(')',(explode('(',$_POST["chromosome"])[1]))[0]; echo "Selected chromosome: " .$arg_chrom. "<br>";
        ?>

        <?php // Display the resulting graphs and summary tables. Update the path according to the your computer. ?>
		<?php $outputtest ="Hello"; echo $outputtest; ?>
        <?php
		$command = escapeshellcmd('python histo.py "'.$arg_pheno.'", "'.$arg_chrom.'"');
		$test2 =shell_exec($command);
		echo $test2;
		?>
		
        <?php $histo = escapeshellcmd('python D:\Program Files\Ampps\www\SV-Phenotype-Browser\histo.py "'.$arg_pheno.'", "'.$arg_chrom.'"'); $outputh =shell_exec($histo); echo $outputh; ?>
        <?php $sumtabs = escapeshellcmd('python D:\Program Files\Ampps\www\SV-Phenotype-Browser\sumtab.py "'.$arg_pheno.'"'); $outputs =shell_exec($sumtabs); echo $outputs; ?>
        <?php $ivg = escapeshellcmd('python D:\Program Files\Ampps\www\SV-Phenotype-Browser\ivg.py "'.$arg_pheno.'", "'.$arg_chrom.'"'); $outputi =shell_exec($ivg); echo $outputi;?>
    </body>
</html>
