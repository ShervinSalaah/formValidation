<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
</head>
<body>
<!--heading-->
<h1>Job Application Form</h1>
<!--Form start-->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
Full Name <br> <input type="text" name="name" value="<?php echo $name;?>">
<br>
Email<br> <input type="text" name="email" value="<?php echo $email;?>">
<br>
Contact Number<br> <input type="number" name="contact" value="<?php echo $contact;?>">
<br>
Date of Birth <br> <input type="date" name="dob" value="<?php echo $dob;?>">
<br>
Position Applied for<br> 
<!--dropdown list to be included-->
<br>
Upload Resume <br> <input type="file" name="cv">
<!--value to be updated-->
<br>
Cover letter <br> <textarea name="coverLetter" rows="5" cols="40"><?php echo $coverLetter;?></textarea>
<br>
Linkedin Profile<br> <input type="text" name="linkedinProfile" value="<?php echo $linkedinProfile;?>">
<br>
Work Experience(years)<br> <input type="number" name="experience" value="<?php echo $experience;?>">
<br>
Skills <br> 
<input type="checkbox" 
    name="skills" 
    <?php if(isset($skills) && $skills =="HTML")
        echo "checked";?> 
    value="HTML"> HTML
<input type="checkbox"
    name="skills"
    <?php if(isset($skills) && $skills =="CSS")
        echo "checked";?> 
        value="CSS"> CSS
<input type="checkbox"
    name="skills"
    <?php if(isset($skills)&&$skills=="JavaScript")
        echo "checked";?>
    value="JavaScript"> JavaScript

 <input type="checkbox"
 name="skills"
 <?php if(isset($skills)&&skills=="PHP")
    echo "checked";?>
value="PHP"> PHP

<input type="checkbox"
name="skills"
<?php if(isset($skills)&&skills=="Java")
    echo "checked";?>
value="Java"> Java

<br><br><centre><input type="submit" name="submit" value="Apply"></centre>



</form>
</body>
</html>