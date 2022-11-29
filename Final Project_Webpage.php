<html>
<head>
    <br>Explore Phenotypes</br>
</head>
    <body>
        <form method= POST>
                <label><br>Select a phenotype<br></label>
                <select name="phenotype">
                    <option value=''>Select...</option>
                    <option value='P1'>P1</option>
                    <option value='P2'>P2</option>
                    <option value='P3'>P3</option>
                    <option value='P4'>P4</option>
                </select>
        <input type='submit' name='Sumbit' value='Submit'/>
        </form>
        <?php
            $checkp = $_POST["phenotype"];
            echo $checkp
        ?>
        <?php $histo= exec("python histogram.py ".$_POST["phenotype"]; $echo $histo); ?>
        <?php $subtabs = exec("python sumtab.py ".$_POST["phenotype"]); echo $subtabs?>
        <?php $ivg = exec("python igvgraph.py ".$_POST["phenotype"]); echo $ivg?>
    </body>
</html>


