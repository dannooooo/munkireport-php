<?php $this->view('partials/head'); ?>

<?php //Initialize models needed for the table
new Machine_model;
new Reportdata_model;
new Ard_model;
?>

<div class="container">

  <div class="row">

  	<div class="col-lg-12">

		  <h3><span data-i18n="listing.ard.title"></span> <span id="total-count" class='label label-primary'>…</span></h3>
		  
		  <table class="table table-striped table-condensed table-bordered">
		    <thead>
		      <tr>
		      	<th data-i18n="listing.computername" data-colname='machine#computer_name'></th>
		        <th data-i18n="serial" data-colname='machine#serial_number'></th>
		        <th data-i18n="listing.username" data-colname='reportdata#long_username'></th>
		        <th data-i18n="listing.ard.text" data-i18n-options='{"number":1}' data-colname='ard#Text1'></th>
		        <th data-i18n="listing.ard.text" data-i18n-options='{"number":2}' data-colname='ard#Text2'></th>
		        <th data-i18n="listing.ard.text" data-i18n-options='{"number":3}' data-colname='ard#Text3'></th>
		        <th data-i18n="listing.ard.text" data-i18n-options='{"number":4}' data-colname='ard#Text4'></th>
		      </tr>
		    </thead>
		    <tbody>
		    	<tr>
					<td data-i18n="listing.loading" colspan="7" class="dataTables_empty"></td>
				</tr>
		    </tbody>
		  </table>
    </div> <!-- /span 12 -->
  </div> <!-- /row -->
</div>  <!-- /container -->

<script type="text/javascript">

	$(document).on('appUpdate', function(e){

		var oTable = $('.table').DataTable();
		oTable.ajax.reload();
		return;

	});

	$(document).on('appReady', function(e, lang) {
		// Get column names from data attribute
		var myCols = [];
		$('.table th').map(function(){
			  myCols.push({'mData' : $(this).data('colname')});
		});
	    oTable = $('.table').dataTable( {
	        "aoColumns": myCols,
	        "sAjaxSource": "<?php echo url('datatables/data'); ?>",
	        "fnCreatedRow": function( nRow, aData, iDataIndex ) {
	        	// Update name in first column to link
	        	var name=$('td:eq(0)', nRow).html();
	        	if(name == ''){name = "No Name"};
	        	var sn=$('td:eq(1)', nRow).html();
	        	var link = get_client_detail_link(name, sn, '<?php echo url(); ?>/');
	        	$('td:eq(0)', nRow).html(link);

	        }
	    });
	});
</script>

<?php $this->view('partials/foot'); ?>