


		<footer >
			<!-- style="bottom:0;position:fixed;width:100%;margin-bottom:1em;" -->
			<div class="footer-content" >
				<hr>
				<div class="container">
					<div class="row">
						<div class="col-12 col-sm-6">
							<p class="mb-0 text-muted">
							Copyright &copy; <?= date('Y') ?>
							| <?= (ENVIRONMENT!='production')?ENVIRONMENT:""?>
							| <b>CI</b> <?php echo CI_VERSION; ?>
							| <?= $this->agent->platform() ?>
							| <?= $this->input->ip_address() ?>
							<br>
							| <?= gethostname() ?>
							| <?= $this->agent->browser() ?>
							| <?= $this->agent->version() ?>
							| Page Loader <?=  $this->benchmark->elapsed_time(); ?>
							| Memory <?=  $this->benchmark->memory_usage(); ?>
							</p>
						</div>
						<div class="col-sm-6 d-none d-sm-block">
							<ul class="breadcrumb pt-0 pe-0 mb-0 float-end">
								<li class="breadcrumb-item mb-0 text-medium">
									<a href="#" class="btn-link">Review</a>
								</li>
								<li class="breadcrumb-item mb-0 text-medium">
									<a href="#" class="btn-link">Docs</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</footer>

		</div> <!-- End Container -->
		
	</main>

	<!-- </div> -->

</div> <!-- End Root -->


	

	<?= $this->load->view('templates/scripts'); ?>


</body>
</html>