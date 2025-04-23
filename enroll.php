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
            <p>Fill out the form to access the SMS and view your records.</p>
        </div>
        <form action="register.php" method="POST">
            <!-- Student Type Section -->
            <h2>Student Type</h2>
            <div class="form-group">
                <select name="studentType" id="studentType" required>
                    <option value="" disabled selected>Select Student Type</option>
                    <option value="New Student">New Student</option>
                    <option value="Old Student">Old Student</option>
                    <option value="Transferee Student">Transferee Student</option>
                </select>
            </div>

            <!-- Form for New Student or Transferee Student -->
            <div id="newStudentForm" style="display:none;">
                <h3>Student Registration Form</h3>
                <div class="form-group">
                    <input type="text" name="fName" placeholder="First Name" required pattern="^[A-Za-z\s]+$" title="First name must contain only letters and spaces.">
                    <input type="text" name="mName" placeholder="Middle Name" pattern="^[A-Za-z\s]*$" title="Middle name must contain only letters and spaces.">
                    <input type="text" name="lName" placeholder="Last Name" required pattern="^[A-Za-z\s]+$" title="Last name must contain only letters and spaces.">
                    <input type="text" name="extName" placeholder="Extension (Jr., III, etc.)" pattern="^(Jr\.?|Sr\.?|II|III|IV|V)?$" title="Valid extensions: Jr, Sr, II, III, IV, V (leave blank if none)">
                    <input type="date" name="birthdate" required>
                    <input type="number" name="age" placeholder="Age">
                </div>

                <div class="form-group">
                    <input type="text" name="place" placeholder="Place of Birth" required pattern="^[A-Za-z\s\-\.]{2,100}$" title="Enter a valid place of birth (letters, spaces, dots, hyphens only)">
                    <input type="text" name="student_id" placeholder="LRN" required pattern="\d{12}" title="LRN must be exactly 12 digits">
                    <input type="text" name="religion" placeholder="Religion" required pattern="^[A-Za-z\s\-]{2,50}$" title="Enter a valid religion (letters and spaces only)">
                </div>

                <select name="gender" required>
                    <option value="" disabled selected>Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>

                <h2>Address</h2>
                <div class="form-group">
                    <input type="text" name="street" placeholder="Street Address" required pattern="^[0-9A-Za-z\s\.,#\-]{5,100}$" title="Enter a valid street address (letters, numbers, ., #, -, ,)">
                </div>
                <div class="form-group">
                    <input type="text" name="city" placeholder="City" required pattern="^[A-Za-z\s\-\.]{2,50}$" title="Enter a valid city name (letters, spaces, hyphens)">
                    <input type="text" name="state" placeholder="State / Province" required pattern="^[A-Za-z\s\-]{2,50}$" title="Enter a valid state or province (letters, spaces, hyphens)">
                </div>
                <div class="form-group">
                    <input type="text" name="country" placeholder="Country" required pattern="^[A-Za-z\s]{2,56}$" title="Enter a valid country name (letters and spaces only)">
                    <input type="text" name="zip" placeholder="ZIP Code" required pattern="^\d{4}$" title="Please enter a 4-digit ZIP code">
                </div>

                <h2>Contact Information</h2>
                <div class="form-group">
                    <input type="email" name="email" placeholder="E-mail" required pattern="^[a-zA-Z0-9._%+-]+@gmail\.com$" title="Please enter a valid Gmail address only (e.g., yourname@gmail.com)">
                    <input type="text" name="contactNumber" placeholder="Contact Number" required pattern="(\+63\s?9\d{2}\s?\d{3}\s?\d{4}|09\d{9})" title="Enter a valid Philippine mobile number (e.g., 09123456789 or +639123456789)">
                </div>

                <h2>Academic Information</h2>
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
                            <select id="schoolYear" name="school_year" required></select>
                        </td>
                    </tr>
                </table>

                <div class="button-group">
                    <button type="submit" class="submit-btn">Submit</button>
                    <button type="button" class="close-btn" onclick="window.location.href='Signin.php'">&times;</button>
                </div>
            </div>

            <!-- Form for Old Student -->
            <div id="oldStudentForm" style="display:none;">
                <h3>Old Student Registration</h3>
                <div class="form-group">
                    <input type="text" name="student_id" placeholder="LRN" required pattern="\d{12}" title="LRN must be exactly 12 digits">
                    <input type="text" name="fName" placeholder="First Name" required pattern="^[A-Za-z\s]+$" title="First name must contain only letters and spaces.">
                    <input type="text" name="lName" placeholder="Last Name" required pattern="^[A-Za-z\s]+$" title="Last name must contain only letters and spaces.">
                    <input type="text" name="extName" placeholder="Extension (Jr., III, etc.)" pattern="^(Jr\.?|Sr\.?|II|III|IV|V)?$" title="Valid extensions: Jr, Sr, II, III, IV, V (leave blank if none)">
                    <input type="date" name="birthdate" required>
                    <input type="number" name="age" placeholder="Age">

                </div>
                <h2>Contact Information</h2>
                <div class="form-group">
                    <input type="email" name="email" placeholder="E-mail" required pattern="^[a-zA-Z0-9._%+-]+@gmail\.com$" title="Please enter a valid Gmail address only (e.g., yourname@gmail.com)">
                    <input type="text" name="contactNumber" placeholder="Contact Number" required pattern="(\+63\s?9\d{2}\s?\d{3}\s?\d{4}|09\d{9})" title="Enter a valid Philippine mobile number (e.g., 09123456789 or +639123456789)">
                </div>

                <h2>Academic Information</h2>
                <table>
                    <tr>
                        <th>Strand</th>
                        <th>Level</th>
                        <th>Semester</th>
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
                    </tr>
                </table>

                <div class="button-group">
                    <button type="submit" class="submit-btn">Submit</button>
                    <button type="button" class="close-btn" onclick="window.location.href='Signin.php'">&times;</button>
                </div>
            </div>

        </form>
    </div>

    <script>
        // JavaScript to toggle between New Student, Old Student, and Transferee Student forms
        function toggleForms(studentType) {
            const newStudentForm = document.getElementById('newStudentForm');
            const oldStudentForm = document.getElementById('oldStudentForm');

            if (studentType === 'New Student' || studentType === 'Transferee Student') {
                newStudentForm.style.display = 'block';
                oldStudentForm.style.display = 'none';
                toggleInputs(newStudentForm, true);
                toggleInputs(oldStudentForm, false);
            } else if (studentType === 'Old Student') {
                newStudentForm.style.display = 'none';
                oldStudentForm.style.display = 'block';
                toggleInputs(newStudentForm, false);
                toggleInputs(oldStudentForm, true);
            }
        }

        // Disable or enable form inputs
        function toggleInputs(container, enabled) {
            const inputs = container.querySelectorAll('input, select, textarea');
            inputs.forEach(input => input.disabled = !enabled);
        }

        // Event listener for changing student type
        document.getElementById('studentType').addEventListener('change', function() {
            toggleForms(this.value);
        });

        // Initialize school year
        const schoolYearSelect = document.getElementById('schoolYear');
        const currentYear = new Date().getFullYear();
        schoolYearSelect.innerHTML = `
            <option value="${currentYear}-${currentYear + 1}">${currentYear}-${currentYear + 1}</option>
            <option value="${currentYear + 1}-${currentYear + 2}">${currentYear + 1}-${currentYear + 2}</option>
        `;
    </script>
</body>
</html>
