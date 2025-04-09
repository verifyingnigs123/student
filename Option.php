<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Type Selection</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #f4f4f4;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .container {
            display: flex;
            gap: 20px;
        }
        .box {
            width: 200px;
            height: 150px;
            background: white;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            border-radius: 10px;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s, box-shadow 0.3s;
            opacity: 0;
        }
        .box:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }
        .new { background: #4CAF50; color: white; }
        .old { background: #2196F3; color: white; }
        .transfer { background: #FF9800; color: white; 
        }
        .close-btn {
    background: none;
    color: #666;
    position: absolute;
    cursor: pointer;
    top: 10px;
    right: 10px;
    font-size: 30px;
    border: none;
    font-weight: 2px;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: -50px;
    transition: background 0.2s ease;
}
.container{
    position: relative;
    
}
.close-btn:hover{
    color: #000;
    background: #eb7777;
}

    </style>
</head>
<body>
    <div class="container">
        <div class="box new animate__animated" onclick="selectType('New Student')">New Student</div>
        <div class="box old animate__animated" onclick="selectType('Old Student')">Old Student</div>
        <div class="box transfer animate__animated" onclick="selectType('Transferee Student')">Transferee Student</div>
    </div>
    <div class="button-group">
                <button type="button" class="close-btn" onclick="window.location.href='Signin.php'">&times;</button>
            </div>

    <script>
        // Fade in animation
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".box").forEach((box, index) => {
                setTimeout(() => {
                    box.style.opacity = "1";
                    box.classList.add("animate__fadeInUp");
                }, index * 200);
            });
        });

        // Click event for selection
        function selectType(type) {
    alert("You selected: " + type);
    
    if (type === "New Student") {
        window.location.href = "new_student.php";
    } else if (type === "Old Student") {
        window.location.href = "Oldenroll.php";
    } else if (type === "Transferee Student") {
        window.location.href = "transfereEnroll.php";
    } else {
        alert("Invalid selection");
    }
}
    </script>
</body>
</html>
