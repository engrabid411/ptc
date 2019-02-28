<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
<?php 
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
</head>
<body>
	<div>
		<a href='<?php echo site_url('admin/user_management')?>'>Users</a> | 
		<a href='<?php echo site_url('admin/student_management')?>'>Students</a> |
		<a href='<?php echo site_url('admin/school_management')?>'>Schools</a> |
		<a href='<?php echo site_url('admin/classroom_management')?>'>Class Rooms</a> |
		<a href='<?php echo site_url('admin/subjects_management')?>'>Subjects</a> |
		<a href='<?php echo site_url('admin/classes_management')?>'>Classes</a> 
		
		
	</div>
	<div style='height:20px;'></div>  
    <div style="padding: 10px">
		<?php echo $output; ?>
    </div>
    <?php foreach($js_files as $file): ?>
        <script src="<?php echo $file; ?>"></script>
    <?php endforeach; ?>
</body>
</html>
