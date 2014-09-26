<div class="wrap">
	<?php if(is_admin())
    echo "<h2>" . __( 'Contacts Directory', 'directory_trdom' ) . "</h2>"; ?>
    
    <h4>Add new contact</h4>
    
    <form class="form-inline" method="get" >
		<input type="text" placeholder="Name" name="name" id="name" maxlength="50" style="height:35px;">
		<input type="text" class="numonly" placeholder="Contact Number" name="contact" id="contact" maxlength="10" style="height:35px;">
		<input type="button" id="btn_save" name="save" class="btn btn-primary" style="width:80px;height:35px;" value="Save" >
		<input type="hidden"  value="<?= get_home_url(); ?>" id="home_url">
    </form>
     
    <div id="msg" style="width: 40%;margin-top:10px;"></div>
     
    <h4>All contacts</h4>
<?php $plugin_base = home_url().'/wp-content/plugins/Telephone-Directory/'; ?>
<link href="<?php echo $plugin_base.'assets/css/style.css'; ?>" rel="stylesheet" media="screen" />
<link href="<?php echo $plugin_base.'assets/css/bootstrap.css'; ?>" rel="stylesheet" media="screen" />

<script src="<?php echo $plugin_base.'assets/js/jquery-1.11.1.min'; ?>" ></script>
<script src="<?php echo $plugin_base.'assets/js/bootstrap.min.js'; ?>" ></script>
<link href="<?php echo $plugin_base.'assets/css/jquery.dataTables1.css'; ?>" rel="stylesheet" />

<script src="<?php echo $plugin_base.'assets/js/jquery.dataTables.min.js';?>"></script>

<script src="<?php echo $plugin_base.'assets/js/jquery.confirm.js'; ?>" type="text/javascript"></script>

<?php

   	include get_home_url().'/wp-config.php';
 	global $wpdb;

