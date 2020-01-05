<?php
include 'core.php';
$config = [
  'title' => config($pdo, 'title'),
  'logo' => config($pdo, 'logo'),
  'background' => config($pdo, 'background'),
  'version' => config($pdo, 'version'),
  'ip' => config($pdo, 'ip')
];

require('views/head.php');
?>
<div class="container">
  <div class="row" style="margin-top: 50px;margin-bottom: 50px;">
    <div class="col text-center"><img class="img-fluid" src="<?php echo $config['logo']; ?>" width="300px" style="margin-top: 50px;margin-bottom: 50px;"></div>
  </div>
</div>
<div class="container">
  <div class="row" style="margin-bottom: 250px;">
    <div class="col">
      <div class="card">
        <div class="card-header">
          <h4 class="card-header-title"><span><i class="fas fa-home"></i>&nbsp;</span>หน้าหลัก</h4>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-3">
              <?php
              $status = json_decode(file_get_contents('https://api.mcsrvstat.us/2/' . $config['ip']));
              if ($status->online) {
              ?>
                <div class="card" style="margin-top: 10px;margin-bottom: 10px;">
                  <div class="card-header">
                    <h4 class="card-header-title"><span><i class="fas fa-list-alt"></i>&nbsp;</span>สถานะ Server</h4>
                  </div>
                  <div class="card-body">
                    <h4>สถานะ : <span style="color:green;">ออนไลน์</span></h4>
                    <h5>จำนวนผู้เล่น <?php echo $status->players->online . '/' . $status->players->max; ?> คน</h5>
                  </div>
                </div>
              <?php
              }
              ?>
              <div class="card" style="margin-top: 10px;margin-bottom: 10px;">
                <div class="card-header">
                  <h4 class="card-header-title"><span><i class="fas fa-list-alt"></i>&nbsp;</span>เมนู</h4>
                </div>
                <div class="card-body text-center" id="login">
                  <?php include './include/login.php'; ?>
                </div>
              </div>
            </div>
            <div class="col-md-9" id="app">
              <?php include './include/home.php'; ?>
            </div>
          </div>
        </div>
        <div class="card-footer text-muted text-center">Design By <a href="https://www.facebook.com/dritestudio/">DriteStudio</a> System By <a href="https://kiznick.in.th/">Yoswaris Lawpaiboon</a> <b>Webshop Version <u><?php echo $config['version']; ?></u></b></div>
      </div>
    </div>
  </div>
</div>
