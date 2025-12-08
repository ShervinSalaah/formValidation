<?php
// Store form values so we can refill the form after submission
$errors = [];
$values = [
    "name" => "",
    "email" => "",
    "contact" => "",
    "dob" => "",
    "position" => "",
    "resume" => "",
    "cover" => "",
    "linkedin" => "",
    "experience" => "",
    "skills" => []
];

// This becomes TRUE when the form is successfully validated
$success = false;

/* ---------------- SANITIZE INPUT ---------------- */
function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/* ---------------- PROCESS AFTER SUBMIT ---------------- */
if($_SERVER["REQUEST_METHOD"]==="POST"){

/* ---------- FULL NAME ---------- */
$values['name'] = test_input($_POST['name'] ?? "");
if($values['name']== ""){
    $errors['name'] = "Full Name is required";
} elseif(!preg_match("/^[A-Za-z-' ]+$/", $values['name'])){
    $errors['name'] = "Only letters and whitespace allowed";
}

/* ---------- EMAIL ---------- */
$values['email'] = test_input($_POST['email'] ?? "");
if($values['email']==""){
    $errors['email'] = "Email is required";
} elseif(!filter_var($values['email'], FILTER_VALIDATE_EMAIL)){
    $errors['email'] = "Please enter a valid email address";
}

/* ---------- CONTACT ---------- */
$values['contact'] = test_input($_POST['contact'] ?? "");
if($values['contact']==""){
    $errors['contact'] = "Contact number is required";
} elseif(!preg_match("/^[0-9+]{10,15}$/", $values['contact'])){
    $errors['contact'] = "Please enter a valid phone number (10–15 digits)";
}

/* ---------- DOB ---------- */
$values['dob'] = $_POST['dob'] ?? "";
if($values['dob']==""){
    $errors['dob'] = "Date of Birth is required";
}

/* ---------- POSITION ---------- */
$values['position'] = test_input($_POST['position'] ?? "");
if($values['position']==""){
    $errors['position'] = "Select a position";
}

/* ---------- RESUME ---------- */
if(empty($_FILES['resume']['name'])){
    $errors['resume'] = "Please upload your resume (PDF only)";
} else {
    $ext = strtolower(pathinfo($_FILES['resume']['name'], PATHINFO_EXTENSION));
    if($ext !== "pdf"){
        $errors['resume'] = "Resume must be PDF";
    }
}

/* ---------- LINKEDIN ---------- */
$values['linkedin'] = test_input($_POST['linkedin'] ?? "");
if($values['linkedin']==""){
    $errors['linkedin'] = "LinkedIn profile link required";
} elseif(!filter_var($values['linkedin'], FILTER_VALIDATE_URL)){
    $errors['linkedin'] = "Invalid URL";
}

/* ---------- EXPERIENCE ---------- */
$values['experience'] = test_input($_POST['experience'] ?? "");
if($values['experience']==""){
    $errors['experience'] = "Enter years of experience";
}

/* ---------- SKILLS ---------- */
$values['skills'] = $_POST['skills'] ?? [];
if(count($values['skills']) == 0){
    $errors['skills'] = "Select at least one skill";
}

/* ---------- COVER LETTER ---------- */
$values['cover'] = test_input($_POST['cover'] ?? "");
if($values['cover']==""){
    $errors['cover'] = "Cover letter is required";
}

/* ---------- SUCCESS ---------- */
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
    <title>Job Application</title>
    <link href="./styles.css" rel = "stylesheet" >
</head>
<body>

<div class="container">
    <h1>Job Application Form</h1>

    <!-- SUCCESS MESSAGE -->
    <?php if($success): ?>
        <p class = "success">
            Your application has been submitted successfully!
        </p>
    <?php    $values = [
        "name" => "",
        "email" => "",
        "contact" => "",
        "dob" => "",
        "position" => "",
        "resume" => "",
        "cover" => "",
        "linkedin" => "",
        "experience" => "",
        "skills" => []
    ];
     endif; ?>

<form method="post" enctype="multipart/form-data">
<p class="error"> * All fields are required </p>
<!-- NAME -->
<div class="field">
    <label>Full Name</label>
    <input type="text" name="name" value="<?php echo $values['name']; ?>">
    <span class="error"><?php echo $errors['name'] ?? ""; ?></span>
</div>

<!-- EMAIL -->
<div class="field">
    <label>Email</label>
    <input type="email" name="email" value="<?php echo $values['email']; ?>">
    <span class="error"><?php echo $errors['email'] ?? ""; ?></span>
</div>

<!-- CONTACT -->
<div class="field">
    <label>Contact Number</label>
    <input type="text" name="contact" value="<?php echo $values['contact']; ?>">
    <span class="error"><?php echo $errors['contact'] ?? ""; ?></span>
</div>

<!-- DOB -->
<div class="field">
    <label>Date of Birth</label>
    <input type="date" name="dob" value="<?php echo $values['dob']; ?>">
    <span class="error"><?php echo $errors['dob'] ?? ""; ?></span>
</div>

<!-- POSITION -->
<div class="field">
    <label>Position Applied For</label>
    <select name="position">
        <option value="">Select a position</option>
        <option value="Software Developer" <?php if($values['position']=="Software Developer") echo "selected"; ?>>Software Developer</option>
        <option value="Web Designer" <?php if($values['position']=="Web Designer") echo "selected"; ?>>Web Designer</option>
        <option value="Project Manager" <?php if($values['position']=="Project Manager") echo "selected"; ?>>Project Manager</option>
    </select>
    <span class="error"><?php echo $errors['position'] ?? ""; ?></span>
</div>

<!-- RESUME -->
<div class="field">
    <label>Upload Resume (PDF)</label>
    <input type="file" name="resume" accept=".pdf">
    <span class="error"><?php echo $errors['resume'] ?? ""; ?></span>
</div>

<!-- COVER LETTER -->
<div class="field">
    <label>Cover Letter</label>
    <textarea name="cover" rows="5"><?php echo $values['cover']; ?></textarea>
    <span class="error"><?php echo $errors['cover'] ?? ""; ?></span>
</div>

<!-- LINKEDIN -->
<div class="field">
    <label>LinkedIn Profile</label>
    <input type="url" name="linkedin" value="<?php echo $values['linkedin']; ?>">
    <span class="error"><?php echo $errors['linkedin'] ?? ""; ?></span>
</div>

<!-- EXPERIENCE -->
<div class="field">
    <label>Work Experience (Years)</label>
    <input type="number" name="experience" value="<?php echo $values['experience']; ?>">
    <span class="error"><?php echo $errors['experience'] ?? ""; ?></span>
</div>

<!-- SKILLS -->
<div class="field">
    <label>Skills</label>
    <?php
    $skillset = ['HTML','CSS','JavaScript','PHP','Java'];
    foreach($skillset as $skill){
        $checked = in_array($skill, $values['skills']) ? "checked" : "";
        echo "<label><input type='checkbox' name='skills[]' value='$skill' $checked> $skill </label>";
    }
    ?>
    <span class="error"><?php echo $errors['skills'] ?? ""; ?></span>
</div>

<!-- SUBMIT -->
<div class="field">
    <button type="submit">Apply</button>
</div>

</form>
</div>

</body>
</html>
