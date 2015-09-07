<div  align="center" id="headerWrapper">
			
				<div id="header">
					
					<div id="welcome_msg">
						<?php
							if(isset($_SESSION['userloggedin']) && $_SESSION['userloggedin'] == 1) {
								$first_name = ucfirst($_SESSION['user_first_name']);
								$last_name = ucfirst($_SESSION['user_last_name']);																			
								echo '<h5 align="left"><strong>Welcome ' . $first_name . ' ' . $last_name . '</strong></h5>';	
							}	
						?>					
					</div>
					
					<div id="balance_box">
						<?php
							if(isset($_SESSION['userloggedin']) && $_SESSION['userloggedin'] == 1){
								$balance = $_SESSION['user_balance'];
								echo'<h5 align="center">Balance: &euro; ' . number_format((float)$balance, 2, '.', '') . '</h5>';
							}
						?>
					</div>
					
					<div class="nav">
					<?php
						
						if(isset($_SESSION['userloggedin']) && $_SESSION['userloggedin'] == 1) {
							echo '<a class="tab"  href="logout.php">Sign Out</a>';
							echo '<a class="tab"  href="account.php">My Account</a>';
							echo '<a class="tab"  href="index.php">Home</a>';
						}
						
						else if(isset($_SESSION['adminloggedin']) && $_SESSION['adminloggedin'] == 1) {
							echo '<a class="tab"  href="logout.php">Sign Out</a>';
							echo '<a class="tab"  href="ADMIN/index.php">Admin Panel</a>';
						}
						else {
							echo '<a class="tab" href="login.php">Sign In</a>';
							echo '<a class="tab"  href="register.php">Register</a>';
							echo '<a class="tab"  href="index.php">Home</a>';
						}
					?>
					</div>	
				
				</div>	
				
					<div id="logoArea">
					<div id="logo">
					<a href="index.php"><img src="IMAGES/logo.png" alt="Vertigo Logo" /></a>			
					</div>		
					
					<div id="toCart">
			           	<a href="cart.php"><button id="toCartBtn">View Cart</button></a>
			       </div>
			       
			       
		       
						<form method="get" action="search.php" style="width: 250px;">
		                <div class="input-group">
		                    <input type="text" class="form-control" placeholder="Search" name="search" style="z-index:0;">
		                    <div class="input-group-btn">
		                        <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
		                    </div>
		                </div>
		            </form>
		            
		            

				</div>
				
				<div id="catPanel">
						<div id="catNav">
							<a class="catTab" href="category.php?cat=footwear">Footwear</a>
							<a class="catTab" href="category.php?cat=clothing">Clothing</a>
							<a class="catTab" href="category.php?cat=accessories">Accessories</a>
						</div>
				</div>	
			
			</div>