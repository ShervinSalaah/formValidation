<?php
// Store error messages for each field
$errors = [];

// Store form values so we can refill the form after submission
$vals = [
    "fullname"=>"",
    "email"=>"",
    "contact"=>"",
    "dob"=>"",
    "position"=>"",
    "linkedin"=>"",
    "experience"=>"",
    "cover"=>"",
    "skills"=>[]
];

// This variable becomes TRUE once the form passes all validation
$success = false;

/**
 * Sanitize user input to prevent XSS (security)
 * - trim() removes extra spaces
 * - htmlspecialchars() escapes HTML characters
 */
function clean($data){
    return htmlspecialchars(trim($data));
}

/* --------------------------------------------------------------
 *      PROCESS THE FORM ONLY IF THE USER CLICKED "APPLY"
 * --------------------------------------------------------------*/
if($_SERVER["REQUEST_METHOD"] === "POST"){

    /* -------------------- FULL NAME --------------------- */
    $vals['fullname'] = clean($_POST['fullname'] ?? "");
    if ($vals['fullname'] === "") {
        $errors['fullname'] = "Full name is required.";
    }

    /* -------------------- EMAIL ------------------------- */
    $vals['email'] = clean($_POST['email'] ?? "");
    if ($vals['email'] === "") {
        $errors['email'] = "Email is required.";
    } elseif (!filter_var($vals['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Please enter a valid email address.";
    }

    /* -------------------- CONTACT NUMBER ---------------- */
    $vals['contact'] = clean($_POST['contact'] ?? "");
    if ($vals['contact'] === "") {
        $errors['contact'] = "Contact number is required.";
    }
    // Check for digits only, length 10–15
    elseif (!preg_match('/^[0-9]{10,15}$/', $vals['contact'])) {
        $errors['contact'] = "Enter a valid contact number (10–15 digits).";
    }

    /* -------------------- DATE OF BIRTH ---------------- */
    $vals['dob'] = $_POST['dob'] ?? "";
    if ($vals['dob'] === "") {
        $errors['dob'] = "Please select your date of birth.";
    }

    /* -------------------- POSITION APPLIED FOR ---------- */
    $vals['position'] = clean($_POST['position'] ?? "");
    if ($vals['position'] === "") {
        $errors['position'] = "Select the position you are applying for.";
    }

    /* -------------------- RESUME (PDF ONLY) ------------- */
    if (empty($_FILES['resume']) || empty($_FILES['resume']['name'])) {
        $errors['resume'] = "Please upload your resume (PDF only).";
    } else {
        $ext = strtolower(pathinfo($_FILES['resume']['name'], PATHINFO_EXTENSION));
        if ($ext !== "pdf") {
            $errors['resume'] = "Resume must be a PDF file.";
        }
    }

    /* -------------------- LINKEDIN URL ------------------ */
    $vals['linkedin'] = clean($_POST['linkedin'] ?? "");
    if ($vals['linkedin'] === "") {
        $errors['linkedin'] = "LinkedIn profile URL is required.";
    } elseif (!filter_var($vals['linkedin'], FILTER_VALIDATE_URL)) {
        $errors['linkedin'] = "Please enter a valid URL.";
    }

    /* -------------------- EXPERIENCE -------------------- */
    $vals['experience'] = clean($_POST['experience'] ?? "");
    if ($vals['experience'] === "") {
        $errors['experience'] = "Enter your years of experience.";
    }

    /* -------------------- SKILLS ------------------------ */
    $vals['skills'] = $_POST['skills'] ?? [];
    if (count($vals['skills']) === 0) {
        $errors['skills'] = "Please select at least one skill.";
    }

    /* -------------------- COVER LETTER ------------------ */
    $vals['cover'] = clean($_POST['cover'] ?? "");
    if ($vals['cover'] === "") {
        $errors['cover'] = "Cover letter is required.";
    }

    /* -------------------- SUCCESS CHECK ----------------- */
    if (empty($errors)) {
        $success = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Application Form</title>
    <link rel="stylesheet" href="styles.css"> <!-- connect to external css -->
</head>

<body>

<div class="container">
    <h1>Job Application Form</h1>

    <!-- Show success message -->
    <?php if ($success): ?>
        <p class="success">Your application has been submitted successfully!</p>
    <?php endif; ?>

    <!-- MAIN FORM -->
    <form method="post" enctype="multipart/form-data" novalidate>

        <!-- FULL NAME -->
        <div class="field">
            <label>Full Name</label>
            <input type="text" name="fullname" value="<?php echo $vals['fullname']; ?>">
            <span class="error"><?php echo $errors['fullname'] ?? ''; ?></span>
        </div>

        <!-- EMAIL -->
        <div class="field">
            <label>Email Address</label>
            <input type="email" name="email" value="<?php echo $vals['email']; ?>">
            <span class="error"><?php echo $errors['email'] ?? ''; ?></span>
        </div>

        <!-- CONTACT -->
        <div class="field">
            <label>Contact Number</label>
            <input type="text" name="contact" value="<?php echo $vals['contact']; ?>">
            <span class="error"><?php echo $errors['contact'] ?? ''; ?></span>
        </div>

        <!-- DOB -->
        <div class="field">
            <label>Date of Birth</label>
            <input type="date" name="dob" value="<?php echo $vals['dob']; ?>">
            <span class="error"><?php echo $errors['dob'] ?? ''; ?></span>
        </div>

        <!-- POSITION -->
        <div class="field">
            <label>Position Applied For</label>
            <select name="position">
                <option value="">Select a position</option>
                <option value="Software Developer" <?php if($vals['position']=="Software Developer") echo "selected"; ?>>Software Developer</option>
                <option value="Web Designer" <?php if($vals['position']=="Web Designer") echo "selected"; ?>>Web Designer</option>
                <option value="Project Manager" <?php if($vals['position']=="Project Manager") echo "selected"; ?>>Project Manager</option>
            </select>
            <span class="error"><?php echo $errors['position'] ?? ''; ?></span>
        </div>

        <!-- RESUME -->
        <div class="field">
            <label>Resume (PDF only)</label>
            <input type="file" name="resume" accept=".pdf">
            <span class="error"><?php echo $errors['resume'] ?? ''; ?></span>
        </div>

        <!-- LINKEDIN -->
        <div class="field">
            <label>LinkedIn Profile URL</label>
            <input type="url" name="linkedin" value="<?php echo $vals['linkedin']; ?>">
            <span class="error"><?php echo $errors['linkedin'] ?? ''; ?></span>
        </div>

        <!-- EXPERIENCE -->
        <div class="field">
            <label>Work Experience (Years)</label>
            <input type="number" name="experience" value="<?php echo $vals['experience']; ?>">
            <span class="error"><?php echo $errors['experience'] ?? ''; ?></span>
        </div>

        <!-- SKILLS -->
        <div class="field">
            <label>Skills</label>
            <?php
            $skillList = ["HTML","CSS","JavaScript","PHP","Java"];
            foreach ($skillList as $skill) {
                $checked = in_array($skill, $vals['skills']) ? "checked" : "";
                echo "<label><input type='checkbox' name='skills[]' value='$skill' $checked> $skill</label> ";
            }
            ?>
            <span class="error"><?php echo $errors['skills'] ?? ''; ?></span>
        </div>

        <!-- COVER LETTER -->
        <div class="field">
            <label>Cover Letter</label>
            <textarea name="cover" rows="5"><?php echo $vals['cover']; ?></textarea>
            <span class="error"><?php echo $errors['cover'] ?? ''; ?></span>
        </div>

        <!-- SUBMIT BUTTON -->
        <div class="field">
            <button type="submit">Apply</button>
        </div>

    </form>
</div>

</body>
</html>
