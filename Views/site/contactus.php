<?php include 'includes/header.php'; ?>

<?php 
      $footer_data = $this->common_model->GetSingleData('admin', array('id'=>1));
      $footer_social = $this->common_model->GetAllData('social_management','','id','desc');
 ?>

      <!-- Page content-->
      <!-- Page container-->
      <div class="container mt-5 mb-md-4 py-5">
        <div class="row">
          <!-- Page content-->
          <div class="col-lg-8">
            <!-- Breadcrumb-->
            <nav class="mb-3 pt-md-3" aria-label="Breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
              </ol>
            </nav>
            
            <section class="card card-body border-0 shadow-sm p-4 mb-4" id="location">
              <h2 class="h4 mb-4">Contact Us</h2>
                <?= $this->session->getFlashdata('msg'); ?>
               <form method="post" onsubmit="return Contactus(event)" id="Contactus" enctype="multipart/form-data">
              <div class="row">
                <div class="col-sm-6 mb-3">
                  <label class="form-label">Name<span class="text-danger">*</span></label>
                   <input type="text" name="name" class="form-control" id="" placeholder="Name" value="" required>
                </div>
                <div class="col-sm-6 mb-3">
                  <label class="form-label">Email <span class="text-danger">*</span></label>
                   <input type="email" name="email" class="form-control" id="" placeholder="Email" value="" required>
                </div>
              </div>
              <div class="row">
                <div class="mb-3">
                  <label class="form-label">Phone<span class="text-danger">*</span></label>
                  <input type="number" min="0" name="phone" class="form-control" id="" placeholder="Phone" value="" required>
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label">Message<span class="text-danger">*</span></label>
                <textarea required name="message" class="form-control" id="" rows="5" placeholder="Message"></textarea>
              </div>
            </section>


           
            
            
            <!-- Action buttons -->
            <section class="d-sm-flex justify-content-between pt-2">
              <button class="btn btn-primary btn-lg d-block mb-2" id="addbtn" type="submit">Submit</button>
            </section>
          </form>
          </div>
          <!-- Progress of completion-->
          <aside class="col-lg-3 offset-lg-1 d-none d-lg-block">
            <div class="sticky-top pt-5">
              <h6 class="pt-5 mt-3 mb-2">Contact</h6>
              <div class="progress mb-4" style="height: .25rem;">
                <div class="progress-bar bg-primary" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <ul class="list-unstyled">
                <li class="d-flex align-items-center"><a class="d-inline-block mb-4" href="#"><img src="<?= base_url() ?>/assets/site/imgs/logo.png" width="116" alt="logo"></a></li>
                <li class="d-flex align-items-center"><a class="nav-link p-0 fw-normal" href="<?= $footer_data['footer_email']; ?>"><i class="fi-mail mt-n1 me-2 align-middle opacity-70"></i><?= $footer_data['footer_email']; ?></a></li>
                <li class="d-flex align-items-center"><a class="nav-link p-0 fw-normal" href="tel:<?= $footer_data['footer_phone']; ?>"><i class="fi-device-mobile mt-n1 me-2 align-middle opacity-70"></i><?= $footer_data['footer_phone']; ?></a></li>
                
              </ul>
            </div>
          </aside>
        </div>
      </div>
    </main>


<?php include 'includes/footer.php'; ?>

<script type="text/javascript">
    function Contactus(event) {
     
        event.preventDefault();
    $('.alert-danger').remove();
        var data = new FormData($('#Contactus')[0]);

        $.ajax({
              url: '<?= base_url()?>/Home/add_contact',
              data: data,
              processData: false,
              contentType: false,
              type: 'POST',
        dataType:'json',
        beforeSend: function() {        
            $('#addbtn').prop('disabled' , true);
            $('#addbtn').text('Processing..');
          },
              success: function(result){
            $('#addbtn').prop('disabled' , false);
            $('#addbtn').text('Add');
            if(result.status == 1)
            {
              window.location.reload();
            }
            else
            {
              console.log(result.message);
              for (var err in result.message) {
            
              $("[name='" + err + "']").after("<div  class='label alert-danger'>" + result.message[err] + "</div>");
              }
            }
        }
        });
    return false;
  } 
</script>