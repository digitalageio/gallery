<form enctype="multipart/form-data" name="upper" method="POST" action="crs2csv.php">
<?php	echo 'select zipped html directory file' ?>
<br />
<input type="file" name="pathname"><br />
<?php echo '</br>','enter the desired output file name' ?>
<br />
<input type="text" name="savepath" size=30><br />
<input type="checkbox" name="columnflag" value="allcolumns">Check to output all possible columns<br />
<input type ="submit" value="submit">
</form>
</html>


