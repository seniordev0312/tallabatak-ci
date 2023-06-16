<?php include 'includes/header.php'; ?>

<?php 
      $content = $this->common_model->GetSingleData('content_management', array('page'=>'terms'));
     
 ?>

      <!-- Page content-->
      <!-- Page container-->
      <div class="container mt-5 mb-md-4 py-5">
        <div class="row">
          <!-- Page content-->
          <div class="col-lg-12">
            <!-- Breadcrumb-->
            <nav class="mb-3 pt-md-3" aria-label="Breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Terms Condition</li>
              </ol>
            </nav>
            
            <section class="card card-body border-0 shadow-sm p-4 mb-4" id="location">
              <h2 class="h4 mb-4">Terms Condition</h2>

             <?= $content['content'] ?>

               
            </section>
          
          </div>
        </div>
      </div>
    </main>


<?php include 'includes/footer.php'; ?>

