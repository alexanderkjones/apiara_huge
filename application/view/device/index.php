<div class="container">
    <h1>DeviceController/index</h1>
    <div class="box">

        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>

        <h3>What happens here ?</h3>
        <div>
            This controller/action/view shows a list of all users in the system. You could use the underlying code to
            build things that use profile information of one or multiple/all users.
        </div>
        <div>
            <table class="overview-table">
                <thead>
                <tr>
                    <td>Device ID</td>
                    <td>Device Serial</td>
                    <td>Device Version</td>
                </tr>
                </thead>
                <?php foreach ($this->devices as $device) { ?>
                    <tr>
                        <td><?= $device->device_id; ?></td>
                        <td><?= $device->device_serial; ?></td>
                        <td><?= $device->device_version; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>
