<?php
// Store form values so we can refill the form after submission
$name = $nameErr = $email = $emailErr = $contact = $contactErr = $dob = $dobErr = $position = $positionErr = $resumeErr = $cover = $coverErr = $linkedin = $linkedinErr = $experience = $experienceErr = $skills[] = $skillErr = "";
$errors = [$nameErr , $emailErr, $contactErr, $dobErr, $positionErr, $resumeErr, $coverErr, $experienceErr, $linkedinErr, $skillErr];
// This variable becomes TRUE once the form passes all validation
$success = "false"; 
/**
 * Sanitize user input to prevent XSS (security)
 * - trim() removes extra spaces
 * - htmlspecialchars() escapes HTML characters
 */
function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


/* --------------------------------------------------------------
 *      PROCESS THE FORM ONLY IF THE USER CLICKED "APPLY"
 * --------------------------------------------------------------*/
if($_SERVER["REQUEST_METHOD"]==="POST"){


//Testinput and display error messages too

/* -------------------- FULL NAME --------------------- */
$name = test_input($_POST["name"] ?? "");
if($name== ""){
    $nameErr = "Full Name is required";
}elseif(!preg_match("/^[A-Za-z-' ]$/", $name)){
    $nameErr = "Only Letters and Whitespaces allowed"; 
}

/* -------------------- EMAIL ------------------------- */
$email = test_input($_POST["email"]?? "");
if($email==""){
    $emailErr = "Email is required";
} elseif(!filter_var($email , FILTER_VALIDATE_EMAIL)){
    $emailErr = "Please enter a valid email address";
}


/* -------------------- CONTACT NUMBER ---------------- */
$contact = test_input($_POST["contact"]?? "");
if($contact == ""){
    $contactErr = "Contact Number is required";
} elseif(!preg_match("/^[0-9+]$/", $contact)){
    $contactErr = "Please enter a valid phone number";
}

/* -------------------- DATE OF BIRTH ---------------- */
$dob = test_input ($_POST["dob"]?? "");
if($dob == ""){
    $dobErr = "Date of Birth is required"; 
} 


/* -------------------- POSITION APPLIED FOR ---------- */
$position = test_input($_POST["position"] ?? "");
if($position == ""){
    $positionErr = "Select the position you are applying for ";
}


/* -------------------- RESUME (PDF ONLY) ------------- */
if(empty($_FILES['resume']) || empty($_FILES['resume']['name'])){
    $resumeErr = "Please upload your resume (PDF only)"; 
} else {
    $ext = strtolower(pathinfo($_FILES['resume']['name'], PATHINFO_EXTENSION));
    if($ext !== "pdf" ){
        $resumeErr = "Resume must be a PDF file";
    }
}


/* -------------------- LINKEDIN URL ------------------ */
$linkedin = test_input($_POST["linkedin"]?? "");
if($linkedin == ""){
    $linkedinErr = "Please paste your LinkedIn profile link";
} elseif(!filter_var($linkedin, FILTER_VALIDATE_URL)){
    $linkedinErr = "Please enter a valid URL";
}


/* -------------------- EXPERIENCE -------------------- */
$experience = test_input($_POST["experience"]?? "");
if($experience == ""){
    $experienceErr = "Please Enter your years of experience";
} 


/* -------------------- SKILLS ------------------------ */



/* -------------------- COVER LETTER ------------------ */
$cover = test_input($_POST["cover"] ?? "");
if($cover == ""){
    $coverErr = "Cover Letter is required"; 
}



/* -------------------- SUCCESS CHECK ----------------- */
if(empty($errors)){
    $success = true; 
}

}
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
     <?php 
     if($success == "true"){
        echo "<p> Your Application has been Submitted Successfully </p>";
     }
     ?>
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
<div class ="field">
    <label> Skills </label>
<?php
$skillset = ['HTML', 'CSS', 'JavaScript', 'PHP', 'Java' ]; 
foreach($skillset as $skill){
    $checked = in_array($skill, $skills) ? "checked" : "";
    echo "<label>
    <input type='checkbox' name = 'skill' value = '$skill' $checked > $skill 
    </label>";
} ?>
    <span class = "error"> <?php echo $skillErr ?? "" ; ?> </span>
</div>

    <!--SUBMIT BUTTON-->
<div class = "field">
    <button type = "submit" > Apply </button>
</div>

</div>
</body>
</html>
