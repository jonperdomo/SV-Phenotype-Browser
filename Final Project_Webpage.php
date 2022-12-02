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
    <br><i>Instructions: Select a phenotype from the dropdown menu below.</i><br>
    <div></div>
    <body> 
        <form method= POST> 
                <label><br>Select a phenotype:<br></label> 
                <select name="phenotype">
                    <option value=''>Select...</option>
                    <option value='BENTA disease'>BENTA disease</option>
                    <option value='Kleefstra syndrome'>Kleefstra syndrome</option>
                    <option value='Kleefstra syndrome 2'>Kleefstra syndrome 2</option>
                    <option value='anemia'>anemia</option>
                    <option value='anxiety'>anxiety</option>
                </select>
        <input type='submit' name='Sumbit' value='Submit'/>
        </form>
        <?php $argvari = $_POST["phenotype"]; echo $argvari; echo " a is " .is_string($argvari)."<br>"?> <?php #this is to just check the dropdown ment ?>

        <?php #display the resulting graphs and summary tables. Update the path according to the your computer. ?>
        <?php $histo = escapeshellcmd('python C:\cygwin64\home\marya\Dropbox\Dropbox\bmes550.MonicaJesteen.mj486\web\Final Project\histo.py "'.$argvari.'"'); $outputh =shell_exec($histo); echo $outputh; ?>
        <?php $sumtabs = escapeshellcmd('python C:\cygwin64\home\marya\Dropbox\Dropbox\bmes550.MonicaJesteen.mj486\web\Final Project\sumtab.py "'.$argvari.'"'); $outputs =shell_exec($sumtabs); echo $outputs; ?>
        <?php $ivg = escapeshellcmd('python C:\cygwin64\home\marya\Dropbox\Dropbox\bmes550.MonicaJesteen.mj486\web\Final Project\ivg.py "'.$argvari.'"'); $outputi =shell_exec($ivg); echo $outputi;?>
       
    </body>
</html>
</html>


