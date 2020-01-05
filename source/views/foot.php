<button onclick="topFunction()" id="topButton" class="topButton" title="Go to top"><i class="fas fa-arrow-up"></i></button>
<?php require('views/foot.php'); ?>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/script.min.js"></script>
<script src="assets/js/app.js"></script>
<script src="assets/js/admin.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<?php
$query = $pdo->prepare("SELECT * FROM news ORDER BY `news`.`id` ASC");
$query->execute();
while ($news = $query->fetch(PDO::FETCH_ASSOC))
  echo '<script>toastr["info"]("' . $news['text'] . '", "' . date('d/m/Y H:i:s', $news['time']) . '")</script>';
?>
</body>

</html>
