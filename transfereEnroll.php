<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration Form</title>
    <link rel="stylesheet" href="enrol.css">
</head>
<body>

    <div class="container">
        <div class="form-header">
            <div class="logo">
                <img src="log1.jpg" alt="School Logo" width="150">
            </div>
            <h1>Welcome Student</h1>
            <h3>transferee Student Registration Form</h3>
            <p>Fill out the form to access the SMS and view your records.</p>
        </div>
        <form action="register_old.php" method="POST">
            <h2>Student Information</h2>
            <div class="form-group">
                <input type="text" name="fName" placeholder="First Name" 
                pattern="^[A-Za-z\s]+$" title="First name must contain only letters and spaces." required>

                <input type="text" name="mName" placeholder="Middle Name"
                pattern="^[A-Za-z\s]*$" title="Middle name must contain only letters and spaces.">

                <input type="text" name="lName" placeholder="Last Name" 
                pattern="^[A-Za-z\s]+$" title="Last name must contain only letters and spaces."  required>

                <input type="text" name="extName" placeholder="Extension (Jr., III, etc.)"
                pattern="^(Jr\.?|Sr\.?|II|III|IV|V)?$" 
                title="Valid extensions: Jr, Sr, II, III, IV, V (leave blank if none)">

                <input type="date" name="birthdate" id= "birthdate"required>
                <input type="number" name="age" placeholder= "Age">
            </div>
            <div class="form-group">
                <input type="text" name="place" placeholder= "Place of Birth" 
                pattern="^[A-Za-z\s\-\.]{2,100}$" 
                title="Enter a valid place of birth (letters, spaces, dots, hyphens only)" required>

                <input type="text" name="studentID" placeholder="LRN"
                 pattern="\d{12}" title="LRN must be exactly 12 digits" required>

                <input type="text" name="religion" placeholder= "Religion"
                pattern="^[A-Za-z\s\-]{2,50}$" 
                title="Enter a valid religion (letters and spaces only)" required>
            </div>
            <td>
                <select name="gender" required>
                    <option value="" disabled selected>Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </td>
          

            <h2>Address</h2>
            <div class="form-group">
                <input type="text" name="street" placeholder="Street Address"
                pattern="^[0-9A-Za-z\s\.,#\-]{5,100}$" 
                title="Enter a valid street address (letters, numbers, ., #, -, ,)"  required>
            </div>
            <div class="form-group">
                <input type="text" name="city" placeholder="City"
                pattern="^[A-Za-z\s\-\.]{2,50}$"
                 title="Enter a valid city name (letters, spaces, hyphens)"  required>

                <input type="text" name="state" placeholder="State / Province"
                pattern="^[A-Za-z\s\-]{2,50}$" 
                title="Enter a valid state or province (letters, spaces, hyphens)"  required>
            </div>
            <div class="form-group">
                <input type="text" name="country" placeholder="Country"
                pattern="^[A-Za-z\s]{2,56}$" 
                title="Enter a valid country name (letters and spaces only)"  required>

                <input type="text" name="zip" placeholder="ZIP Code" 
                pattern="^\d{4}$" title="Please enter a 4-digit ZIP code" required>
            </div>

            <h2>Contact Information</h2>
            <div class="form-group">
                <input type="email" name="email" placeholder="E-mail" 
                pattern="^[a-zA-Z0-9._%+-]+@gmail\.com$" 
                title="Please enter a valid Gmail address only (e.g., yourname@gmail.com)"  required>

                <input type="text" name="contactNumber" placeholder="Contact Number" 
                 pattern="(\+63\s?9\d{2}\s?\d{3}\s?\d{4}|09\d{9})" 
                 title="Enter a valid Philippine mobile number (e.g., 09123456789 or +639123456789)" required>
            </div>

            <h2>Strand</h2>
            <table>
            <tr>
                    <th>Strand</th>
                    <th>Level</th>
                    <th>Semester</th>
                    <th>School Year</th>
                </tr>
                <tr>
                    <td>
                        <select name="strand" required>
                            <option value="" disabled selected>Select Strand</option>
                            <option value="ABM">ABM</option>
                            <option value="HUMSS">HUMSS</option>
                            <option value="STEM">STEM</option>
                            <option value="GAS">GAS</option>
                            <option value="TVL">TVL</option>
                        </select>
                    </td>
                    <td>
                        <select name="level" required>
                            <option value="" disabled selected>Select Level</option>
                            <option value="Grade 11">Grade 11</option>
                            <option value="Grade 12">Grade 12</option>
                        </select>
                    </td>
                    <td>
                        <select name="semester" required>
                            <option value="" disabled selected>Select Semester</option>
                            <option value="1st Semester">1st Semester</option>
                            <option value="2nd Semester">2nd Semester</option>
                        </select>
                    </td>
                    <td>
                        <label for="schoolYear">School Year:</label>
                        <select id="schoolYear" name="school_year" required>
                        </select>
                    </td>
                    
                </tr>
            </table>

            <div class="button-group">
                <button type="submit" class="submit-btn">Submit</button>
                <button type="button" class="close-btn" onclick="window.location.href='Option.php'">&times;</button>
            </div>
        </form>
    </div>
    <script src="enrol.js"></script>

</body>
</html>




<script>
        // Function to set up the school years in the dropdown
        function setSchoolYears() {
            const currentYear = new Date().getFullYear();
            const schoolYearSelect = document.getElementById("schoolYear");

            // Populate school years for the next 5 years (adjust as needed)
            for (let i = 0; i < 5; i++) {
                const startYear = currentYear + i;
                const endYear = startYear + 1;
                const option = document.createElement("option");
                option.value = `${startYear}-${endYear}`;
                option.textContent = `${startYear}-${endYear}`;
                schoolYearSelect.appendChild(option);
            }

            // Automatically select the current school year
            const currentSchoolYear = `${currentYear}-${currentYear + 1}`;
            schoolYearSelect.value = currentSchoolYear;
        }

        // Call the function when the page loads
        window.onload = setSchoolYears;
    </script>
