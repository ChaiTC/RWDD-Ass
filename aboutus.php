<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="sidebar.css">
    <link rel="stylesheet" href="aboutus.css">
    <link rel="stylesheet" href="footer.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <div class="container">
        <h1>About Us</h1>
        <p>Meet our amazing team!</p>
        
        <div class="team">
            <?php
                $team_members = [
                    ["name" => "Sim Thian Kent", "image" => "sim.jpg", "description" => "Sim Thian Kent is a software developer with a focus on the quiz page."],
                    ["name" => "Chai Tian Cheng", "image" => "ctc.jpg", "description" => "Chai Tian Cheng is a financial analyst in financial tips page."],
                    ["name" => "Heng Wei Jie", "image" => "heng.jpg", "description" => "Heng Wei Jie is a UX designer in About Us page."],
                    ["name" => "Hooi Siu Kwan", "image" => "hooi.jpg", "description" => "Hooi Siu Kwan is a project manager ensuring the Main page is done"]
                ];
                
                foreach ($team_members as $index => $member) {
                    echo "<div class='member' onclick='toggleDescription($index)'>";
                    echo "<img src='" . $member['image'] . "' alt='" . $member['name'] . "'>";
                    echo "<h3>" . $member['name'] . "</h3>";
                    echo "<div class='description'>" . $member['description'] . "</div>";
                    echo "</div>";
                }
            ?>
        </div>
    </div>
    <?php include 'footer.php'; ?>

    <script src="sidebar.js"></script> 
    <script src="aboutus.js"></script>
</body>
</html>
