<html>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <title>Tip Calculator</title>
    </head>
    <body>
        <div class="container-fluid">
        <!-- Determine if bill subtotal is valid and which radio button is selected. -->
        	<?php
	        	$total = 0;
				$subtotal = 0;
				$tip_percentage = 0;
				$valid_input = true;
				$form_submitted = false;
        		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        			if (!empty($_POST['amount'])) {
        				$form_submitted = true;
        				$subtotal = $_POST['amount'];
        				if (!preg_match("(^[0-9]*\.?[0-9]+$)", $subtotal)) {       					
        					$valid_input = false;
        				}        				
        			}
        			if (isset($_POST['percent'])) {
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
						}
        			}
        		}
        	?>

            <h2 class="text-primary">Tip Calculator</h2>
            <form action="calculate.php" method="post">
                <table border="0">
                    <tr>
                        <td>Bill Subtotal: $</td>
                        <?php if (!empty($_POST['amount'])) { ?>
                        	<td><input type="text" placeholder="Enter payment amount..." name="amount" value="<?php echo $subtotal; ?>" required /></td>
                        <?php } ?>
                        <?php if (empty($_POST['amount'])) { ?>
                        	<td><input type="text" placeholder="Enter payment amount..." name="amount" required /></td>
                        <?php } ?>
                    </tr>
                </table>
                <p>Tip Percentage:</p>
                <?php
                	$tip_percents = [10.0, 15.0, 20.0];
                	foreach ($tip_percents as $percent) {
                		$visual_percent = intval($percent) . "%";
                    	printf ("<input type=\"radio\" name=\"percent\" value=\"%0.2f\" %s /> %d%% \t", $percent / 100, $percent == $tip_percentage * 100 ? "checked" : "", $percent);
                	}
                ?>
	            
                <div name="submit" class="col-xs-44"><button type="submit" class="btn btn-primary">Submit</button></div>
            </form>
        </div>

		<script language='javascript'>
			<?php if (!$valid_input) { ?>
				window.onload = function() {
					alert("<?php echo 'Please enter a valid bill subtotal.'; ?>");
				}
			<?php } ?>
			<?php if ($form_submitted && !isset($_POST['percent'])) { ?>
				window.onload = function() {
					alert("<?php echo 'Please select a percentage to tip.'; ?>");
				}
			<?php } ?>
		</script>

		<?php
			if ($valid_input && !empty($_POST['amount']) && isset($_POST['percent'])) {
				if (isset($_POST['percent'])) {
					$total = $subtotal + ($subtotal * $tip_percentage);
					$tip = $tip_percentage * $subtotal;
					echo "Tip: $";
					echo number_format($tip, 2);
					echo "<br />";
					echo "Total: $";
					echo number_format($total, 2);
				}
			}
		?>
    </body>
</html>