<?php
session_start();

$file = 'data/ips.json';
$ips = json_decode(file_get_contents($file), true);
if (!$ips || !isset($ips['ips'])) {
    $ips['ips'] = [];
}

$userIp = $_SERVER['REMOTE_ADDR'];
$currentTime = time();
if (!isset($ips['ips'][$userIp])) {
    $ips['ips'][$userIp] = [
        'count' => 1,
        'first_request_time' => $currentTime
    ];
} else {
    $userData = &$ips['ips'][$userIp];
    if ($currentTime - $userData['first_request_time'] > 60) {
        $userData['count'] = 1;
        $userData['first_request_time'] = $currentTime;
    } else {
        if ($userData['count'] >= 13) {
            header('HTTP/1.0 403 Forbidden');
            exit();
        }
        $userData['count']++;
    }
}

file_put_contents($file, json_encode($ips, JSON_PRETTY_PRINT));
?>

<html>
    <head>
        <title>SCC | Secure Code Challenge</title>
        <meta charset="UTF-8" />
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <link rel="stylesheet" href="/style/home.css">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </head>
    <body>
        <div class="head">
            <h1 style="margin-top:15px;"><?php echo htmlspecialchars("</SCC>", ENT_QUOTES); ?></h1>
            <?php       
            $filePath = 'data/star.json';
            
            if (file_exists($filePath)) {
                $star = json_decode(file_get_contents($filePath), true);
                if (!is_array($star)) {
                    $star = ['stars' => []];
                }
            } else {
                $star = ['stars' => []];
            }
            
            $userName = $_SESSION['user'] ?? '';
            
            if ($userName !== '') {
    $names = array_column($star['stars'], 'name');
    if (!in_array($userName, $names)) {
        $star['stars'][] = ['name' => $userName];
        file_put_contents($filePath, json_encode($star, JSON_PRETTY_PRINT));
    }
}
            ?>
            <button style="background: none; border: none; outline: none; float:right; margin-top:-70px; margin-right:20px;">    
            <svg width="40px" height="40px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path opacity="0.5" d="M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12Z" fill="#d4d4b5"></path> <path d="M10.4127 8.49812L10.5766 8.20419C11.2099 7.06807 11.5266 6.5 12 6.5C12.4734 6.5 12.7901 7.06806 13.4234 8.20419L13.5873 8.49813C13.7672 8.82097 13.8572 8.98239 13.9975 9.0889C14.1378 9.19541 14.3126 9.23495 14.6621 9.31402L14.9802 9.38601C16.2101 9.66428 16.825 9.80341 16.9713 10.2739C17.1176 10.7443 16.6984 11.2345 15.86 12.215L15.643 12.4686C15.4048 12.7472 15.2857 12.8865 15.2321 13.0589C15.1785 13.2312 15.1965 13.4171 15.2325 13.7888L15.2653 14.1272C15.3921 15.4353 15.4554 16.0894 15.0724 16.3801C14.6894 16.6709 14.1137 16.4058 12.9622 15.8756L12.6643 15.7384C12.337 15.5878 12.1734 15.5124 12 15.5124C11.8266 15.5124 11.663 15.5878 11.3357 15.7384L11.0378 15.8756C9.88633 16.4058 9.31059 16.6709 8.92757 16.3801C8.54456 16.0894 8.60794 15.4353 8.7347 14.1272L8.76749 13.7888C8.80351 13.4171 8.82152 13.2312 8.76793 13.0589C8.71434 12.8865 8.59521 12.7472 8.35696 12.4686L8.14005 12.215C7.30162 11.2345 6.88241 10.7443 7.02871 10.2739C7.17501 9.80341 7.78994 9.66427 9.01977 9.38601L9.33794 9.31402C9.68743 9.23495 9.86217 9.19541 10.0025 9.0889C10.1428 8.98239 10.2328 8.82097 10.4127 8.49812Z" fill="#d4d4b5"></path> </g></svg>
            </button>
            <p style="float:right; margin-top:-25px; margin-right:40px; font-size:15px; color:d4d4b5;">
                <?php 
                $data = json_decode(file_get_contents('data/star.json'), true);
                echo '%' . htmlspecialchars(count($data['stars']));
                ?>
        </div>
        <div class="headers">
            <h1>Secure Code Challenge</h1>
            <h2>#Hunter</h2><h2>#Security</h2><h2>#Bug</h2><h2>#Code</h2><br>
            <?php
            if(!isset($_SESSION['user'])){
                ?>
            <a href="login.php" style="text-decoration:none;"><button class="button-1">login</button></a>
            <?php
            } else {
                ?>
                <a href="logout.php" style="text-decoration:none;"><button class="button-1">Logout</button></a>
                <?php
            }
            ?>
            <button class="button-2">start</button>
        </div>
        <h1 style="text-align:center;">Help</h1>
        <div class="line"></div>
        <div class="help">
            <p>First, select the challenge you want and click on GO to display our challenge. Now it is enough to read the challenge carefully and implement the desired request on the given code and then send the work output in the results upload section. Note that it is necessary to enter the challenge code to identify the challenge. You are requested to participate in this challenge with your knowledge</p>
            <h2 style="font-size: 20px; background: none;">Methods of providing secure code</h2>
            <ol>
            <li style="margin-top: 20px;">Do not use hashed characters</li>
            <li>Do not try to install payload on scripts</li>
            <li>Use complex algorithm for more script security</li>
            <li>The best security algorithm is selected</li>
            </ol>
        </div>
        <div class="challenge">
            <h1 style="text-align:center;">Challenges</h1>
            <div class="line"></div>
            <?php
        $data = json_decode(file_get_contents('data/challenges.json'), true);
        $challenges = $data['challenges'];
        
        $groupedChallenges = [];
        foreach ($challenges as $challenge) {
            $titleKey = strtolower(trim($challenge['title']));
            if (!isset($groupedChallenges[$titleKey])) {
                $groupedChallenges[$titleKey] = [
                    'title' => $challenge['title'],
                    'desc' => [],
                ];
            }
            $groupedChallenges[$titleKey]['desc'][] = $challenge['desc'];
        }
        
        $i = 0;
        $groupedValues = array_values($groupedChallenges);
        $totalGroups = count($groupedValues);
        
        while ($i < $totalGroups) {
            echo '<div class="row" style="display: flex; gap: 10px;">';
        
            $group = $groupedValues[$i];
            $title = htmlspecialchars($group['title']);
            $desc = "All Challanges";
            echo '<div class="challenges">';
            echo '<h3>' . $title . '</h3>';
            echo '<p>' . $desc .
                (!isset($_SESSION['user'])
                    ? '<a style="float:right; margin-right:20px; text-decoration:none; color:#d4d4b5;" href="login.php">LOGIN</a>'
                    : '<a style="float:right; margin-right:20px; text-decoration:none; color:#d4d4b5;" href="?title=' . $title . '">GO</a>')
                . '</p>';
            echo '</div>';
        
            if ($i + 1 < $totalGroups) {
                $group2 = $groupedValues[$i + 1];
                $title2 = htmlspecialchars($group2['title']);
                $desc2 = "All Challanges";
                echo '<div class="challenges">';
                echo '<h3>' . $title2 . '</h3>';
                echo '<p>' . $desc2 .
                    (!isset($_SESSION['user'])
                        ? '<a style="float:right; margin-right:20px; text-decoration:none; color:#d4d4b5;" href="login.php">LOGIN</a>'
                        : '<a style="float:right; margin-right:20px; text-decoration:none; color:#d4d4b5;" href="?title=' . $title2 . '">GO</a>')
                    . '</p>';
                echo '</div>';
                $i += 2;
            } else {
                $i += 1; 
            }
        
            echo '</div>';
        }
        ?>
        </div>
        <?php
        if(isset($_SESSION['user'])){
            ?>
        <h1 style="text-align:center;">Code</h1>
            <div class="line"></div>
        <?php
        if (isset($_GET['title'])) {
            $title = htmlspecialchars($_GET['title']);
            $data = json_decode(file_get_contents('data/challenges.json'), true);
            $challenges = $data['challenges'];
            $matchedChallenges = [];
            foreach ($challenges as $challenge) {
                if (strpos($challenge['title'], $title) !== false) {
                    $matchedChallenges[] = $challenge;
                }
            }
        
            if (count($matchedChallenges) > 0) {
                foreach ($matchedChallenges as $challenge) {
                    ?>
                    <div style="background: #1b332c; padding: 20px; border-radius: 20px; margin-bottom: 20px;">
                    <?php
                    echo '<h2>' . htmlspecialchars($challenge['title']) . '</h2>';
                    echo '<p style="float:right; margin-top:1px; margin-right:20px; color:#d4d4b5;">' . htmlspecialchars($challenge['pass']) . '</p>';
                    echo '<pre style="background: rgba(15,30,20, 0.5);
                            backdrop-filter: blur(10px);
                            -webkit-backdrop-filter: blur(10px); padding:20px; border-radius:20px;">' . htmlspecialchars($challenge['code']) . '</pre>';
                    echo '<p>' . htmlspecialchars($challenge['desccode']) . '</p>';
                    echo '<p style="float:right; margin-top:-15px; margin-right:10px; font-size:13px;">' . htmlspecialchars($challenge['time']) . '</p>';
                    ?>
                            </div>
                            <?php
                }
            } else {
                echo '<div style="background: #1b332c; padding: 20px; border-radius: 20px; margin-bottom: 20px;">No challenges found matching the title</div>';
            }
        } else {
            echo '<div style="background: #1b332c; padding: 20px; border-radius: 20px; margin-bottom: 20px;">Please provide a title parameter</div>';
        }
        ?>
        <h1 style="text-align:center;">Result</h1>
            <div class="line"></div>
            <div class="res">
            <form class="fr" method="POST" action="results.php"> 
            <h1 style="background: none; text-align: center; color:#d4d4b5;">Submit your security code</h1>
                <label>Challange Code</label><br>
                <input type="number" name="number" pattern="^[0-9]+$" required><br>
                <label>Your Code</label><br>
                <input type="text" name="code"><br>
                <label>More Description</label><br>
                <textarea name="desc" id="desc"></textarea><div id="charCount" style="float:right; margin-top:-10px; margin-bottom: 10px;">0 / 200</div>
                <input type="submit" value="Submit">
            </form>
        </div>
        <h1 style="text-align:center;">Statistics</h1>
            <div class="line"></div>
        <div class="counti" style="background: #1b332c; padding: 15px; border-radius: 20px;">
<?php
$data = json_decode(file_get_contents('data/messagesdata.json'), true);
$user_entries = [];

foreach ($data['results'] as $entry) {
    if ($entry['user'] == $_SESSION['user']) {
        $user_entries[] = $entry;
    }
}

$res = json_decode(file_get_contents('data/statis.json'), true);
$true_count = 0;
$false_count = 0;
$admin_messages = []; 

if (isset($res['statis'])) {
    foreach ($res['statis'] as $enttry) {
        if ($enttry['user'] == $_SESSION['user']) {
            if ($enttry['result'] === true) {
                $true_count++;
                if(isset($enttry['admin'])){
                    $admin_messages[] = "admin (" . htmlspecialchars($enttry['code']) . "): " . htmlspecialchars($enttry['admin']);
                }
            } elseif ($enttry['result'] === false) {
                $false_count++;
            }
        }
    }
}
$admin_msgs_html = implode("<br>", $admin_messages);
echo "<h3 style='text-align:center;'>" . htmlspecialchars($_SESSION['user']) . ", Welcome to the SCC Platform</h3>";

echo "<canvas id='myChart' width='50' height='20'></canvas>";
echo "<script>
const ctx = document.getElementById('myChart').getContext('2d');

let currentData = [" . htmlspecialchars(count($user_entries)) . "," . htmlspecialchars($true_count) . "," . htmlspecialchars($false_count) . "]; 

const myChart = new Chart(ctx, {
type: 'line',
data: {
    labels: ['Solved', 'True', 'Falsa'],
    datasets: [{
        label: ' ',
        data: currentData,
        fill: false,
        borderColor: '#d4d4b5',
        tension: 0.1
    }]
},
options: {
    responsive: true,
    scales: {
        y: {
            beginAtZero: true
        }
    }
}
});

function updateChart(newNumber) {
    currentData[0] = newNumber; 
    myChart.update();
}

</script>";

echo "<div style='display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  padding: 10px; 
  box-sizing: border-box;'><div style='float:left;'><b>Masseges :</b><br>" . $admin_msgs_html . "</div><div style='background:#316d60; padding:1px; width:0.5px; height:40px; margin-right:10px;margin-left:10px;'></div>";
echo "<div style='float:right;'><b>You :</b><br><a>IP : " . htmlspecialchars($_SERVER['REMOTE_ADDR']) . "</a><br><a>Device : " . htmlspecialchars($_SERVER['HTTP_USER_AGENT']) . "</a></div></div>";
?>
</div>
        <?php
    }
        ?>
        <div>
        <h1 style="text-align:center;">Scores</h1>
        <div class="line"></div>
        <?php
        $data = json_decode(file_get_contents('data/score.json'), true);
        $scores = $data['users'];
        usort($scores, function($a, $b) {
            return intval($b['score']) - intval($a['score']);
        });
        echo '<table>';
        echo '<tr>
                <th>ID</th>
                <th>User</th>
                <th>Type</th>
                <th>Challenge</th>
                <th>Score</th>
              </tr>';
        $count = 1;
        foreach ($scores as $score) {
            echo '<tr>';
            echo '<td>' . $count . '</td>';
            echo '<td>' . htmlspecialchars($score['username']) . '</td>';
            echo '<td>' . htmlspecialchars($score['type']) . '</td>';
            echo '<td>' . htmlspecialchars($score['challenge']) . '</td>';
            echo '<td>' . htmlspecialchars($score['score']) . '</td>';
            echo '</tr>';
            $count++;
        }
        
        echo '</table>';
        ?>
        </div><br>
        	<h1 style="text-align:center;">The Best</h1>
        <div class="line"></div>
        <?php
        $data = json_decode(file_get_contents('data/best.json'), true);
        $scores = $data['bests'];
        echo '<table>';
        echo '<tr>
        	<th>Challenge</th>
                <th>User</th>
                <th>Code</th>
                <th>Result</th>
              </tr>';
        foreach ($scores as $score) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($score['challenge']) . '</td>';
            echo '<td>' . htmlspecialchars($score['username']) . '</td>';
            echo '<td>' . htmlspecialchars($score['code']) . '</td>';
            echo '<td>' . htmlspecialchars($score['result']) . '</td>';
            echo '</tr>';
        }
        echo '</table>';
        ?>
        </div><br>
        <h1 style="text-align:center;">about us</h1>
        <div class="line"></div>
        <div class="about">
            <h3>We are here to help you solve your security bugs and also be a learning partner :)</h3>
        </div>
        <div class="footer">
  <div class="item">
    <svg viewBox="0 -3.5 256 256" width="25px" height="25px" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMinYMin meet" fill="#000000">
      <g fill="#d4d4b5">
        <path d="M127.505 0C57.095 0 0 57.085 0 127.505c0 56.336 36.534 104.13 87.196 120.99 6.372 1.18 8.712-2.766 8.712-6.134 0-3.04-.119-13.085-.173-23.739-35.473 7.713-42.958-15.044-42.958-15.044-5.8-14.738-14.157-18.656-14.157-18.656-11.568-7.914.872-7.752.872-7.752 12.804.9 19.546 13.14 19.546 13.14 11.372 19.493 29.828 13.857 37.104 10.6 1.144-8.242 4.449-13.866 8.095-17.05-28.32-3.225-58.092-14.158-58.092-63.014 0-13.92 4.981-25.295 13.138-34.224-1.324-3.212-5.688-16.18 1.235-33.743 0 0 10.707-3.427 35.073 13.07 10.17-2.826 21.078-4.242 31.914-4.29 10.836.048 21.752 1.464 31.942 4.29 24.337-16.497 35.029-13.07 35.029-13.07 6.94 17.563 2.574 30.531 1.25 33.743 8.175 8.929 13.122 20.303 13.122 34.224 0 48.972-29.828 59.756-58.22 62.912 4.573 3.957 8.648 11.717 8.648 23.612 0 17.06-.148 30.791-.148 34.991 0 3.393 2.295 7.369 8.759 6.117 50.634-16.879 87.122-64.656 87.122-120.973C255.009 57.085 197.922 0 127.505 0"></path>
        <path d="M47.755 181.634c-.28.633-1.278.823-2.185.389-.925-.416-1.445-1.28-1.145-1.916.275-.652 1.273-.834 2.196-.396.927.415 1.455 1.287 1.134 1.923M54.027 187.23c-.608.564-1.797.302-2.604-.589-.834-.889-.99-2.077-.373-2.65.627-.563 1.78-.3 2.616.59.834.899.996 2.08.36 2.65M58.33 194.39c-.782.543-2.06.034-2.849-1.1-.781-1.133-.781-2.493.017-3.038.792-.545 2.05-.055 2.85 1.07.78 1.153.78 2.513-.019 3.069M65.606 202.683c-.699.77-2.187.564-3.277-.488-1.114-1.028-1.425-2.487-.724-3.258.707-.772 2.204-.555 3.302.488 1.107 1.026 1.445 2.496.7 3.258M75.01 205.483c-.307.998-1.741 1.452-3.185 1.028-1.442-.437-2.386-1.607-2.095-2.616.3-1.005 1.74-1.478 3.195-1.024 1.44.435 2.386 1.596 2.086 2.612M85.714 206.67c.036 1.052-1.189 1.924-2.705 1.943-1.525.033-2.758-.818-2.774-1.852 0-1.062 1.197-1.926 2.721-1.951 1.516-.03 2.758.815 2.758 1.86M96.228 206.267c.182 1.026-.872 2.08-2.377 2.36-1.48.27-2.85-.363-3.039-1.38-.184-1.052.89-2.105 2.367-2.378 1.508-.262 2.857.355 3.049 1.398"></path>
      </g>
    </svg>
    <a href="https://t.me/GeekUNIX" style="text-decoration:none; margin-left:10px; color:#d4d4b5;">GitHub</a>
  </div>
  <div class="item">
    <svg viewBox="0 0 24 24" width="35px" height="35px" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M12 4C10.4178 4 8.87103 4.46919 7.55544 5.34824C6.23985 6.22729 5.21447 7.47672 4.60897 8.93853C4.00347 10.4003 3.84504 12.0089 4.15372 13.5607C4.4624 15.1126 5.22433 16.538 6.34315 17.6569C7.46197 18.7757 8.88743 19.5376 10.4393 19.8463C11.9911 20.155 13.5997 19.9965 15.0615 19.391C16.5233 18.7855 17.7727 17.7602 18.6518 16.4446C19.5308 15.129 20 13.5823 20 12C20 9.87827 19.1571 7.84344 17.6569 6.34315C16.1566 4.84285 14.1217 4 12 4ZM15.93 9.48L14.62 15.67C14.52 16.11 14.26 16.21 13.89 16.01L11.89 14.53L10.89 15.46C10.8429 15.5215 10.7824 15.5715 10.7131 15.6062C10.6438 15.6408 10.5675 15.6592 10.49 15.66L10.63 13.66L14.33 10.31C14.5 10.17 14.33 10.09 14.09 10.23L9.55 13.08L7.55 12.46C7.12 12.33 7.11 12.03 7.64 11.83L15.35 8.83C15.73 8.72 16.05 8.94 15.93 9.48Z" fill="#d4d4b5"></path>
    </svg>
    <a href="https://github.com/MrBanana2045" style="text-decoration:none; color:#d4d4b5;">Telegram</a>
  </div>
  <p style="margin-left: auto;">All information is reserved</p>
</div>
    </body>
    <script>
const textarea = document.getElementById('desc');
const counter = document.getElementById('charCount');

textarea.addEventListener('input', () => {
  const maxLength = 200;
  if (textarea.value.length > maxLength) {
    textarea.value = textarea.value.substring(0, maxLength);
  }
  const currentLength = textarea.value.length;
  const remaining = maxLength - currentLength;

  if (remaining > 0) {
    counter.innerHTML = `${currentLength} / 200`;
    counter.classList.remove('warning');
  } else {
    counter.innerHTML = `${currentLength} / 200`;
    counter.classList.remove('warning');
  }
});

</script>
</html>
