<?php
function createSummaryTable($sv_data) {
	echo "<table border='1'>

	<tr>

	<th>CHROM</th>

	<th>SV_START</th>

	<th>SV_END</th>

	<th>PHENOTYPE</th>

	</tr>";
   while($sv_row = $sv_data->fetchArray(SQLITE3_BOTH))
  {
	  echo "<tr>";

	  echo "<td>" . $sv_row[0] . "</td>";

	  echo "<td>" . $sv_row[1] . "</td>";

	  echo "<td>" . $sv_row[2] . "</td>";

	  echo "<td>" . $sv_row[3] . "</td>";

	  echo "</tr>";
  }
}
?>
