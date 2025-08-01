<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Prescription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Indie+Flower&display=swap" rel="stylesheet">
    <style>
        .handwriting {
            font-family: 'Indie Flower', cursive;
            font-size: 1.2rem;
            color: blue;
        }
    </style>
</head>
<body style="width: 80%;" class="container border p-4 mt-4">
    <div class="text-center mb-4">
    <a href="https://berkowits.com/" class="logo-black"><img src="https://berkowits.com/assets//berkowits-logo.webp" alt="logo"></a>
        <br /><br /><label>Pioneer since 1988</label><br />
        <label>Email : inquiry@berkowits.in | Phone: +91 9999 6666 99</label><br />
    </div>
    <hr />
    <div class="row mb-3">
        <div class="col-md-4">
            <label><strong>Date:</strong> <?php echo e($consultationData->preferred_date); ?></label><br />
        </div>
        <div class="col-md-4">
        </div>
        <div class="col-md-4">
            <label><strong>Consultation ID:</strong><?php echo e($consultationData->encryption_id); ?></label><br />
        </div>
    </div>
    <hr />
    <div class="row mb-3">
        <div class="col-md-4">
            <label><strong>Name:</strong> <span class="handwriting"><?php echo e($consultationData->firstname); ?> <?php echo e($consultationData->lastname); ?></span></label><br />
            <label><strong>Age Range:</strong> <span class="handwriting"><?php echo e($consultationData->age_range); ?></span></label><br />
            <label><strong>Gender:</strong> <span class="handwriting"><?php echo e($consultationData->gender); ?></span></label><br />
            <label><strong>Email:</strong> <span class="handwriting"><?php echo e($consultationData->email); ?></span></label><br />
            <label><strong>Phone:</strong><span class="handwriting"><?php echo e($consultationData->phone); ?></span></label><br />
        </div>
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <?php //var_dump($doctorDetails) ?>
            <label><strong>Doctor Name:</strong> <span class="handwriting"><?php echo e($doctorDetails->name); ?></span></label><br />
            <label><strong>Center:</strong> <span class="handwriting">Berkowits</span></label><br />
            <label><strong>Speciality:</strong> <span class="handwriting">General Physician</span></label><br />
            <label><strong>Phone:</strong><span class="handwriting"><?php echo e($doctorDetails->phone); ?></span></label><br />
        </div>
    </div>
    <?php //var_dump($prescription) ?>
    <div class="border-top pt-3">
    <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Diagnosis</th>
                </tr>
            </thead>
            <tbody>
            <?php
                    foreach ($diagnosisi_details as $row_diag) {
                            ?>
                            <tr>
                                <td><span class="handwriting"><?php echo e($row_diag['diagnosis_point']); ?></span></td>
                            </tr>
                            <?php
                        
                    }
                ?>
            </tbody>
        </table>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Medicine / Products</th>
                    <th>Type</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($prescription as $medData) {
                        foreach ($medData['medicine'] as $medicine) {
                            ?>
                            <tr>
                                <td><span class="handwriting"><?php echo e($medicine['medicine_name']); ?></span></td>
                                <!--<td><span class="handwriting"></span></td>-->
                                <td><span class="handwriting"> <?php echo e($medicine['type']); ?></span></td>
                                <td><span class="handwriting"></span></td>
                            </tr>
                            <?php
                        }
                    }
                ?>
            </tbody>
        </table>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Treatmenet/Service</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($treatment_details as $row_treat) {
                            ?>
                            <tr>
                                <td><span class="handwriting"><?php echo e($row_treat['treatment_name']); ?></span></td>
                                <td><span class="handwriting"> <?php echo e($row_treat['treatment_details']); ?></span></td>
                            </tr>
                            <?php
                        
                    }
                ?>
            </tbody>
        </table>
        <label><strong>Instructions:</strong> Take medicines after food. Drink plenty of water.</label><br />
    </div>

    <div class="text-center mt-4">
        <!--<label>________________________</label><br />
        <label>Doctor's Signature</label><br />-->
    </div>
    <div class="text-center mt-3">
        <button class="btn btn-primary" onclick="printPage()">Save PDF</button>
    </div>
    <script>
    function printPage() {
      window.print();
    }
  </script>
</body>
</html>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/berkowits/cma-backend/resources/views/new_prescription.blade.php ENDPATH**/ ?>