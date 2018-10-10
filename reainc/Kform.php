<?php include("wut.php"); ?>
<div><p><h1>On Point Demographics Subscription Form</h1></p>

<h2>Contact Information</h2>
<i>required fields marked by *</i>
<form action="handle_post.php" method="post">
<p>Last Name* <input type="text" name="last_name" size="20" rows= /></p>
<p>First Name* <input type="text" name="first_name" size="15" /></p>
<p>Middle Initial <input type="text" name="middle_init" size= "1" maxlength="1" /></p>
<p>Company Name* <input type="text" name="company_name" size="30" /></p>
<p>Home County <input type="text" name="home_county" size="15" /></p>
<p>E-mail* <input type="text" name="email" size="20" /></p>
<p>Phone <i>(1234567890)</i> <input type="text" name="phone" size="10" maxlength="10" /></p>

<h2>Desired Subscription</h2>
<p>First County ($10) </br>
<input type="radio" name="first_county" value="Anderson" /> Anderson County
<input type="radio" name="first_county" value="Blount" /> Blount County
<input type="radio" name="first_county" value="Cocke" /> Cocke County
<input type="radio" name="first_county" value="Hamblen" /> Hamblen County
<input type="radio" name="first_county" value="Jefferson" /> Jefferson County
<input type="radio" name="first_county" value="Knox" /> Knox County
<input type="radio" name="first_county" value="Loudon" /> Loudon County
<input type="radio" name="first_county" value="Monroe" /> Monroe County
<input type="radio" name="first_county" value="Sevier" /> Sevier County</p>

Additional Counties ($5/4 counties) <i>(Optional)</i></br>
<i>Do not mark your first county here</i></br>

<input type="checkbox" name="choices[]" value="Anderson" /> Anderson County
<input type="checkbox" name="choices[]" value="Blount" /> Blount County
<input type="checkbox" name="choices[]" value="Cocke" /> Cocke County
<input type="checkbox" name="choices[]" value="Hamblen" /> Hamblen County
<input type="checkbox" name="choices[]" value="Jefferson" /> Jefferson County
<input type="checkbox" name="choices[]" value="Knox" /> Knox County
<input type="checkbox" name="choices[]" value="Loudon" /> Loudon County
<input type="checkbox" name="choices[]" value="Monroe" /> Monroe County
<input type="checkbox" name="choices[]" value="Sevier" /> Sevier County

<input type="submit" value="Submit" />
</form>









