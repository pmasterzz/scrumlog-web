<div class="top-content">
        	
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
                            <h1>Rijnijssel Scrumlog</h1>
                            <div class="description">
                            	<p>
	                            	Leuker kunnen we het niet maken, wel makkelijker.
	                            	
                            	</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                        	<div class="form-top">
                        		<div class="form-top-left">
                        			<h3>Login</h3>
                            		<p>Login met uw gebruikersnaam en wachtwoord</p>
                        		</div> 
                        		<div class="form-top-right">
                        			<i class="fa fa-lock"></i>
                        		</div>
                            </div>
                            <div class="form-bottom">
                                <form role="form" action="php/login.php" method="post" class="login-form" >

			                    	<div class="form-group">
			                    		<label class="sr-only" for="form-username">Gebruikersnaam</label>
                                                        <input type="text" name="form-username" placeholder="Gebruikersnaam" class="form-username form-control" id="form-username" autofocus required>
			                        </div>
			                        <div class="form-group">
			                        	<label class="sr-only" for="form-password">Wachtwoord</label>
                                                        <input type="password" name="form-password" placeholder="Wachtwoord" class="form-password form-control" id="form-password" required>
			                        </div>
			                        <button type="submit" name="submit" class="btn">Log in</button>
			                    </form>
                                <?php
                                if (isset ($_SESSION['foutmelding'])){
                                    echo '<p class="foutmelding">Verkeerde gebruikersnaam en/of wachtwoord.<p>';
                                    unset($_SESSION['foutmelding']);
                                }
                                    ?>
		                    </div>
                        </div>
                    </div>
                    <div class="row">
                        
                    </div>
                </div>
            </div>
            
        </div>



        
        <!--[if lt IE 10]>
            <script src="assets/js/placeholder.js"></script>
        <![endif]-->
