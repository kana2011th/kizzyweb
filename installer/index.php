<?php
if (!empty($_POST['ip']) && !empty($_POST['username']) && isset($_POST['password']) && !empty($_POST['dbname'])) {
  $ip = $_POST['ip'];
  $user = $_POST['username'];
  $pass = $_POST['password'];
  $db = $_POST['dbname'];
  try {
    $pdo = new PDO(
      "mysql:host=" . $ip . "; dbname=" . $db . ";",
      $user,
      $pass,
      array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
    );
  } catch (PDOException $disconnect) {
    die('database');
  }
  function execute_query($sql, $array = [])
  {
    global $pdo;
    $q = $pdo->prepare($sql);
    $q->execute($array);
    return $q;
  }
  function is_table_exists($table)
  {
    global $pdo;
    global $db;
    $q = $pdo->prepare("SELECT table_name FROM information_schema.tables WHERE table_schema = ? and table_name = ? LIMIT 1");
    $q->execute(array($db, $table));
    if ($q->rowCount() == 0)
      return true;
    else
      return false;
  }
  if (is_table_exists('authme'))
    execute_query(<<<EOF
CREATE TABLE `authme` (
 `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
 `username` varchar(255) NOT NULL,
 `realname` varchar(255) NOT NULL,
 `password` varchar(255) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
 `ip` varchar(40) CHARACTER SET ascii COLLATE ascii_bin DEFAULT NULL,
 `lastlogin` bigint(20) DEFAULT NULL,
 `x` double NOT NULL DEFAULT 0,
 `y` double NOT NULL DEFAULT 0,
 `z` double NOT NULL DEFAULT 0,
 `world` varchar(255) NOT NULL DEFAULT 'world',
 `regdate` bigint(20) NOT NULL DEFAULT 0,
 `regip` varchar(40) CHARACTER SET ascii COLLATE ascii_bin DEFAULT NULL,
 `yaw` float DEFAULT NULL,
 `pitch` float DEFAULT NULL,
 `email` varchar(255) DEFAULT NULL,
 `isLogged` smallint(6) NOT NULL DEFAULT 0,
 `hasSession` smallint(6) NOT NULL DEFAULT 0,
 `totp` varchar(16) DEFAULT NULL,
 `point` decimal(10,2) NOT NULL DEFAULT 0.00,
 `redeem` text NOT NULL,
 `checkin` int(11) NOT NULL,
 `checkindate` varchar(10) NOT NULL,
 `donate` decimal(10,2) NOT NULL DEFAULT 0.00,
 `isadmin` int(1) NOT NULL DEFAULT 0,
 PRIMARY KEY (`id`),
 UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
EOF);
  if (is_table_exists('checkin'))
    execute_query(<<<EOF
CREATE TABLE `checkin` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `image` varchar(255) NOT NULL,
 `name` varchar(255) NOT NULL,
 `command` varchar(255) NOT NULL,
 `price` int(5) NOT NULL,
 `server` int(11) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
EOF);
  if (is_table_exists('config')) {
    execute_query(<<<EOF
CREATE TABLE `config` (
 `id` int(3) NOT NULL AUTO_INCREMENT,
 `name` varchar(100) COLLATE utf8mb4_bin NOT NULL,
 `value` text COLLATE utf8mb4_bin NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8
EOF);
    execute_query("INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'title', 'Kiznick Webshop')");
    execute_query("INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'logo', 'https://cdn.kiznick.in.th/logo/logo-gold-japan.png')");
    execute_query("INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'background', 'https://cdn.kiznick.in.th/background/1.jpg')");
    execute_query("INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'merchant', '')");
    execute_query("INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'version', '" . file_get_contents('https://client.dritestudio.in.th/product/webshop/version.php') . "')");
    execute_query("INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'tm_type', '1')");
    execute_query("INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'tw_key', '')");
    execute_query("INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'tw_tel', '')");
    execute_query("INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'ip', '" . $ip . "')");
    execute_query("INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'tmx', '1')");
    execute_query("INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'twx', '1')");
  }
  if (is_table_exists('gift'))
    execute_query(<<<EOF
CREATE TABLE `gift` (
 `id` int(3) NOT NULL AUTO_INCREMENT,
 `product` int(3) NOT NULL,
 `image` varchar(200) COLLATE utf8mb4_bin NOT NULL,
 `name` varchar(150) COLLATE utf8mb4_bin NOT NULL,
 `reciver` int(3) NOT NULL,
 `sender` int(3) NOT NULL,
 `date` varchar(10) COLLATE utf8mb4_bin NOT NULL,
 `expire` varchar(10) COLLATE utf8mb4_bin NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin
EOF);
  if (is_table_exists('news'))
    execute_query(<<<EOF
CREATE TABLE `news` (
 `id` int(3) NOT NULL AUTO_INCREMENT,
 `time` varchar(10) COLLATE utf8mb4_bin NOT NULL,
 `text` varchar(256) COLLATE utf8mb4_bin NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin
EOF);
  if (is_table_exists('product'))
    execute_query(<<<EOF
CREATE TABLE `product` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `image` varchar(150) COLLATE utf8mb4_bin NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `command` text COLLATE utf8mb4_bin NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `pad` decimal(10,2) NOT NULL,
  `ispad` int(1) NOT NULL DEFAULT 0,
  `server` int(3) NOT NULL,
  PRIMARY KEY (`id`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin
EOF);
  if (is_table_exists('redeem'))
    execute_query(<<<EOF
CREATE TABLE `redeem` (
 `id` int(3) NOT NULL AUTO_INCREMENT,
 `redeem` varchar(200) NOT NULL,
 `command` varchar(50) NOT NULL,
 `used` int(11) NOT NULL DEFAULT 0,
 `max` int(11) NOT NULL,
 `server` int(11) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
EOF);
  if (is_table_exists('server'))
    execute_query(<<<EOF
CREATE TABLE `server` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `name` varchar(30) NOT NULL,
 `ip` varchar(50) NOT NULL DEFAULT '127.0.0.1',
 `rport` varchar(5) NOT NULL,
 `rpass` varchar(30) NOT NULL,
 `qport` varchar(5) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
EOF);
  if (is_table_exists('slide'))
    execute_query(<<<EOF
CREATE TABLE `slide` (
 `id` int(3) NOT NULL AUTO_INCREMENT,
 `image` text COLLATE utf8mb4_bin NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin
EOF);
  if (is_table_exists('topup'))
    execute_query(<<<EOF
CREATE TABLE `topup` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `ref` varchar(14) NOT NULL,
  `transaction_id` varchar(14) NOT NULL,
  `amount` decimal(6,2) NOT NULL,
  `got` decimal(10,2) NOT NULL,
  `type` int(1) NOT NULL,
  `user` int(3) NOT NULL,
  `time` varchar(10) NOT NULL,
  `updatetime` varchar(10) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1
EOF);
  $current = <<<EOL
<?php
  \$host['localhost'] = '$ip';
  \$host['username'] = '$user';
  \$host['password'] = '$pass';
  \$host['database_name'] = '$db';
  \$url['base_url'] = 'http://$_SERVER[SERVER_NAME]/';
  /*---------------------------------------- ห้ามแก้ไขในส่วนข้างล่างนี้-----------------------------------------------------------------------------*/
  date_default_timezone_set("Asia/Bangkok");
  error_reporting(0);
  try
  {
    \$pdo = new PDO("mysql:host=".\$host['localhost']."; dbname=".\$host['database_name'].";",\$host['username'], \$host['password'],
    array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8",PDO::ATTR_EMULATE_PREPARES => false,PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  }
  catch (PDOException \$disconnect)
  {
    die("ไม่สามารถเชื่อมต่อฐานข้อมูลได้ ".\$disconnect->getmessage());
  }
EOL;
  file_put_contents('config.php', $current);
  if (!@file_put_contents("update.zip", fopen("https://github.com/MinecraftChannel/kizzyweb/archive/master.zip", 'r'))) {
    @unlink('update.zip');
    die('file');
  }

  function recurse_copy($src, $dst)
  {
    $dir = opendir($src);
    @mkdir($dst);
    while (false !== ($file = readdir($dir))) {
      if (($file != '.') && ($file != '..')) {
        if (is_dir($src . '/' . $file)) {
          recurse_copy($src . '/' . $file, $dst . '/' . $file);
        } else {
          copy($src . '/' . $file, $dst . '/' . $file);
        }
      }
    }
    closedir($dir);
  }

  $zip = new ZipArchive;
  if ($zip->open('update.zip') === TRUE) {
    $zip->extractTo('./');
    $zip->close();

    //move file up two directory ;-;
    recurse_copy("kizzyweb-master/source", './');
    @unlink("update.zip");
    @unlink("kizzyweb-master");
    die('success');
  } else
    die('zip');
  die;
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>Install</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit">
</head>

<body style="font-family: Kanit, sans-serif;background-image: url(&quot;https://cdn.kiznick.in.th/background/1.jpg&quot;);background-size: auto;background-position: 50% 50%; margin-bottom: 30px;">
  <div class="container">
    <div class="row row-custom" style="padding-top: 30px;">
      <div class="col-10 col-sm-6 col-md-4 offset-1 offset-sm-3 offset-md-4 text-center">
        <p style="font-size: 55px; color: white;">
          <img class="rounded-circle img-fluid" src="https://cdn.kiznick.in.th/logo/logo-gold-modern.png" width="100px" style="margin-bottom: 10px;">
          x
          <img class="rounded-circle img-fluid" src="https://cdn.kiznick.in.th/logo/logo-gold-japan.png" width="100px" style="margin-bottom: 10px;">
        </p>
        <h1 class="text-center" style="color: white;">ตัวช่วยลงระบบ</h1>
        <h6 class="text-center" style="margin-bottom: 20px; color: white;">MCSTORE BY DRITESTUDIO x Kiznick</h6>
        <div class="card">
          <div class="card-body">
            <div class="form-group"><label>IP Server : ไอพีเซิร์ฟ</label><input class="form-control" type="text" id="ip"></div>
            <div class="form-group"><label>MYSQL - USER : ชื่อผู้ใช้</label><input class="form-control" type="text" id="username"></div>
            <div class="form-group"><label>MYSQL - PASSWORD : พาสเวิร์ด</label><input class="form-control" type="password" id="password"></div>
            <div class="form-group"><label>MYSQL - Database Name : ชื่อฐานข้อมูล</label><input class="form-control" type="text" id="dbname"></div>
            <button class="btn btn-success btn-block" onclick="save();">SUBMIT </button>
            <button class="btn btn-danger btn-block center-block" onclick="reset();">RESET </button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
  <script>
    function reset() {
      $('input').val('');
    }

    function save() {
      if ($('#ip').val() == '' || $('#username').val() == '' || $('#dbname').val() == '')
        return Swal.fire('Install', 'กรุณาใส่ข้อมูลให้ครบ !', 'error');
      $.post("", {
          ip: $('#ip').val(),
          username: $('#username').val(),
          password: $('#password').val(),
          dbname: $('#dbname').val()
        },
        function(data) {
          switch (data) {
            case 'file':
              Swal.fire('Install', 'ไม่พบไฟล์ในระบบ !', 'error');
              break;
            case 'zip':
              Swal.fire('Install', 'ไม่สามารถแตกไฟล์ Zip ได้ !', 'error');
              break;
            case 'database':
              Swal.fire('Install', 'ไม่สามารถเชื่อมต่อฐานข้อมูลได้ !', 'error');
              break;
            case 'success':
            setTimeout(() => {
              window.location.reload(true)
            }, 5000)
              Swal.fire('Install', 'ตั่งค่าเว็บช็อปสำเร็จ กรุณารอ 5 วินาที... !', 'success');
              break;
            default:
              Swal.fire('Install', 'เกิดข้อผิดพลาดไม่ทราบสาเหตุ !', 'error');
          }
        }
      );
    }
  </script>
</body>

</html>
