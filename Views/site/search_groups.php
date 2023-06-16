<?php include 'includes/header.php'; ?>
<?php 
$getdata = get_client_location();
//print_r($getdata);
if(isset($_GET['country']) )
{
	$getdata['country'] = $_GET['country'];
}
if(isset($_GET['state']) )
{
	$getdata['state'] = $_GET['state'];
}
if(isset($_GET['city']) )
{
	$getdata['city'] = $_GET['city'];
}

 ?>
<div class="container-fluid mt-5 pt-5 p-0">
  <div class="row g-0 mt-n3">
  	<div class="col-lg-12 col-xl-12 position-relative overflow-hidden pb-5 pt-4 px-3 px-xl-4 px-xxl-5">
		<nav class="mb-3 pt-md-2" aria-label="Breadcrumb">
		    <ol class="breadcrumb">
		      <li class="breadcrumb-item"><a href="#">Home</a></li>
		      <li class="breadcrumb-item active" aria-current="page">Groups</li>
		    </ol>
		</nav>
	</div>
		 <!-- Filters sidebar (Offcanvas on mobile)-->
		<aside class="col-lg-4 col-xl-3 border-top-lg border-end-lg shadow-sm px-3 px-xl-4 px-xxl-5 pt-lg-2">
			<div class="offcanvas offcanvas-start offcanvas-collapse" id="filters-sidebar">
				<div class="offcanvas-header d-flex d-lg-none align-items-center">
					<h2 class="h5 mb-0">Filters</h2>
					<button class="btn-close" type="button" data-bs-dismiss="offcanvas"></button>
				</div>
				<div class="offcanvas-body py-lg-4">
					<form action="" method="get" id="search_product" >
						
						<div class="pb-4 mb-2">
							<h3 class="h6">Country</h3>
							<div class="overflow-auto" data-simplebar data-simplebar-auto-hide="false" >
								
								<select class="form-control country-dropdown country_filter" name="country" id="" data-id="s" data-selected="<?= (@$getdata['state']) ? $getdata['state'] : '' ?>">
									
									<?php
									$countries = $this->common_model->GetAllData('countries' , '' , 'name' , 'asc');
									foreach($countries as $row) {
									?>
									<option <?= (@$getdata['country'] == $row['id']) ? 'selected' : '' ?> value="<?php echo $row['id'];?>"><?php echo $row["name"];?></option>
									<?php
									}
									?>
									
								</select>
								
							</div>
						</div>
						<div class="pb-4 mb-2">
							<h3 class="h6">State</h3>
							<div class="overflow-auto" data-simplebar data-simplebar-auto-hide="false" >
								
              <select class="form-control state-dropdown" data-id="s" data-selected="<?= (@$getdata['city']) ? $getdata['city'] : '' ?>" name="state" id="state-dropdowns">
                 
              </select>
              
								
							</div>
						</div>
						<div class="pb-4 mb-2">
							<h3 class="h6">City</h3>
							<div class="overflow-auto" data-simplebar data-simplebar-auto-hide="false" >
								
              <select class="form-control city-dropdown" data-id="" data-selected="0" name="city" id="city-dropdowns">
                 
              </select>
              
								
							</div>
						</div>
						<div class="border-top py-4">
						<button class="btn btn-outline-primary btn-xs" type="submit">Search</button>
					</div>
					</form>
					<div class="border-top py-4">
						<a class="btn btn-outline-primary btn-xs" href="<?= base_url('groups') ?>"><i class="fi-rotate-right me-2"></i>Reset filters</a>
					</div>
				</div>
			</div>
		</aside>
<div class="col-lg-8 col-xl-9 position-relative overflow-hidden pb-5 pt-4 px-3 px-xl-4 px-xxl-5">
		<div class="row g-4 py-4" id="filter_data">
			<!-- Loop -->
			<?php if ($groups): ?>
				<?php foreach ($groups as $key => $value): ?>
					<?php 

								$admin = $this->common_model->GetSingleData('users' , ['id'=> $value['create_by']]);
								if (!$admin) {
									continue;
								}
								$member_array = explode(',', $value['members']);
								 
				if ($this->user_id)
       {
   
           $link_attr = 'onclick="get_group_info('.$value['id'] .' , 1)"';
        }
        else
        {
        	$link_attr = 'href="#signin-modal" data-bs-toggle="modal"';
        }
             ?>
				<div class="col-sm-6 col-xl-4" <?= $link_attr ?>>
					<div class="card shadow-sm card-hover border-0 h-100">
						<div class="tns-carousel-wrapper card-img-top card-img-hover"><a class="img-overlay" href="javascript:;"></a>
						<div class="tns-carousel-inner">
	                    	<img src="<?= base_url($value['icon']) ?>" alt="Image">
	                  	</div>
					</div>
					<div class="card-body position-relative pb-3">
						
						<h3 class="h6 mb-2 mt-1 fs-base">
							<a class="nav-link stretched-link" <?= $link_attr ?>><?= $value['group_name'] ?></a>
						</h3>
						
						<div class="d-flex align-items-center text-decoration-none" href="#">
							<img class="rounded-circle loaded tns-complete" src="<?= base_url($admin['image']) ?>" alt="Test" width="44">
							<div class="ps-2">
								<?php $city = $this->common_model->GetSingleData('cities' , array('id' => $value['city'])); ?>
								<h4 class="mb-0 h4 fs-xs text-primary"><i class="fi-map-pin me-2"></i> <?= $city['name'] ?></h4>
								<h6 class="fs-sm text-nav lh-base mb-1"><?= $admin['name'] ?></h6>
								<div class="d-flex text-body fs-xs"><span class="me-2 pe-1"><i class="fi-calendar-alt opacity-70 mt-n1 me-1 align-middle"></i><?= $value['create_date'] ?></span><span><i class="fa fa-user opacity-70 mt-n1 me-1 align-middle"></i><?= count($member_array) ?> members</span></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php endforeach ?>
			<div class="col-lg-12">
				<?php if ($pager) :?>
              <?= $pager->links() ?>
              <?php endif ?>   
			</div>
		<?php else: ?>
			<div class="col-lg-12 alert alert-danger">No Groups Founds in your area please try another filters</div>
		<?php endif ?>
		</div>
	</div>
		</div>
	</div>

<?php include 'includes/footer.php'; ?>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('.country_filter').trigger('change')
	});
	
</script>