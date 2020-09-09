    <?php
    $css = plugins_url( 'assets/css', __FILE__ );
    $js = plugins_url( 'assets/js', __FILE__ );
    $fonts = plugins_url( 'assets/fonts', __FILE__ );
    $fileupload = plugins_url( 'file-upload.php', __FILE__ );
    ?>
    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="https://onyxdev.net/files/assets/images/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="https://onyxdev.net/files/assets/images/favicons/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="https://onyxdev.net/files/assets/images/favicons/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="https://onyxdev.net/files/assets/images/favicons/manifest.json">
    <link rel="mask-icon" href="https://onyxdev.net/files/assets/images/favicons/safari-pinned-tab.svg" color="#34b2a7">
    <link rel="shortcut icon" href="https://onyxdev.net/files/assets/images/favicons/favicon.ico">
    <meta name="msapplication-config" content="https://onyxdev.net/files/assets/images/favicons/browserconfig.xml">
    <meta name="theme-color" content="#34b2a7">

	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,500,600,700|Open+Sans" rel="stylesheet">
	
	<!-- Libraries/Plugins -->
	<link id="bootstrap-css" href="<?php echo $css; ?>/bootstrap.min.css" rel="stylesheet">
	<link id="dropzone-css" href="<?php echo $css; ?>/dropzone.css" rel="stylesheet">

	<!-- Icons Library -->
	<link id="font-awesome-css" href="<?php echo $css; ?>/font-awesome.min.css" rel="stylesheet">

	<!-- Main CSS -->
	<link id="onyx-css" href="<?php echo $css; ?>/style.css" rel="stylesheet">

	<!-- Wrapper -->
	<div class="wrapper">

		<section class="container-fluid inner-page">

			<div class="row">

				<div class="col-xl-6 offset-xl-3 col-lg-6 offset-lg-3 col-md-12 full-dark-bg">

					<!-- Files section -->
					<h4 class="section-sub-title"><span>Upload</span> Your Files</h4>

					<form action="<?php echo $fileupload; ?>" class="dropzone files-container">
						<div class="fallback">
							<input name="file" type="file" multiple />
						</div>
					</form>

					<!-- Notes -->
					<span>Only JPG, PNG, PDF, DOC (Word), XLS (Excel), PPT, ODT and RTF files types are supported.</span>
					<span>Maximum file size is 25MB.</span>

					<!-- Uploaded files section -->
					<h4 class="section-sub-title"><span>Uploaded</span> Files (<span class="uploaded-files-count">0</span>)</h4>
					<span class="no-files-uploaded">No files uploaded yet.</span>

					<!-- Preview collection of uploaded documents -->
					<div class="preview-container dz-preview uploaded-files">
						<div id="previews">
							<div id="onyx-dropzone-template">
								<div class="onyx-dropzone-info">
									<div class="thumb-container">
										<img data-dz-thumbnail />
									</div>
									<div class="details">
										<div>
											<span data-dz-name></span> <span data-dz-size></span>
										</div>
										<div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
										<div class="dz-error-message"><span data-dz-errormessage></span></div>
										<div class="actions">
											<a href="#!" data-dz-remove><i class="fa fa-times"></i></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Warnings -->
					<div id="warnings">
						<span>Warnings will go here!</span>
					</div>

				</div>
			</div><!-- /End row -->

		</section>

	</div>
	<!-- /Wrapper -->

	<!-- JQuery -->
	<script src="<?php echo $js; ?>/jquery-1.10.2.min.js"></script>

	<!-- Dropzone JS -->
	<script src="<?php echo $js; ?>/dropzone.min.js"></script>

	<!-- Main JS file -->
	<script src="<?php echo $js; ?>/scripts.js"></script>
