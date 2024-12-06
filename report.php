<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Report</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <div class="d-flex justify-content-center align-items-center vh-100">
    	
    	<form class="shadow w-450 p-3" 
    	      action="php/rep.php" 
    	      method="post"
    	      enctype="multipart/form-data">

    		<h4 class="display-4  fs-1">Report</h4><br>
    		<?php if(isset($_GET['error'])){ ?>
    		<div class="alert alert-danger" role="alert">
			  <?php echo $_GET['error']; ?>
			</div>
		    <?php } ?>

		    <?php if(isset($_GET['success'])){ ?>
    		<div class="alert alert-success" role="alert">
			  <?php echo $_GET['success']; ?>
			</div>
		    <?php } ?>

			<div class="mb-3">
		    <label class="form-label">Name:</label>
		    <input type="text" 
		           class="form-control"
		           name="user"
		           value="<?php echo (isset($_GET['user']))?$_GET['user']:"" ?>">
		  </div>


		  <div class="mb-3">
		    <label class="form-label">Title</label>
		    <input type="text" 
		           class="form-control"
		           name="title"
		           value="<?php echo (isset($_GET['title']))?$_GET['title']:"" ?>">
		  </div>

		  <div class="mb-3"> 
     <label class="form-label">Details</label>
    <textarea rows="5" class="form-control" cols="30" name="details" placeholder="Write your details here..">
        <?php echo isset($_GET['details']) ? $_GET['details'] : ""; ?>
    </textarea>
</div>


		  <div class="mb-3">
		    <!-- <label class="form-label">Type of Report</label>
		    <select id="reportType" name="type" class="form-control">
                            <option value="">Select Report Type</option>
                            <option value="caution">Caution</option>
                            <option value="cleaning">Cleaning</option>
                            <option value="electrical-hazard">Electrical Hazard</option>
                            <option value="it-maintenance">IT Maintenance</option>
                            <option value="repair">Repair</option>
                            <option value="request">Request</option>
                        </select> -->
						<label for="reportType">Type of Report</label>
						<input type="text" id="reportType" name="type" readonly>

		  </div>

		  <div class="mb-3">
		    <label class="form-label">Upload a file:</label>
		    <input type="file" 
		           class="form-control"
		           name="image">
		  </div>
		  <div class="mb-3">
                        <label for="reportDate" class="date-label">Report Date:</label>
                        <input type="date"  name="date" class="date-picker">
        </div>

		
		
		  <button type="submit" class="btn btn-primary">Submit</button>
		  <button type="submit" class="btn btn-primary">Close</button>
		</form>
    </div>
</body>
</html>