<?php
	$query = $pdo->prepare("SELECT * FROM product WHERE server = ? ORDER BY `product`.`ispad` DESC");
	$query->execute(array($_GET['shop']));
	if($query->rowCount() == 0){
												{
?>
												<div class="col-md-12" style="margin-top:50px;margin-bottom:50px;">
													<img src="../assets/img/error.png" alt="Smiley face" height="auto" width="100" style="display:block;margin-left:auto;margin-right:auto;margin-bottom:30px;">
													<h1 class="col text-center">แย่จังงงง ...</h1>
													<h3 class="col text-center">ไม่พบสินค้าใน Server นี้ !</h3>
												</div>
<?php
														}
											}
	while($product = $query->fetch(PDO::FETCH_ASSOC))
	{
?>
												<div class="col-md-4 text-right" style="padding: 10px;">
                                                    <div class="border rounded" style="background-color: <?php if($product['ispad'] == 1) echo 'rgba(0,0,0,0.03)'; else echo 'rgba(0,0,0,0.03)'; ?>;padding: 20px;">
														<span class="text-white" style="background-color: <?php if($product['ispad'] == 1) echo '#FFAA00'; else echo 'rgb(52,58,64)'; ?>;text-shadow: -0.5px 0 black, 0 1px black, 0.5px 0 black, 0 -0.5px black;text-shadow: 2px 2px 2px black;padding-left: 10px;padding-right: 10px;padding-top: 2px;padding-bottom: 2px;font-size: 13px;"><?php if($product['ispad'] == 1) echo $product['pad'].' <s>'.$product['price'].'</s>'; else echo $product['price']; ?> THB</span>
														<img src="<?php echo $product['image']; ?>" style="display: block;margin-top: 50px;margin-bottom: 50px;margin-left: auto;margin-right: auto;width: 60%;">
                                                        <p class="text-center"><?php echo $product['name']; ?></p>
														<?php
	 														if($_SESSION['id'] == '')
															{
														?>
																<button class="btn btn-danger btn-block" style="margin-bottom: 10px;" onclick="Swal.fire('Shop', 'กรุณา Login ก่อนซื้อสินค้า !', 'error')">กรุณาเข้าสู่ระบบ !</button>
	 													<?php
															}
	 														else
															{
														?>
														<button class="btn btn-dark btn-block" style="margin-bottom: 10px;" onclick="buy(<?php echo $product['id']; ?>, '<?php echo $product['name']; ?>', '<?php if($product['ispad'] == 1) echo $product['pad']; else echo $product['price']; ?>');">ซื้อสินค้า</button>
														<button class="btn btn-outline-dark btn-block" style="margin-bottom: 10px;" onclick="gift_send(<?php echo $product['id']; ?>, '<?php echo $product['name']; ?>', '<?php if($product['ispad'] == 1) echo $product['pad']; else echo $product['price']; ?>');">ส่งของขวัญ</button>
														<?php
															}
	 													?>
													</div>
                                                </div>
<?php
	}
?>