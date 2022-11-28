<html>
<head>
    <br>Explore Phenotypes</br>
</head>
    <body>
        <form method= POST>
                <label for 'Htype[]'><br>Select a phenotype<br></label>
                <select name="phenotype">
                    <option value=''>Select...</option>
                    <option value='P1'>P1</option>
                    <option value='P2'>P2</option>
                    <option value='P3'>P3</option>
                    <option value='P4'>P4</option>
                </select>
        <input type='submit' name='Sumbit' value='Submit'/>
        </form>
    </body>
</html>

<?php system  ("histogram.py ".$_POST["phenotype"]); ?>
<?php system  ("sumtab.py ".$_POST["phenotype"]); ?>
<?php system  ("igvgraph.py ".$_POST["phenotype"]); ?>