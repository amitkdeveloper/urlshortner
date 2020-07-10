<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('parts/header');
?>

<div id="container" class="container">
	<h1>Welcome to URL Shortner System</h1>
	<div class="row">
		<div class="col-md-12">
			<?php echo validation_errors(); ?>
		</div>
	</div>
	<form action="<?php echo site_url('/generateURL');?>" method="post">

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="url_to_shortened">Enter URL to be shortened</label>
					<input class="form-control"  id="url_to_shortened" name="url_to_shortened" placeholder="URL" />
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<button type="submit" class="btn btn-info">Generate</button>
				</div>
			</div>
		</div>

		<?php if(!empty($generated_url)){ ?>
		<div class="row">
			<div class="col-md-6">
				<h2> Generated URL : </h2> <br/>
				<a href="<?php echo $generated_url; ?>"><?php echo $generated_url; ?></a>
			</div>
		</div>
		<?php } ?>
	</form>

</div>

<?php
$this->load->view('parts/footer');
?>

