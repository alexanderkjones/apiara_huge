<div class="container">
    <h1>DeviceController/new</h1>
    <div class="box">

        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>

        
        <?php 

            if ($this->result) {
                var_dump($this->result) 
            }else{
                echo "No Result";
            }

        ?>
    </div>
</div>