if(is_admin())
{
	 	$a = $wpdb->prefix . "directory";
	 	$b = $wpdb->prefix . "users";
	 	
	 	if(current_user_can('manage_options'))
	 	{
	 		$sql = "SELECT a.id,a.name,a.contact,b.user_login FROM  $a a ,$b b where a.user_id = b.ID";
	 	}
	 	else
	 	{
	 		$id = get_current_user_id();
	 		$sql = "SELECT a.id,a.name,a.contact,b.user_login FROM  $a a ,$b b where a.user_id = b.ID and a.user_id = $id";
	 	}
	 	$results =  $wpdb->get_results($sql);
	
	?>
     
    <table id="myTable" class="display" cellspacing="0" width="100%">
     	<thead style="text-align:left;">
	 		<th>Sl No</th>
	 		<th>Name</th>
	 		<th>Contact</th>
	 		<?php if (current_user_can( 'manage_options' )) 
	 		{ ?>
	 		<th>Created By</th>
	 		<?php } ?>
	 		<th>Actions</th>
     	</thead>
     	<tfoot>
            <tr>
                <th></th>
	 			<th>Name</th>
	 			<th></th>
	 			<th>Created By</th>
	 			<th></th>
            </tr>
        </tfoot>
     	<tbody>
     		<?php
     		$sl = 1;
     		foreach($results as $contact)
	 		{ ?>
     		<tr id="tr_<?= $contact->id; ?>">
     			<td><?=$sl; ?></td>
     			<td><?= $contact->name; ?></td>
     			<td><?= $contact->contact; ?></td>
     			<?php if (current_user_can( 'manage_options' )) 
	 			{ ?>
     				<td><?= $contact->user_login; ?></td>
     			<?php } ?>
     			<td>
		 		<a href="#myModal" class="edit" data-id="<?= $contact->id; ?>"  data-name="<?= $contact->name; ?>" data-contact="<?= $contact->contact; ?>" data-toggle="modal"><img src="<?php echo home_url().'/wp-content/plugins/Telephone-Directory/assets/images/edit.png'; ?>" title="Edit"></img></a>
		 		<a href="#" class="delete" onclick="deletes('<?= $contact->id; ?>','<?= $contact->name; ?>')"><img src="<?php echo home_url().'/wp-content/plugins/Telephone-Directory/assets/images/trash.png'; ?>" title="Delete"></img></a></td>
     		</tr>
     		<?php $sl++; } ?>
     	</tbody>
     
    </table>
</div>


<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Edit</h3>
  </div>
  <div class="modal-body">
	   <form class="form-inline" method="get" >
			Name : <input type="text" placeholder="Name" name="update_name" id="update_name" maxlength="50" style="height:30px;"><br><br>
			Contact: <input type="text" class="numonly" placeholder="Contact Number" name="update_contact" id="update_contact" maxlength="15" style="height:30px;">
			<input type="hidden" id="update_id">
			<input type="hidden"  value="<?= get_home_url(); ?>" id="up_home_url">
    		<div id="update_msg" style="width: 40%;margin-top: 10px;"></div>
  </div>
  
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button class="btn btn-primary btn_update">Save changes</button>
       </form>
  </div>
</div>



<link href="<?php echo $plugin_base.'assets/js/datatables/media/css/jquery.dataTables1.css'; ?>" rel="stylesheet" />

<script src="<?php echo $plugin_base.'assets/js/datatables/media/js/jquery.dataTables.min.js';?>"></script>

<script src="<?php echo $plugin_base.'assets/js/plugin.js';?>"></script>

<?php }
else
{

if(current_user_can('manage_options'))
{

?>

<link href="<?php echo $plugin_base.'assets/css/album.css'; ?>" rel="stylesheet" media="screen" />
<link href="<?php echo $plugin_base.'assets/css/flipbook.css'; ?>" rel="stylesheet" media="screen" />

<script src="<?php echo $plugin_base.'assets/js/flipbook.min.js'; ?>" ></script>
<script src="<?php echo $plugin_base.'assets/js/plugin.js';?>"></script>
	
		
		<script type="text/javascript">
			$("document").ready(function(){				
				$("#demo").flipbook({
					page_width: 320,
					page_height: 360,
					flip_duration: 2000,
					horizontal: true,
					controls: {
						paging_length: 5,
						click: "flip", //"slideshow", "flip"
						slideshow_delay: 2000
					}
				});
			});
		</script>
	</head>
	<body>		
	
		<div class="box">
			<div class="center">
				<div id="demo">
				
					<div class="flipbook-preloader">
						<p>
							<img src="<?php echo home_url().'/wp-content/plugins/Telephone-Directory/assets/images/ajax-loader.gif';?>" alt="Loading..." title="Loading..."/>
						</p>
					</div>
					
					<!-- book -->
					<div class="flipbook">

						<!-- pages -->
						<ul class="flipbook-ul">
							
							<!-- page 1 -->
							<li class="flipbook-ul-li">					
								<div class="flipbook-page page1" style="background: #fff url('<?php echo home_url().'/wp-content/plugins/Telephone-Directory/assets/images/cover.png';?>');"><span class="index"><?php $current_user = wp_get_current_user(); echo $current_user->display_name; ?></span></div>
							</li>
							

<?php
	$k = 2;	
	for($i=97;$i<123;$i++)
	{
		
		$letter = chr($i);
	
		$a = $wpdb->prefix . "directory";
		$id = get_current_user_id();

		$sql = "Select * from $a where user_id = $id and name like '$letter%'";
		$result = $wpdb->get_results($sql);
		$count = $wpdb->num_rows;
		

		 ?>
			<!-- page 2 -->
			<li class="flipbook-ul-li">
				<div  <?php if($k%2==0){?> class="flipbook-page page<?=$k;?> page-left" <?php }else{?> class="flipbook-page page<?=$k;?> page-right" <?php } ?>>
		<div style="height:315px;overflow-y: hidden;">
		<div style="width:120px;float:left;margin-left:30px;margin-top:10px;"><b>Name</b></div>
		<div style="width:150px;float:left;margin-bottom:10px;margin-top:10px;"><b>Contact</b></div>
		<input type="hidden"  value="<?= get_home_url(); ?>" id="up_home_url">
		<br>		
		<?php foreach($result as $row) {
		?>	
			<div class="row_<?= $row->id; ?>">
			<div  <?php if($k%2==0){?> style="width:125px;float:left;margin-left:10px;" <?php }else{?> style="width:110px;float:left;margin-left:15px;" <?php } ?> >
				<span class="span_name_<?= $row->id; ?>"><?= $row->name; ?></span>
				<span class="txt_name_<?= $row->id; ?> hid"><input type="text" value="<?= $row->name; ?>" class="update update_n_<?= $row->id; ?>" style="width:80px;"></span>
				</div>
			<div style="width:125px;float:left;">
				<span class="span_contact_<?= $row->id; ?>"><?= $row->contact; ?></span>
<span class="txt_contact_<?= $row->id; ?> hid"><input class="update update_c_<?= $row->id; ?>" type="text" value="<?= $row->contact; ?>">
</span>
</div>
			<div style="float:left;">
			
			<span class="ee_<?= $row->id; ?>">
                        <a  onclick="edit(<?= $row->id; ?>)" title="Edit"><img src="<?php echo home_url().'/wp-content/plugins/Telephone-Directory/assets/images/pencil.png';?>"></img></a>

			<a  onclick="removes(<?= $row->id; ?>,'<?= $row->name; ?>')" title="Delete"><img src="<?php echo home_url().'/wp-content/plugins/Telephone-Directory/assets/images/delete.png'; ?>"></img></a>
			</span>

			 <span class="cc_<?= $row->id; ?> hid">
			 <a  onclick="save(<?= $row->id; ?>)" title="Save"><img src="<?php echo home_url().'/wp-content/plugins/Telephone-Directory/assets/images/disk.png';?>"></img></a>
			<a  onclick="cancel(<?= $row->id; ?>)" title="Cancel"><img src="<?php echo home_url().'/wp-content/plugins/Telephone-Directory/assets/images/cancel.png'; ?>"></img></a>
			</span>


			</div>
			</div>
		<?php } ?>
		</div>
			<p class="title"><span class="pageno"><?=  ucwords($letter); ?></span></p>
				</div>
			</li>
		<?php 
		$k++;
		}
		?>

						</ul>				
					</div>
										
					<!-- book buttons -->
					<div class="flipbook-controls">
						<ul class="paging-ul">
							<li class="first-btn"><input type="button" class="btn first-btn-off" value=" "/></li>
							<li class="prev-btn"><input type="button" class="btn prev-btn-off" value=" "/></li>
							<li class="paging"></li>
							<li class="next-btn"><input type="button" class="btn" value=" "/></li>
							<li class="last-btn"><input type="button" class="btn last-btn" value=" "/></li>
						</ul>				
					</div>
				</div>
				<!-- end of book demo -->
				
				
			</div>
		</div>



<?php 
}
else
{
echo "Not access";
} } ?>

