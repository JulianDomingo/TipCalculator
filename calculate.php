<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.5/css/bootstrap-flex.css"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=VT323">
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Abel">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <title>Tip Calculator</title>

        <style>
            #ex1Slider .slider-selection {
                background: #BABABA;
            }
            #customTip {
                display: none;
                margin-top: 10px;
            }
            #result {
                padding-left: 4px;
                border-left: 4px solid #29a3a3;
                background-color: #ffff66;
                font-family: Abel, Monospace;
                font-size: 20px;
            }
            #noRadioSelected {
                margin-top: 10px;
            }
            .splitHeader {
                float: left;
            }
            .party {
                float: left;
                position: relative;
                top: 10px;
                left: 240px;
            }
            .splitNum {
                float: left;
                position: relative;
                top: 3px;
                left: 242px;
                font-weight: bold;
            }
            h2 {
                font-family: VT323, Monospace;
                font-size: 60px;
            }
            p {
                font-family: Abel, Monospace;
                font-size: 15px;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid">
        <!-- Determine if bill subtotal is valid and which radio button is selected. -->
        	<?php
	        	$total = 0;
				$subtotal = 0;
				$tip_percentage = 0;
				$valid_subtotal_input = true;
                $valid_custom_tip_input = true;
                $radio_selected = false;
				$form_submitted = false;
                $is_custom_tip = false;
        		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        			if (!empty($_POST['amount'])) {
        				$form_submitted = true;
        				$subtotal = $_POST['amount'];
        				if (!preg_match("(^[0-9]*\.?[0-9]+$)", $subtotal)) {  
        					$valid_subtotal_input = false;
        				}        				
        			}
        			if (isset($_POST['percent'])) {
                        $radio_selected = true;
						switch ($_POST['percent']) {
							case ".10":
								$tip_percentage = .1;
								break;
							case ".15":
								$tip_percentage = .15;
								break;
							case ".20":
								$tip_percentage = .2;
								break;
                            case "custom": 
                                if (!empty($_POST['customTip'])) {
                                    $tip_percentage = $_POST['customTip'];
                                    if (!preg_match("(^[0-9]*\.?[0-9]+$)", $tip_percentage)) {  
                                        $valid_custom_tip_input = false;
                                    }
                                    $tip_percentage = floatval(intval($tip_percentage)) / floatval(100); 
                                    $is_custom_tip = true;
                                }
                                else {
                                    $valid_custom_tip_input = false;
                                }
                                break;
						}
        			}
                    $split_party = $_POST['splitRange'];
        		}
        	?>

            <nav class="navbar navbar-default" role="navigation">
                <div class="container">
                    <ul class="nav navbar-nav">
                        <li id="navBarHome" class="active"><a href="#"><i class="fa fa-home" aria-hidden="true">Home</i></a></li>
                        <li><a href="#"><i class="fa fa-info-circle">About</i></a></li>
                    </ul>
                </div>
            </nav>

            <div class="container">
                <div id="#header" class="jumbotron">
                    <h2>Tip Calculator</h2>
                    <p>A simple web application demonstrating form processing. Server-side written in PHP, design in HTML and CSS.</p>
                </div>  
            </div> 

            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="jumbotron">
                            <form id="liveForm" action="calculate.php" method="post">
                                <?php if (!empty($_POST['amount'])) { ?>
                                    <div class="form-group">
                                        <label>Bill Subtotal</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">$</div>
                                            <input type="text" name="amount" class="form-control" placeholder="Enter payment amount..." value="<?php echo $subtotal; ?>" required />
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if (empty($_POST['amount'])) { ?> 
                                    <div class="form-group">
                                        <label>Bill Subtotal</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">$</div>
                                            <input type="subtotal" name="amount" class="form-control" value="<?php echo 0; ?>" required />
                                        </div>
                                    </div>
                                <?php } ?>

                                <div id="invalidSubtotal" class="alert alert-danger alert-dismissible collapse" role="alert">
                                    <a href="#" id="closeSubtotalAlert" data-dismiss="alert" aria-label="Close" class="close">&times;</a>
                                    <strong>Oops! </strong>Please enter a valid bill subtotal.
                                </div>
                              
                                <label>Tip Percentage:</label>  
                                <br /> 
                                <?php
                                	$tip_percents = [10.0, 15.0, 20.0];
                                	foreach ($tip_percents as $percent) {
                                		$visual_percent = intval($percent) . "%";
                                    	printf ("<input type=\"radio\" name=\"percent\" value=\"%0.2f\" %s /> %d%% \t", $percent / 100, $percent == $tip_percentage * 100 ? "checked" : "", $percent);
                                	}
                                    $custom = "custom";
                                    printf ("<input type=\"radio\" name=\"percent\" value=\"%s\" /> ", $custom);
                                    printf ("Custom"); 
                                ?>

                                <!-- Custom tip input (visible only when custom radio button is selected). -->
                                <div id="customTip" class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">%</div>
                                        <input type="customTip" name="customTip" class="form-control" />
                                    </div>
                                </div>

                                <div id="invalidCustomTip" class="alert alert-danger alert-dismissible collapse" role="alert">
                                    <a href="#" id="closeCustomTipAlert" data-dismiss="alert" aria-label="Close" class="close">&times;</a>
                                    <strong>Try again.</strong> Enter a valid tip amount.
                                </div>

                                <div id="noRadioSelected" class="alert alert-danger alert-dismissible collapse" role="alert">
                                    <a href="#" id="closeRadioAlert" data-dismiss="alert" aria-label="Close" class="close">&times;</a>
                                    <strong>Hold your horses! </strong>Don't forget to select a tipping choice.
                                </div>

                                <br />
                                <div class="sameline">
                                    <div class="splitHeader"><label style="margin-top: 10px">Split the Tip!</label></div>
                                    <div class="party">Party Number: </div>
                                    <div class="splitNum"><output id="splitRangeOutput">1</output></div>
                                </div>
                                <input type="range" name="splitRange" id="splitRange" min="1" max="100" value="1" step="1" oninput="splitRangeOutput.value = splitRange.value">

                                <div style="padding-top: 10px;" name="submit" class="col-xs-44"><button type="submit" class="btn btn-primary">Submit</button></div>
                            </form>
                        </div>
                    </div> 
                    <div class="col-md-6">
                        <div class="jumbotron">
                            <?php if ($valid_subtotal_input && $valid_custom_tip_input && isset($_POST['percent'])) {
                                $total = $subtotal + ($subtotal * $tip_percentage);
                                $tip = $tip_percentage * $subtotal;
                            ?>
                                <div id="result">
                                    <?php
                                        if ($split_party > 1) { 
                                            echo "You split the bill with ", $split_party, " people.", "<br />";
                                        }
                                    ?>
                                    <?php 
                                        if ($is_custom_tip) { 
                                            echo "Custom Tip Percentage: "; 
                                            echo number_format(floatval(floatval($tip_percentage * 100) / floatval($split_party)), 2); 
                                            echo "%";
                                            echo "<br />";
                                        }
                                    ?>
                                    <?php echo "Tip Amount: $"; echo number_format(floatval(floatval($tip) / floatval($split_party)), 2); echo "<br />" ?>
                                    <?php echo "Total: $"; echo number_format(floatval(floatval($total) / floatval($split_party)), 2); ?>
                                </div> 
                            <?php } ?>
                        </div> 
                    </div>
                </div>
            </div>
        </div>

        <!-- Javascript function to close alert boxes. -->
        <script type="text/javascript">
            $(document).ready(function () {
                $('#closeRadioAlert').click(function () {
                    $('#noRadioSelected').hide('fade');
                });
                $('#closeSubtotalAlert').click(function () {
                    $('#invalidSubtotal').hide('fade');
                });
                $('#closeCustomTipAlert').click(function () {
                    $('#invalidCustomTip').hide('fade');
                });
            });
        </script>

        <!-- Javascript function to open alert boxes with invalid forms. -->
        <script type="text/javascript">
            $(function () {  
                var isValidSubtotal = "<?php echo $valid_subtotal_input; ?>";
                var isValidCustomTip = "<?php echo $valid_custom_tip_input; ?>";
                var isSelected = "<?php echo $radio_selected; ?>";
                var isFormSubmitted = "<?php echo $form_submitted; ?>";

                if (!isValidSubtotal) {
                    $('#invalidSubtotal').slideDown();
                }
                if (!isValidCustomTip) {
                    $('#invalidCustomTip').slideDown();
                }
                if (!isSelected && isFormSubmitted) {
                    $('#noRadioSelected').slideDown();
                }   
            });
        </script>

        <script type="text/javascript">
            $('input:radio[name="percent"]').change(function() {
                if ($(this).is(':checked') && $(this).val() == 'custom') {
                    // $("customTip").removeClass("hidden");
                    $('#customTip').show('fade');
                }
                else {
                    $('#customTip').hide('fade');
                }
            });
        </script>

    </body>
</html>