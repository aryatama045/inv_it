<?php if($this->session->flashdata('success')){ ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong><?php echo $this->session->flashdata('success'); ?> </strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php } ?>

<?php if($this->session->flashdata('error')) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong><?php echo $this->session->flashdata('error'); ?> </strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php } ?>

<?php if(validation_errors()){ ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error !!</strong>
        <p><?php echo validation_errors(); ?></p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php } ?>






