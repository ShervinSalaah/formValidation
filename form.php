<?php
// Store form values so we can refill the form after submission

// This variable becomes TRUE once the form passes all validation

/**
 * Sanitize user input to prevent XSS (security)
 * - trim() removes extra spaces
 * - htmlspecialchars() escapes HTML characters
 */


/* --------------------------------------------------------------
 *      PROCESS THE FORM ONLY IF THE USER CLICKED "APPLY"
 * --------------------------------------------------------------*/

//Testinput and display error messages too

/* -------------------- FULL NAME --------------------- */


/* -------------------- EMAIL ------------------------- */



/* -------------------- CONTACT NUMBER ---------------- */


/* -------------------- DATE OF BIRTH ---------------- */



/* -------------------- POSITION APPLIED FOR ---------- */



/* -------------------- RESUME (PDF ONLY) ------------- */



/* -------------------- LINKEDIN URL ------------------ */



/* -------------------- EXPERIENCE -------------------- */



/* -------------------- SKILLS ------------------------ */



/* -------------------- COVER LETTER ------------------ */




/* -------------------- SUCCESS CHECK ----------------- */


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container">
    <h1>Job Application Form</h1>

    <!-- Show success message -->
<p> Your Application has been Submitted Successfully </p>

    <!-- MAIN FORM -->
<form method = "post">

    <!-- FULL NAME -->
<div class = "field">
    <label>Full Name </label>
    <input type="text" name ="name" value = " <?php echo $name; ?> " >
    <span class = "error"> <?php echo $nameErr??"";?> </span>
</div>

    <!-- EMAIL -->
<div class = "field">
    <label> Email </label>
    <input type = "email" name = "email" value = " <?php echo $email; ?> " >
    <span class = "error"> <?php echo $emailErr ?? ""; ?> </span>
</div>  


    <!-- CONTACT -->
<div class = "field">
    <label> Contact Number </label>
    <input type = "text" name = "contact" value = " <?php echo $contact; ?> ">
    <span class = "error"> <?php echo $contactErr ?? ""; ?> </span>
</div>    


    <!-- DOB -->
<div class = "field">
    <label> Date of Birth </label>
    <input type = "date" name = "dob" value = " <?php echo $dob; ?> ">
    <span class = "error"> <?php echo $dobErr ?? ""; ?> </span>


    <!-- POSITION -->
<div class = "field">
    <label>Position Applied For </label>
    <select name="position">
        <option value = ""> Select a position </option>
        <option value = "Software Developer" <?php if($position == "Software Developer") echo "selected";?>> Software Developer </option>
        <option value = "Web Designer" <?php if($position =="Web Designer") echo "selected"; ?>> Web Designer </option>
        <option value = "Project Manager" <?php if($position=="Project Manager") echo "selected"; ?>> Project Manager </option>
    </select> 
</div>       
<span class = "error"> <?php echo $positionErr ?? "" ; ?> </span>

    <!-- RESUME -->
<div class = "field" >
    <label> Upload Resume (PDF only)</label>
    <input type = "file" name = "resume" accept= ".pdf" > 
    <span class = "error" > <?php echo $resumeErr??""; ?> </span>
</div>
    <!--COVER LETTER-->
<div class = "field">
    <label> Cover Letter </label>
    <textarea name="cover" rows="5"> <?php echo $cover; ?> </textarea>
    <span class = "error"><?php echo $coverErr??"";?> </span>
</div>    


    <!-- LINKEDINPROFILE -->
<div class = " field">
    <label> LinkedIn Profile </label>
    <input type = "url" name = "linkedin" value = "<?php echo $linkedin; ?>">
    <span class = "error"> <?php echo $linkedinErr ?? "" ; ?> </span>
</div>     


    <!-- WORK EXPERIENCE (YEARS)-->
<div class = "field">
    <label>Work Experience (Years) </label>
    <input type = "number" name = "experience" value = " <?php echo $experience;?>">
    <span class = "error"> <?php echo $experienceErr ?? "" ; ?> </span>
</div>    


    <!-- SKILLS -->



    <!--SUBMIT BUTTON-->
<div class = "field">
    <button type = "submit" > Apply </button>
</div>

</div>
</body>
</html>
